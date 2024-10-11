<?php
//encabezado
header("ACCESS-CONTROL-ALLOW-ORIGIN: *");

// declaro la conexion con los parametros directamente
$conect_service = new mysqli("localhost", "root", "", "solicitud_de_permisos");

// Verificar la conexión
if ($conect_service->connect_error) {
    die("Error en la conexión: " . $conect_service->connect_error);
} else {
    echo "Conexión exitosa";
}
?>