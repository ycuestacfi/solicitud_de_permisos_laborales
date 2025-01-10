<?php
require_once '/solicitud_de_permisos_laborales/app/controller/LoginController.php';
require_once '../solicitud_de_permisos_laborales/conexion.php'; // Conexión a la base de datos

$loginController = new LoginController($db);

// Verificar si es necesario cerrar sesión por ser viernes después de las 4 PM
$loginController->verificarCierreViernes();

// Procesar el inicio de sesión
$loginController->iniciarSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Solicitud de Permisos Laborales</title>
</head>
<body>
    <h1>Bienvenido a la Solicitud de Permisos Laborales</h1>
    <a href="/solicitud_de_permisos_laborales/app/views/login.php">Iniciar Sesión</a>
</body>
</html>