function editarHora(id) {
    // Mostrar el modal
    const modal = document.getElementById('horaModal');
    modal.style.display = 'block';
    
    // Establecer el ID de la solicitud en el formulario
    document.getElementById('modal_id_solicitud').value = id;
    
    // Establecer hora por defecto
    const ahora = new Date();
    let horaActual = ahora.getHours();
    let minutos = ahora.getMinutes();
    
    // Asegurarse de que la hora esté dentro del rango permitido (7am - 4pm)
    if (horaActual < 7) horaActual = 7;
    if (horaActual > 16) horaActual = 16;
    
    const horaFormateada = `${String(horaActual).padStart(2, '0')}:${String(minutos).padStart(2, '0')}`;
    document.getElementById('hora-input').value = horaFormateada;
}

function cerrarModal() {
    const modal = document.getElementById('horaModal');
    modal.style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('horaModal');
    if (event.target === modal) {
        cerrarModal();
    }
}

// Manejar el envío del formulario
document.getElementById('formEditarHora').onsubmit = function(e) {
    const idSolicitud = document.getElementById('modal_id_solicitud').value;
    const fila = document.getElementById(`fila_${idSolicitud}`);
    
    if (fila) {
        // Efecto de desvanecimiento
        fila.style.transition = 'opacity 0.5s ease-out';
        fila.style.opacity = '0';
        setTimeout(() => {
            fila.remove();
        }, 500);
    }
}
