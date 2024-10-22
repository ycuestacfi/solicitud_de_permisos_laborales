<?php
session_start();


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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- <link rel="stylesheet" href="solicitud.js"> -->
    <title>Centro de formacion providencia || Solicitud de permisos laborales</title>
</head>
<body>
    <header>
        <nav>
        
            <ul> 
                <p>Tipos de solicitudes</p>
                <?php
                $rol = $_SESSION["rol"];

                if ($rol === 'administrador') {
                    echo '<li><a href="register.php">Pendientes</a></li>';
                    }

                if ($rol === 'lider_aprobador') {
                echo '<li><a href="solicitudes_pendientes.php">Pendientes</a></li>';
                }
                ?>
                 
                <li><a href="aprovadas.php">Aprovadas</a></li>
                <li><a href="rechazadas.php">Rechazadas</a></li>
                
            </ul>
            <a href="/cierre_de_sesion.php" id="btn_salir">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <main>