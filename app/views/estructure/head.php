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
    <link rel="stylesheet" href="/assets/css/aprovacion.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/solicitud.css">

    <!-- <link rel="stylesheet" href="solicitud.js"> -->
    <title>Centro de formacion providencia || Solicitud de permisos laborales</title>
</head>
<body>
    <header>
        <nav>
        
            <ul> 
                <p>Tipos de solicitudes</p>

                <?php if ($_SESSION['rol']='lider_aprobador' ): ?>
                <li><a href="solicitudes_pendientes.html">Pendientes</a></li>
                 <?php endif; ?>
                 
                <li><a href="aprovadas.html">Aprovadas</a></li>
                <li><a href="rechazadas.html">Rechazadas</a></li>
                
            </ul>
            <a href="/controller/cierre_de_sesion.php" id="btn_salir">
                Cerrar sesión
            </a>
        </nav>
    </header>
    <main>