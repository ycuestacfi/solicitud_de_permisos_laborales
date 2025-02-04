function mostrarModal(accion, idSolicitud) {

    const M_accion = accion 
    accionPendiente = {
        accion,
        idSolicitud
    };

    const mensajeElement = document.getElementById('mensajeConfirmacion');
    const modalElement = document.getElementById('modalConfirmacion');

    if (mensajeElement && modalElement) {
        mensajeElement.textContent = `¿Estás seguro de que deseas ${M_accion} esta solicitud?`;
        modalElement.style.display = 'block';

    } else {
        console.error('Elementos del modal no encontrados');
    }
}

function cerrarModal() {
    const modalElement = document.getElementById('modalConfirmacion');
    if (modalElement) {
        modalElement.style.display = 'none';
    }
}

// Cerrar el modal si se hace clic fuera
document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("modalConfirmacion");

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            cerrarModal();
        }
    });
});

async function procesarSolicitudConConfirmacion() {
    let datos = accionPendiente;  // Datos que se envían al servidor

    try {
        let response = await fetch("/solicitud_de_permisos_laborales/app/controller/solicitudController.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",  // Enviar como JSON
                "Accept": "application/json"  // Aceptar respuesta en formato JSON
            },
            body: JSON.stringify({
                accion: "Procesar",  // Acción a procesar
                idSolicitud: datos.idSolicitud  // El id de la solicitud
            })
        });

        let responseData = await response.json();  // Obtener la respuesta en formato JSON
        console.log("Respuesta del servidor:", responseData);

        // Verificar si el proceso fue exitoso
        if (responseData.success) {
            Swal.fire({
                title: "Éxito",
                text: responseData.mensaje || "La solicitud se procesó correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar"
            }).then(() => {
                location.reload();  // Recargar la página si es necesario
            });
        } else {
            Swal.fire({
                title: "Error",
                text: responseData.mensaje || "Hubo un problema procesando la solicitud.",
                icon: "error"
            });
        }

    } catch (error) {
        console.error("Error en la solicitud:", error);
        Swal.fire({
            title: "Error",
            text: `Ocurrió un error: ${responseData}`,
            icon: "error"
        });
    }

    cerrarModal();
}