<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /app/views/login.php ");
    exit();
}
if ($_SESSION['rol'] !== "seguridad" && $_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php ");
    exit();
}

include_once './estructure/head.php'?>
        
        <section id="fondo-form" >
            <div id="fondo-formulario">
                <form  method="POST"  id="formulario-aprovacion">
                    <h1>Formulario De Solicitud</h1>
    
                    <input type="number" id="id_solicitud" name="id_solicitud">
                    
                    <button type="submit" id="btn-enviar">Enviar solicitud</button>
                </form>
            </div>
            <figure id="contenedor-logo">
                <img src="/assets/img/logoOficial.png" alt="">
            </figure>
        </section>
        
<?php include_once './estructure/footer.php'?>