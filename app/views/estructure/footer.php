</main>

 <!-- <script>


function emailSend(){


var nombre_solicitante = document.getElementById('nombre').value;
var departamento_solicitante = document.getElementById('departamento').value;
var correo = document.getElementById('correo').value;
var fecha_solicitud = document.getElementById('fecha-de-solicitud').value;
var fecha_permiso = document.getElementById('fecha-de-permiso').value;
var tipo_permiso = document.getElementById('tipo-permiso').value;
var hora_de_salida = document.getElementById('hora-de-salida').value;
var hora_de_llegada = document.getElementById('hora-de-llegada').value;
var observaciones_solicitante = document.getElementById('observaciones').value;

var messageBody = "Nombre del solicitante: " + nombre_solicitante +
"<br/> Departamento al que pertenece: " + departamento_solicitante; +
 "<br/> Correo del solicitante: " + correo +
 "<br/> Fecha en que se genera la solicitud: " + fecha_solicitud +
 "<br/> Fecha del permiso:" + fecha_permiso +
 "<br/> tipo de permiso solicitado: " + tipo_permiso +
 "<br/> Hora de ingreso:" + hora_de_llegada +
 "<br/> Hora de salida: " + hora_de_salida +
 "<br/> observaciones: " + observaciones_solicitante
Email.send({
Host : "smtp.elasticemail.com",
Username : "ti@providenciacfi.com",
Password : "0EA8E6EE244DBC249C772AE90B372ECE63A2",
To : 'ycuesta@providenciacfi.com',
From : "ti@providenciacfi.com",
Subject : "This is the subject",
Body : messageBody
}).then(
message => {
  if(message=='OK'){
      swal("Felicidades.", "Su solicitud fue enviada correctamente!", "success");
  }
  else{
      swal("Error", "Solicitud cancelada!", "error");
  }
}
);
}

</script>  -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('contenedor-permiso');
        const selectedOption = document.getElementById('selected-option');
        const dropdownOptions = document.getElementById('select-options');
        const hiddenInput = document.getElementById('tipo-permiso');
        const envio_solicitud = document.getElementById('btn-enviar-permiso');
        const permiso_laboral = document.getElementById('permiso-laboral');

        // Toggle dropdown visibility
        selectedOption.addEventListener('click', () => {
            dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
        });

        // Handle option selection
        dropdownOptions.addEventListener('click', (event) => {
            if (event.target.tagName === 'LI') {
                const value = event.target.dataset.value;
                const text = event.target.textContent;

                // Set the selected value
                selectedOption.textContent = text;
                hiddenInput.value = value;

                // Hide the dropdown
                dropdownOptions.style.display = 'none';
                if (hiddenInput.value ==="laboral"){
                    envio_solicitud.style.display="none";
                    permiso_laboral.style.display="block";
                }else{
                    envio_solicitud.style.display="block";
                    permiso_laboral.style.display="none"
                }
            }
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdownOptions.style.display = 'none';
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Código para mostrar la alerta
        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                title: '<?= $_SESSION['message'] ?>',
                icon: '<?= $_SESSION['type'] ?>',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['message']); unset($_SESSION['type']); ?>
        <?php endif; ?>
    </script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://smtpjs.com/v3/smtp.js"></script>
  <script src="/solicitud.js"></script>
</body>
</html>