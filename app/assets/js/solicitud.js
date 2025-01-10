// function emailSend() {
//     var nombre_solicitante = document.getElementById('nombre').value;
//     var departamento_solicitante = document.getElementById('departamento').value;
//     var correo = document.getElementById('correo').value;
//     var fecha_solicitud = document.getElementById('fecha-de-solicitud').value;
//     var fecha_permiso = document.getElementById('fecha-de-permiso').value;
//     var tipo_permiso = document.getElementById('tipo-permiso').value;
//     var hora_de_salida = document.getElementById('hora-de-salida').value;
//     var hora_de_llegada = document.getElementById('hora-de-llegada').value;
//     var observaciones_solicitante = document.getElementById('observaciones').value;

//     var messageBody = "Nombre del solicitante: " + nombre_solicitante +
//         "<br/> Departamento al que pertenece: " + departamento_solicitante +
//         "<br/> Correo del solicitante: " + correo +
//         "<br/> Fecha en que se genera la solicitud: " + fecha_solicitud +
//         "<br/> Fecha del permiso:" + fecha_permiso +
//         "<br/> Tipo de permiso solicitado: " + tipo_permiso +
//         "<br/> Hora de ingreso: " + hora_de_llegada +
//         "<br/> Hora de salida: " + hora_de_salida +
//         "<br/> Observaciones: " + observaciones_solicitante;

//     Email.send({
//         Host: "smtp.elasticemail.com",
//         Port: 2525,
//         // Username: "ti@providenciacfi.com",
//         Username: "yefercuesta123@gmail.com",
//         // Password: "0EA8E6EE244DBC249C772AE90B372ECE63A2",
//         Password: "88C4C0637903F9495CE2F2E811C26F8536DA",

//         To: 'yefercuesta123@gmail.com',
//         From: "yefercuesta123@gmail.com",
//         Subject: "Solicitud de Permiso",
//         Body: messageBody
//     }).then(
//         message => {
//             if(message=='OK'){
//                 swal("Felicidades.", "Su solicitud fue enviada correctamente!", "success");
//             } else {
//                 swal("Error", "Solicitud cancelada!", "error");
//             }
//         }
//       );
//       }
      
document.addEventListener('DOMContentLoaded', () => {
    let tipo_permiso = document.getElementById('tipo-permiso').value;
    alert(tipo_permiso);
});