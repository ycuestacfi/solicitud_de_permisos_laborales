<?php
session_start();
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
                 
                <li><a href="solicitudes_aprovadas.html">Aprovadas</a></li>
                <li><a href="solicitudes_rechazadas.html">Rechazadas</a></li>
                
            </ul>
            <button id="btn_salir">
                Cerrar sesión
            </button>
        </nav>
    </header>
    <main>