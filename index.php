<?php
require_once 'app/controller/LoginController.php';
require_once '../solicitud_de_permisos_laborales/conexion.php'; // Conexión a la base de datos

$loginController = new LoginController($conect_service);

// Verificar si es necesario cerrar sesión por ser viernes después de las 4 PM
$loginController->verificarCierreViernes();

// Procesar el inicio de sesión
$loginController->iniciarSesion();
?>