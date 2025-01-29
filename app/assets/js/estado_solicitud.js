let accionPendiente = null;  // Variable global para guardar la acción pendiente

// Función para mostrar la modal de confirmación
function mostrarModal(accion, solicitudId, identificador,nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
    let M_accion = "";
    if (accion === "aprobada") {
        M_accion = "Aprobadar";
    } else if (accion === "rechazada") {
        M_accion = "Rechazar";
    } else if (accion === "eliminada") {
        M_accion = "Eliminar";
    }
    accionPendiente = { accion: accion, solicitudId: solicitudId , identificador: identificador,nombre: nombre, email: email, tipo_permiso: tipo_permiso, fecha_permiso: fecha_permiso, hora_salida: hora_salida, hora_llegada: hora_llegada, observaciones: observaciones};  // Guardamos la acción pendiente
    document.getElementById('mensajeConfirmacion').textContent = `¿Estás seguro de que deseas ${M_accion} esta solicitud?`;
    document.getElementById('modalConfirmacion').style.display = 'block';  // Mostrar el modal
}

// Función para cerrar la modal
function cerrarModal() {
    document.getElementById('modalConfirmacion').style.display = 'none';  // Ocultar el modal
}

// Función para realizar la acción confirmada
function realizarAccion() {
    if (accionPendiente) {
        // Extraemos la acción y el id de la solicitud desde la variable global
        const { accion, solicitudId, identificador, nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones } = accionPendiente;

        // Llamamos a la función procesarSolicitud para enviar la acción al backend
        procesarSolicitud(accion, solicitudId, identificador,nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones);

        // Cerrar la modal después de realizar la acción
        cerrarModal();
    }
}

// Función para enviar la solicitud con los datos
function procesarSolicitud(nuevoEstado, idSolicitud, identificador,nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
    const datos = {
        idSolicitud: idSolicitud,
        identificador: identificador,
        nuevoEstado: nuevoEstado, 
        nombre: nombre, 
        email: email, 
        tipo_permiso: tipo_permiso, 
        fecha_permiso: fecha_permiso, 
        hora_salida: hora_salida, 
        hora_llegada: hora_llegada, 
        observaciones: observaciones
    };

    fetch('/solicitud_de_permisos_laborales/app/controller/solicitudController.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.log('Error:', data.error);
        } else {
            console.log('Resultado:', data.resultado);

            // Actualizar el estado en el DOM
            const estadoElemento = document.getElementById('estado_' + idSolicitud);
            if (estadoElemento) {
                estadoElemento.innerText = nuevoEstado;
            }

            // Ocultar la fila de la tabla después de la acción
            const filaSolicitud = document.getElementById('fila_' + idSolicitud);
            if (filaSolicitud) {
                filaSolicitud.style.transition = "opacity 0.5s ease-out"; // Efecto de desvanecimiento
                filaSolicitud.style.opacity = "0";
                setTimeout(() => {
                    filaSolicitud.remove(); // Eliminar después del desvanecimiento
                }, 700);
            }
        }
    })
    .catch(error => {
        console.log('Error en la solicitud:', error);
    }); 
}

// Función para llamar la modal antes de realizar la acción
function procesarSolicitudConConfirmacion(accion, solicitudId, identificador, nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
    mostrarModal(accion, solicitudId, identificador,nombre, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones);
}