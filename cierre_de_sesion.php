<?php
require_once 'app/controller/LoginController.php';
require_once 'conexion.php';

$loginController = new LoginController($conect_service);
$loginController->cerrarSesion();
?>