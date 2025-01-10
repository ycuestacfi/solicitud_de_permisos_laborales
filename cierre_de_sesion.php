<?php
require_once __DIR__ . '/app/controller/LoginController.php';

require_once 'conexion.php';

$loginController = new LoginController($conect_service);
$loginController->cerrarSesion();
?>