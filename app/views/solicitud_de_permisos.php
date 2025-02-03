<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../controller/departamentoController.php';
include_once '../controller/solicitudController.php';
$solicitudController = new SolicitudController();
if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /Sdp/app/views/login.php ");
    exit();
}

$departamentocontroler = new departamentoControler();

date_default_timezone_set('America/Bogota');

// Obtener la fecha actual
$fechaActual = new DateTime();

// Formatear la fecha actual en el formato 'YYYY-MM-DD'
$fechaActualFormato = $fechaActual->format('Y-m-d');
$fechaActualFormatoHora = $fechaActual->format('Y-m-d H:i:s');

// Obtener la fecha dentro de 30 días
$fechaDentro30Dias = new DateTime();
$fechaDentro30Dias->modify('+30 days');

// Formatear la fecha dentro de 30 días en el formato 'YYYY-MM-DD'
$fechaDentro30DiasFormato = $fechaDentro30Dias->format('Y-m-d');

$id_departamento = $_SESSION['id_departamento'];
$departamentos = $departamentocontroler->getDepartamentodata($id_departamento);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Estructura HTML5</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="/Sdp/app/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <main>
    <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<script>
                Swal.fire({
                    title: '" . $_SESSION['mensaje']['titulo'] . "',
                    text: '" . $_SESSION['mensaje']['texto'] . "',
                    icon: '" . $_SESSION['mensaje']['icono'] . "'
                });
            </script>";
            unset($_SESSION['mensaje']); // Limpiar la sesión después de mostrar la alerta
        }    
    ?>
    <section id="navigation">
        <nav>
            <figure style="margin:0; padding:0; width:150px;">
                <a href="dashboard.php"><img src="/Sdp/app/assets/img/logocfipblanco.png" style="width: 100%;" alt=""></a>
            </figure>
            <div id="btn_menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
            
            <ul id="menu">
                
                <?php 
                if ($_SESSION['rol'] == "lider_aprobador" || $_SESSION['rol'] == "administrador" || $_SESSION['rol'] == "TI"){
                    echo '<li><a href="dashboard.php">Inicio</a></li>';
                }?>
                
                <li><a href="solicitudes.php">Mis solicitudes</a></li>
                <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
                
                <?php 
                if ($_SESSION['rol'] == 'administrador' || $_SESSION['rol'] == "TI"){
                    echo '<li><a href="departamentos.php">Departamentos</a></li>';
                    echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                    echo '<li><a href="historico.php"> Historico </a></li>';
                }?>
                <?php 
                if ($_SESSION['rol'] == 'seguridad' || $_SESSION['rol'] == "TI"){
                    echo '<li><a href="solicitudes_hora_ingreso.php"> solicitudes hoy </a></li>'; 
                }?>
                
                <li><a href="/Sdp/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
            </ul>
        </nav>
    </section>
    <section id="fondo-form" >
        <form action="/Sdp/app/controller/solicitudController.php" method="POST" id="formulario-solicitud" >  
                
            <input 
            value="<?php echo $_SESSION['rol']; ?>" 
            type="hidden" name="rol" id="rol" required>

            <h1 id="title_form">Formulario De Solicitud</h1>

            <input class="input_solicitud" 
            placeholder="Ejemplo: Juan Pérez" 
            value="<?php echo $_SESSION['nombres'] ,' ', $_SESSION['apellidos']; ?>" 
            type="text" name="nombre" id="nombre" 
            title="Rellene el campo con su Nombre y Apellido"  
            pattern="[A-Za-z\s]{2,}" minlength="2" required readonly>

            <input class="input_solicitud" 
            type="email" id="correo" 
            value="<?php echo $_SESSION['correo']; ?>" 
            name="email" 
            placeholder="Introduce tu correo electrónico" 
            title="Introduce un correo electrónico válido" 
            required readonly> 

            <input class="input_solicitud" 
            type="hidden" id="cedula" 
            value="<?php echo $_SESSION['cedula']; ?>" 
            name="cedula" 
            required>    

            <input type="text" name="departamento" id="departamento" 
            value="<?php echo $_SESSION['id_departamento']; ?>" 
            required readonly hidden />

            <input class="input_solicitud" 
            type="datetime" id="fecha_de_solicitud" 
            name="fecha_de_solicitud" 
            value="<?php echo $fechaActualFormatoHora; ?>"
            hidden>

            <input class="input_solicitud" 
            placeholder="Selecciona la fecha del permiso" 
            type="date" id="fecha_de_permiso" 
            name="fecha_de_permiso" 
            title="Selecciona la fecha del permiso solicitado" 
            max="<?php echo $fechaDentro30DiasFormato; ?>"
            min="<?php echo $fechaActualFormato; ?>"
            required>

            <input class="input_solicitud" 
            placeholder="Ejemplo: 07:00 a.m" 
            type="time" id="hora_de_salida" 
            name="hora_de_salida" 
            title="Indica la hora de salida" 
            required 
            min="07:00" 
            max="16:00">

            <input class="input_solicitud" 
            placeholder="Ejemplo: 4:00 p.m" 
            type="time" id="hora_de_llegada" 
            name="hora_de_llegada" 
            title="Indica la hora de llegada" 
            required    
            min="07:00" 
            max="16:00">

            <textarea class="input_solicitud" 
            placeholder="Agrega observaciones adicionales aquí" 
            name="observaciones" id="observaciones" 
            title="Escribe cualquier observación relevante"></textarea>

            <label for="evidencias" id="label_file"> 
                <i class="lni lni-file-plus-circle"></i>
                ¿Deseas cargar una evidencia? 
            </label>

            <input type="file" hidden name="evidencias" class="input_solicitud" 
                id="evidencias" 
                title="Solo se permiten archivos PDF o imágenes (JPEG, PNG, GIF).">

            <div id="contenedor-permiso" class="contenedor-permiso">
                <div id="selected-option" class="selected-option">Seleccione un tipo de permiso</div>
                <ul id="select-options" class="select-options">
                    <li data-value="personal">Personal</li>
                    <li data-value="cita medica">Cita Médica</li>
                    <li data-value="calamidad domestica">Calamidad Doméstica</li>
                    <li data-value="estudio">Estudio</li>
                    <li data-value="laboral">Laboral</li>
                </ul>
                <input type="hidden" name="tipo_permiso" id="tipo_permiso" />
            </div>
            <button type="submit" id="btn-enviar-permiso">Enviar solicitud</button>

                <div id="permiso-laboral" class="permiso-laboral">

                <input class="input_solicitud" 
                type="text" name="motivo_del_desplazamiento" 
                required id="motivo_del_desplazamiento" 
                placeholder="¿Cuál es el motivo de tu salida?" 
                title="Indica el motivo de tu salida">

                <label for="departamento">Departamento de desplazamiento:</label>
                <select class="input_solicitud" id="departamento_de_desplazamiento" name="departamento_de_desplazamiento" required>
                    <option value="">Seleccione un departamento</option>
                   
                </select>
            
                <label for="municipio">Municipio de desplazamiento:</label>
                <select class="input_solicitud" style="color:black;" id="municipio_del_desplazamiento" name="municipio_del_desplazamiento" required disabled>
                    <option value="">Seleccione un municipio</option>
                    
                </select>

                <input type="text" class="input_solicitud" 
                    placeholder="¿Cuál es tu lugar de desplazamiento?" 
                    required id="lugar_desplazamiento" 
                    name="lugar_desplazamiento" 
                    title="Indica el lugar al que te desplazas"> 

                <!-- Select de Medio de Transporte -->
                <div id="medio-transporte-contenedor" class="contenedor-permiso">
                    <div id="medio-transporte-seleccion" class="selected-option">Seleccione un medio de transporte</div>
                    <ul id="medio-transporte-opciones" class="select-options">
                        <li data-value="MOTOCICLETA">Motocicleta</li>
                        <li data-value="AUTOMOVIL">Automóvil</li>
                        <li data-value="TRANSPORTE PUBLICO">Transporte Público</li>
                        <li data-value="AVION">Avión</li>
                    </ul>
                    <input type="hidden"  name="medio_de_transporte" id="medio_de_transporte" /> 
                </div>

                Campo de Placa de Vehículo
                <input 
                    type="text" 
                    class="input_solicitud" 
                    placeholder="Ingrese la placa de su vehículo (si aplica)" 
                    id="placa_vehiculo" 
                    name="placa_vehiculo" 
                    title="Indica la placa de tu vehículo (si aplica)" />

                <button type="submit" id="btn-enviar-permiso-laboral">Enviar solicitud</button>
                
            </div> 
        </form>

        <div id="fondo-formulario">
        
        </div>
        <!-- <figure id="contenedor-logo">
            <img src="/app/assets/img/logoOficial.png" alt="">
        </figure> -->
    </section>
         
    </main>

    <footer >
        <p>&copy; 2024 Copyright: Aviso de privacidad, Términos y condiciones. Todos los derechos reservados.</p>
    </footer>
    <script src="/Sdp/app/assets/js/accion_solicitudes.js"></script>
    <script src="/Sdp/app/assets/js/main.js"></script>
    <script src="/Sdp/app/assets/js/menu.js"></script>

</body>
</html>