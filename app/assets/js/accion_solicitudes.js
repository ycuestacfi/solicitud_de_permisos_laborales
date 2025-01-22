// Función para mostrar el mensaje en el modal
function mostrarModal(mensaje) {
    console.log(mensaje)
    // Mostrar el modal
    const modal = document.getElementById("modalMensaje");
    const mensajeElement = document.getElementById("mensajeModal");
    
    // Establecer el mensaje del modal
    mensajeElement.textContent = mensaje;

    // Mostrar el modal
    modal.style.display = "block";
}

// Función para cerrar el modal
function cerrarModal() {
    const modal = document.getElementById("modalMensaje");
    modal.style.display = "none";
}

// Ejemplo de llamada a la función de mostrar el modal
//mostrarModal("Solicitud actualizada correctamente");

// function procesarSolicitud(accion, idSolicitud) {
//         // // Muestra qué acción se está tomando y sobre qué solicitud
//         // console.log(`Solicitud #${idSolicitud} ha sido ${accion === 'aceptar' ? 'aceptada' : 'rechazada'}`);

//         // // Lógica para procesar la acción (aceptar o rechazar)
//         // if (accion === 'aceptar') {
//         //     // Aquí puedes hacer la lógica para aceptar la solicitud
//         //     // Por ejemplo, llamar a una función para enviar los datos al servidor.
//         //     alert(`Solicitud #${idSolicitud} aceptada.`);
//         // } else if (accion === 'rechazar') {
//         //     // Aquí puedes hacer la lógica para rechazar la solicitud
//         //     // Por ejemplo, llamar a una función para enviar los datos al servidor.
//         //     alert(`Solicitud #${idSolicitud} rechazada.`);
//         // }

//         // Si necesitas hacer alguna actualización en la UI (por ejemplo, eliminar el botón de la solicitud):
//         // Eliminar la solicitud después de ser procesada (opcional)
//         // document.getElementById('solicitud' + idSolicitud).remove();

//         // Enviar la solicitud con fetch al controlador PHP
//         fetch('/solicitud_de_permisos_laborales/app/controller/solicitudController.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded',
//             },
//             body: `id_solicitud=${idSolicitud}&estado=${accion}`,
//         })
//         .then(response => response.text())  // Aquí tomamos el mensaje que retorna PHP
//         .then(mensaje => {
//             // Mostrar el mensaje en el modal
//             mostrarModal(mensaje);
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             mostrarModal("Error al actualizar el estado.");
//         });
        
//     }

// Función para enviar la solicitud con los datos
function procesarSolicitud(nuevoEstado, idSolicitud) {
    const datos = {
        idSolicitud: idSolicitud,
        nuevoEstado: nuevoEstado
    };

    fetch('/solicitud_de_permisos_laborales/app/controller/solicitudController.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json' // Indicar que estamos enviando JSON
        },
        body: JSON.stringify(datos) // Convertir el objeto JavaScript a formato JSON
    })
    .then(response => response.json()) // Convertir la respuesta a JSON
    .then(data => {
        if (data.error) {
            console.log('Error:', data.error);
        } else {
            console.log('Resultado:', data.resultado); // Mostrar el resultado que devolvió PHP

            // Aquí actualizamos el estado en el DOM automáticamente
            // Encontramos el span con el id 'estado_1' y cambiamos su contenido
            const estadoElemento = document.getElementById('estado_' + idSolicitud);
            if (estadoElemento) {
                estadoElemento.innerText = nuevoEstado;  // Cambiar el texto a 'Aprobado' o 'Rechazado'
            }
        }
    })
    .catch(error => {
        console.log('Error en la solicitud:', error);
    }); 
}