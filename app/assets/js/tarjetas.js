// Función para detectar si es móvil y transformar filas en tarjetas
function transformarTablaAMovil() {
    const breakpoint = 768; // Ancho máximo para considerar como móvil
    const tabla = document.getElementById('tabla_registros');
    const contenedorTabla = document.querySelector('.tabla_registro');

    if (window.innerWidth <= breakpoint && tabla) {
        const filas = tabla.querySelectorAll('tbody tr');
        const tarjetasContainer = document.createElement('div');
        tarjetasContainer.classList.add('tarjetas-container');

        filas.forEach(fila => {
            const columnas = fila.querySelectorAll('td');
            if (columnas.length > 0) {
                const tarjeta = document.createElement('div');
                tarjeta.classList.add('tarjeta');

                // Creamos el encabezado de la tarjeta
                const header = document.createElement('div');
                header.classList.add('tarjeta-header');
                header.textContent = columnas[0].textContent; // Usamos la primera columna como encabezado
                tarjeta.appendChild(header);

                // Creamos el cuerpo de la tarjeta
                const body = document.createElement('div');
                body.classList.add('tarjeta-body');
                body.style.display = 'none'; // Ocultamos inicialmente

                columnas.forEach((columna, index) => {
                    if (index > 0) { // Procesamos todas las columnas excepto la primera
                        const titulo = tabla.querySelector(`thead th:nth-child(${index + 1})`).textContent;

                        const item = document.createElement('div');
                        item.classList.add('tarjeta-item');

                        const tituloElemento = document.createElement('div');
                        tituloElemento.classList.add('tarjeta-item-titulo');
                        tituloElemento.textContent = titulo; // Título arriba

                        const contenidoElemento = document.createElement('div');
                        contenidoElemento.classList.add('tarjeta-item-contenido');
                        contenidoElemento.innerHTML = columna.innerHTML; // Copia el contenido HTML de la celda

                        item.appendChild(tituloElemento);
                        item.appendChild(contenidoElemento);
                        body.appendChild(item);
                    }
                });

                tarjeta.appendChild(body);

                // Añadimos evento para expandir/contraer
                header.addEventListener('click', () => {
                    const isVisible = body.style.display === 'block';
                    body.style.display = isVisible ? 'none' : 'block';
                });

                tarjetasContainer.appendChild(tarjeta);
            }
        });

        contenedorTabla.innerHTML = ''; // Limpiamos el contenedor original
        contenedorTabla.appendChild(tarjetasContainer); // Añadimos las tarjetas
    }
}

// Escuchar el evento de cambio de tamaño para reactivar la transformación
window.addEventListener('resize', transformarTablaAMovil);

// Llamar a la función al cargar la página
window.addEventListener('DOMContentLoaded', transformarTablaAMovil);
