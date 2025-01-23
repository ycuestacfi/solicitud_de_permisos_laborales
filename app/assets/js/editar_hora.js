// Función para mostrar el selector de hora
function editarHora(action, id) {
    // Mostrar los elementos con la clase 'btn_accion_solicitud'
    let botonesAccion = document.querySelectorAll('.btn_accion_solicitud');
    botonesAccion.forEach(function(btn) {
        btn.style.display = 'inline-block'; // Mostrar
    });

    // Ocultar los elementos con la clase 'contenedor_accion_solicitud'
    let contenedoresAccion = document.querySelectorAll('.contenerdor_accion_solicitud');
    contenedoresAccion.forEach(function(contenedor) {
        contenedor.style.display = 'none'; // Ocultar
    });

    const horaSelector = document.getElementById("hora-selector-"+id);
    horaSelector.style.display = "inline-block";

    const btn = document.getElementById('btn_hora_'+id);
    btn.style.display = "none";

    // Establecer el rango del selector de hora
    const ahora = new Date();
    let horaActual = ahora.getHours();
    let minutoActual = ahora.getMinutes();

    let minHora = horaActual;
    if (minutoActual > 0) {
        minutoActual = 0;
        minHora = horaActual + 1;
    }

    // Agregar un evento para detectar clics fuera de los elementos
    document.addEventListener('click', function(event) {
        // Comprobar si el clic fue fuera del botón y el selector
        if (!horaSelector.contains(event.target) && !btn.contains(event.target)) {
            // Si fue fuera, ocultamos el selector y mostramos el botón
            horaSelector.style.display = 'none';
            btn.style.display = 'inline-block';
        }
    });
}

function ocultarFila() {
    const fila = document.getElementById("")
}

