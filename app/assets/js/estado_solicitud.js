let accionPendiente = null;

function mostrarModal(accion, solicitudId, identificador, nombre, cedula, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
    const acciones = {
        "aprobada": "Aprobar",
        "rechazada": "Rechazar",
        "eliminada": "Eliminar"
    };
    
    const M_accion = acciones[accion] || "Procesar";
    
    accionPendiente = {
        accion,
        solicitudId,
        identificador,
        nombre,
        cedula,
        email,
        tipo_permiso,
        fecha_permiso,
        hora_salida,
        hora_llegada,
        observaciones
    };

    const mensajeElement = document.getElementById('mensajeConfirmacion');
    const modalElement = document.getElementById('modalConfirmacion');
    const comentarioInput = document.getElementById('comentario'); // Input de comentario

    if (mensajeElement && modalElement) {
        mensajeElement.textContent = `¿Estás seguro de que deseas ${M_accion} esta solicitud?`;
        modalElement.style.display = 'block';

        if (accion === "eliminada") {
            comentarioInput.style.display = "block";
            comentarioInput.value = ""; // Limpiar el input antes de usarlo
            comentarioInput.required = true; // Hacer el campo obligatorio
        } else {
            comentarioInput.style.display = "block";
            comentarioInput.value = "";
            comentarioInput.required = false;
            btnConfirmar.disabled = false; // Habilitar el botón
        }

        // Agregar evento para activar/desactivar el botón
        comentarioInput.addEventListener("input", function () {
            btnConfirmar.disabled = comentarioInput.value.trim() === "";
        });
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

function realizarAccion() {
    if (!accionPendiente) {
        console.error('No hay acción pendiente para procesar');
        return;
    }
    
    const comentarioInput = document.getElementById('comentario').value; // Obtener el comentario

    // Validar si la acción es "eliminada" y el comentario está vacío
    if (accionPendiente.accion === "eliminada" && comentarioInput === "") {
        Swal.fire({
            title: "Comentario obligatorio",
            text: "Debes escribir un comentario antes de eliminar la solicitud.",
            icon: "warning",
            confirmButtonText: "Entendido"
        });
        return; // No continúa hasta que haya comentario
    }

    const { 
        accion, 
        solicitudId, 
        identificador, 
        nombre, 
        cedula, 
        email, 
        tipo_permiso, 
        fecha_permiso, 
        hora_salida, 
        hora_llegada, 
        observaciones 
    } = accionPendiente;

    procesarSolicitud(
        accion, 
        solicitudId, 
        identificador,
        nombre, 
        cedula, 
        email, 
        tipo_permiso, 
        fecha_permiso, 
        hora_salida, 
        hora_llegada, 
        observaciones,
        comentarioInput
    );

    cerrarModal();
}

async function procesarSolicitud(nuevoEstado, idSolicitud, identificador, nombre, cedula, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones, comentario) {
    const datos = {
        idSolicitud,
        identificador,
        nuevoEstado,
        nombre,
        cedula,
        email,
        tipo_permiso,
        fecha_permiso,
        hora_salida,
        hora_llegada,
        observaciones,
        comentario // Incluir el comentario en la petición
    };

    try {
        const response = await fetch('/solicitud_de_permisos_laborales/app/controller/solicitudController.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(datos)
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        // Espera una respuesta para verificar si el proceso fue exitoso
        const data = await response.json();

        // Si la respuesta es correcta, mostrar el mensaje de SweetAlert
        if (data.success) {
            Swal.fire({
                title: data.titulo,
                text: data.texto,
                icon: data.icono
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema procesando la solicitud.',
                icon: 'error'
            });
        }

        actualizarInterfaz(idSolicitud, nuevoEstado);

    } catch (error) {
        console.error('Error en la solicitud:', error);
        Swal.fire({
            title: 'Error',
            text: `Ocurrió un error: ${error.message}`,
            icon: 'error'
        });
    }
}

function actualizarInterfaz(idSolicitud, nuevoEstado) {
    const filaSolicitud = document.getElementById(`fila_${idSolicitud}`);
    const estadoElemento = document.getElementById(`estado_${idSolicitud}`);

    if (estadoElemento) {
        estadoElemento.innerText = nuevoEstado;
    }

    if (filaSolicitud) {
        filaSolicitud.style.transition = "opacity 0.5s ease-out";
        filaSolicitud.style.opacity = "0";
        setTimeout(() => filaSolicitud.remove(), 200);
    }
}

function mostrarNotificacion(mensaje, tipo) {
    alert(mensaje);
}

function procesarSolicitudConConfirmacion(accion, solicitudId, identificador, nombre, cedula, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
    mostrarModal(accion, solicitudId, identificador, nombre, cedula, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones);
}
