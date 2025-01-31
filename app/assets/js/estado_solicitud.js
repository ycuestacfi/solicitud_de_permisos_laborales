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

function realizarAccion() {
    if (!accionPendiente) {
        console.error('No hay acción pendiente para procesar');
        return;
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
        observaciones
    );

    cerrarModal();
}

async function procesarSolicitud(nuevoEstado, idSolicitud, identificador, nombre, cedula, email, tipo_permiso, fecha_permiso, hora_salida, hora_llegada, observaciones) {
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
        observaciones
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

        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }

        actualizarInterfaz(idSolicitud, nuevoEstado);

    } catch (error) {
        console.error('Error en la solicitud:', error);
        mostrarNotificacion(`Error: ${error.message}`, 'error');
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