<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/solicitud.css">
    <link rel="stylesheet" href="/assets/css/global.css">

    <?php $load_css = false; ?>
    <?php if ($load_css): ?>
    <link rel="stylesheet" href="/assets/css/prueba.css"> 
    <?php endif; ?>
    
    <title>Centro de formacion providencia || Solicitud de permisos laborales</title>
</head>
<body>
    <main>

        

        <section id="fondo-form" >
            <div id="fondo-formulario">
                <form action="https://formsubmit.co/efc8028f1cfa38148558f5c9cc1e98df" method="POST"  id="formulario-solicitud">
                  
                    <h1>Formulario De Solicitud</h1>
                    <p>
                         <?php echo $emailcode; ?>
                    </p>
                   
                    <input class="input_solicitud" placeholder="Nombre y Apellido" type="text" name="nombre" id="nombre" title="rellene el campo con su Nombre y Apellido"  pattern="[A-Za-z\s]{2,}"  minlength="2" required>
    
                    
                    <input class="input_solicitud" placeholder="Correo" type="email" id="correo" name="email" required>
                    
    
                    <label for="tipo-permiso" class="input-d">Seleccione el departamento al que pertenece</label>
                    <select class="input_solicitud" name="departamento" id="departamento" required>
                        <option class="optiones" value="Talento Humano">Talento Humano</option>
                        <option class="optiones" value="Contabilidad">Contabilidad</option>
                        <option class="optiones" value="Tecnologia Informatica">Tecnologia Informatica</option>
                        <option class="optiones" value="Comercial">Comercial</option>
                        <option class="optiones" value="Producción">Producción</option>
                        <option class="optiones" value="Almacen y logistica">Almacen y Logistica</option>
                        <option class="optiones" value="Big bag">Big Bag</option>
                        <option class="optiones" value="Academicas">Academicas</option>
                    </select>
    
                    
                    <input class="input_solicitud" placeholder="Fecha de Solicitud" type="date" id="fecha-de-solicitud" name="fecha-de-solicitud" required >
    
                    
                    <input class="input_solicitud" placeholder="Fecha del permiso" type="date" id="fecha-de-permiso" name="fecha-de-permiso" required>
    
                    <label for="tipo-permiso" class="input-d">Seleccione un tipo de Permiso</label>
                    <select class="input-d input_solicitud" name="tipo-permiso" id="tipo-permiso" required>
                        <option class="optiones" value="personal">Personal</option>
                        <option class="optiones" value="cita-medica" color="red">Cita Medica</option>
                        <option class="optiones" value="calamidad-domestica">Calamidad Domestica</option>
                        <option class="optiones" value="estudio">Estudio</option>
                        <option class="optiones" value="laboral">Laboral</option>
                    </select>
    
                    
                    <input class="input-d input_solicitud" placeholder="Hora de salida" type="time" id="hora-de-salida" name="hora-de-salida" required>
    
                    
                    <input class="input-d input_solicitud" placeholder="Hora de llegada" type="time" id="hora-de-llegada" name="hora-de-llegada" required>
    
                    
                    <textarea  class="input-d input_solicitud" placeholder="Observaciones" name="observaciones" id="observaciones" required></textarea>
    
                    <button type="submit" id="btn-enviar">Enviar solicitud</button>
                </form>
            </div>
            <figure id="contenedor-logo">
                <img src="/assets/img/logoOficial.png" alt="">
            </figure>
        </section>
        
    <!-- <form onsubmit="emailSend(); reset(); return false;" id="formulario-solicitud">
        <h1>Formulario De Solicitud</h1>

        <label for="nombre">Nombre y Apellido</label>
        <input type="text" name="nombre" id="nombre" title="rellene el campo con su Nombre y Apellido"  pattern="[A-Za-z\s]{2,}"  minlength="2" required>

        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="departamento">Departamento</label>
        <select name="departamento" id="departamento" required>
            <option value="Talento Humano">TTHH</option>
            <option value="Contabilidad">Contabilidad</option>
            <option value="Tecnologia Informatica">Tecnologia Informatica</option>
            <option value="Comercial">Comercial</option>
            <option value="Producción">Producción</option>
            <option value="Almacen y logistica">Almacen y Logistica</option>
            <option value="Big bag">Big Bag</option>
            <option value="Academicas">Academicas</option>
        </select>

        <label for="">Fecha de Solicitud</label>
        <input type="date" id="fecha-de-solicitud" name="fecha-de-solicitud" required >

        <label for="">Fecha del permiso</label>
        <input type="date" id="fecha-de-permiso" name="fecha-de-permiso" required>

        <label for="tipo-permiso">Tipo de Permiso</label>
        <select name="tipo-permiso" id="tipo-permiso" required>
            <option value="personal">Personal</option>
            <option value="cita-medica">Cita Medica</option>
            <option value="calamidad-domestica">Calamidad Domestica</option>
            <option value="estudio">Estudio</option>
            <option value="laboral">Laboral</option>
        </select>

        <label for="hora-de-salida">Hora de salida</label>
        <input type="datetime" id="hora-de-salida" name="hora-de-salida" required>

        <label for="hora-de-salida">Hora de llegada</label>
        <input type="datetime" id="hora-de-llegada" name="hora-de-llegada" required>

        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" required></textarea>

        <button type="submit">Enviar solicitud</button>
    </form> -->
</main>
<script src="/solicitud.js"></script>
<!-- <script>


function emailSend(){


var nombre_solicitante = document.getElementById('nombre').value;
var departamento_solicitante = document.getElementById('departamento').value;
// var correo = document.getElementById('correo').value;
// var fecha_solicitud = document.getElementById('fecha-de-solicitud').value;
// var fecha_permiso = document.getElementById('fecha-de-permiso').value;
// var tipo_permiso = document.getElementById('tipo-permiso').value;
// var hora_de_salida = document.getElementById('hora-de-salida').value;
// var hora_de_llegada = document.getElementById('hora-de-llegada').value;
// var observaciones_solicitante = document.getElementById('observaciones').value;

var messageBody = "Nombre del solicitante: " + nombre_solicitante +
"<br/> Departamento al que pertenece: " + departamento_solicitante; 
// +
// "<br/> Correo del solicitante: " + correo +
// "<br/> Fecha en que se genera la solicitud: " + fecha_solicitud +
// "<br/> Fecha del permiso:" + fecha_permiso +
// "<br/> tipo de permiso solicitado: " + tipo_permiso +
// "<br/> Hora de ingreso:" + hora_de_llegada +
// "<br/> Hora de salida: " + hora_de_salida +
// "<br/> observaciones: " + observaciones_solicitante
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

</script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://smtpjs.com/v3/smtp.js"></script>
    
</body>
</html>