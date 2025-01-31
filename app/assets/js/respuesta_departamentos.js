// function handleSubmit(event) {
//     event.preventDefault();
//     let formData = new FormData(event.target);
    
//     fetch("/solicitud_de_permisos_laborales/app/controller/departamentoController.php", {
//         method: "POST",
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         // Usa directamente los datos del JSON
//         Swal.fire({
//             title: data.title,
//             text: data.message,
//             icon: data.status,
//             confirmButtonText: 'Aceptar'
//         }).then(() => {
//             if (data.status === 'success') {
//                 location.reload();
//             }
//         });
//     })
//     .catch(error => {
//         Swal.fire({
//             title: 'Error de Conexión',
//             text: 'No se pudo procesar la solicitud',
//             icon: 'error',
//             confirmButtonText: 'Aceptar'
//         });
//     });
// }