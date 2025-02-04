// Mostrar el modal para subir evidencia
function mostrarModalSubirEvidencia(solicitudId) {
    const modal = document.getElementById('modalSubirEvidencia');
    document.getElementById('identificador_solicitud').value = solicitudId; // Establecer el ID de la solicitud
    modal.style.display = 'block'; // Mostrar el modal
}

function mensaje() {
    Swal.fire({
        title: "Evidencia",
        text: "La solicitud ya paso su fecha disponible para subir la evidencia",
        icon: "warning",
        confirmButtonText: "Entendido"
    });
    return; // No continúa hasta que haya comentario
}

function abrirModalComentario(comentario) {
    let mensaje = comentario && comentario.trim() !== "" 
        ? comentario 
        : "No se ha generado ningún comentario del líder para esta solicitud.";

    Swal.fire({
        title: "Comentario del Líder",
        text: mensaje,
        icon: "info",
        confirmButtonText: "Cerrar",
        confirmButtonColor: "#3085d6"
    });
}

// Función para cerrar el modal
function cerrarModalSubirEvidencia() {
    const modal = document.getElementById('modalSubirEvidencia');
    modal.style.display = 'none'; // Ocultar el modal
}

// Mostrar el modal para ver evidencia
function verEvidencia(rutaEvidencia) {
    const modal = document.getElementById('modalVerEvidencia');
    const imagenEvidencia = document.getElementById('imagenEvidencia');
    imagenEvidencia.src = rutaEvidencia; // Establecer la ruta de la imagen de evidencia
    modal.style.display = 'block'; // Mostrar el modal
}

// Función para cerrar el modal de ver evidencia
function cerrarModalVerEvidencia() {
    const modal = document.getElementById('modalVerEvidencia');
    modal.style.display = 'none'; // Ocultar el modal
}