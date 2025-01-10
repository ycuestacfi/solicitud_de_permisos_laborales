<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /app/views/login.php ");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/assets/css/aprovacion.css">
    <link rel="stylesheet" href="/app/assets/css/global.css">
    <link rel="stylesheet" href="/app/assets/css/solicitud.css">
    <link rel="stylesheet" href="/app/assets/css/registro_usuarios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- iconos -->
    <link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="solicitud.js"> -->
    <title>Centro de formacion providencia || Solicitud de permisos laborales</title>
</head>
<body>
    <header>
        <nav>
        
            <ul> 
                <p>Tipos de solicitudes</p>

                <?php
               
                if ($_SESSION["rol"] === 'administrador') {
                    echo '<li><a href="register.php">Registrar usuario</a></li>';
                    }
                ?>
                
                <li><a href="solicitudes.php">Mis solicitudes</a></li>
                
                <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
                <li><a href="dashboard.php">inicio</a></li>
                <li><a href="rechazadas.php">Rechazadas</a></li>
                
            </ul>
            <a href="/cierre_de_sesion.php" id="btn_salir">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <main>