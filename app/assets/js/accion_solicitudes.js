document.addEventListener('DOMContentLoaded', () => {
    const departamentoSelect = document.getElementById('departamento_de_desplazamiento');
    const municipioSelect = document.getElementById('municipio_del_desplazamiento');
    
    // URL base de la API
    const apiBaseUrl = 'https://api-colombia.com/api/v1';
    
    // Cargar departamentos al iniciar
    fetch(`${apiBaseUrl}/Department`)
    .then(response => response.json())
    .then(departamentos => {
        departamentos.forEach(departamento => {
            const option = document.createElement('option');
            option.value = departamento.name; // El value será el nombre del departamento
            option.textContent = departamento.name; // Texto visible será el nombre
            option.setAttribute('data-id', departamento.id); // Agregamos el ID como atributo data-id
            option.style.color ='black';
            departamentoSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error al cargar departamentos:', error));

    // Cargar municipios al seleccionar un departamento
    departamentoSelect.addEventListener('change', () => {
    const departamentoName = departamentoSelect.value; // Aquí el value es el nombre del departamento

    // Reiniciar el select de municipios
    municipioSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
    municipioSelect.disabled = true;

    // Obtener el ID del departamento seleccionado (buscando en la lista cargada si es necesario)
    const departamentoSeleccionado = [...departamentoSelect.options].find(
        option => option.value === departamentoName
    );

    if (departamentoSeleccionado) {
        const departamentoId = departamentoSeleccionado.getAttribute('data-id'); // Extraer el ID del atributo data-id

        if (departamentoId) {
            fetch(`${apiBaseUrl}/Department/${departamentoId}/cities`)
                .then(response => response.json())
                .then(municipios => {
                    municipios.sort((a, b) => a.name.localeCompare(b.name));
                    municipios.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.name; // Aquí el value es el nombre del municipio
                        option.textContent = municipio.name;
                        option.style.color = 'black';
                        municipioSelect.appendChild(option);
                    });
                    municipioSelect.disabled = false;
                })
                .catch(error => console.error('Error al cargar municipios:', error));
        }
    }
    });
    
    const tipoPermisoInput = document.getElementById('tipo_permiso');
    const permisoLaboralContainer = document.getElementById('permiso-laboral');
    const camposLaborales = permisoLaboralContainer.querySelectorAll('.input_solicitud');

    const selectOptions = document.getElementById('select-options');
    const selectedOption = document.getElementById('selected-option');

    // Inicialmente ocultamos el contenedor de "Laboral"
    permisoLaboralContainer.style.display = 'none';

    // Escuchar cuando una opción del selector sea clicada
    selectOptions.addEventListener('click', (event) => {
        if (event.target.tagName === 'LI') {
            const valorSeleccionado = event.target.dataset.value;
            tipoPermisoInput.value = valorSeleccionado;
            selectedOption.textContent = event.target.textContent;

            if (valorSeleccionado === 'laboral') {
                // Mostrar los campos laborales y hacerlos requeridos
                permisoLaboralContainer.style.display = 'block';
                camposLaborales.forEach(campo => {
                    campo.setAttribute('required', true);
                });
            } else {
                // Ocultar los campos laborales y quitarles el atributo requerido
                permisoLaboralContainer.style.display = 'none';
                camposLaborales.forEach(campo => {
                    campo.removeAttribute('required');
                });
            }
        }
    });

    // Cerrar el menú desplegable al hacer clic fuera de él
    document.addEventListener('click', (event) => {
        if (!document.getElementById('contenedor-permiso').contains(event.target)) {
            selectOptions.classList.remove('active');
        }
    });

    // Mostrar/ocultar opciones al hacer clic en el div principal
    selectedOption.addEventListener('click', () => {
        selectOptions.classList.toggle('active');
    });

});