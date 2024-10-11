<?php
//encabezado
header("ACCESS-CONTROL-ALLOW-ORIGIN: *");

// Conexión a la base de datos
$db_conet_service_host = "localhost";
$db_conet_service_name = "solicitud_de_permisos";
$db_conet_service_user = "root";
$db_conet_service_pass = "";
  

$conect_service = new mysqli($db_conet_service_host, $db_conet_service_user, $db_conet_service_pass, $db_conet_service_name);

// Verificar la conexión
if ($conect_service->connect_error) {
    die("Error en la conexión: " . $conect_service->connect_error);
}else{
    echo "conexion exitosa";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $db = getDB(); 
    $email = $_POST["email"];
    $password = $_POST["password"];
    $email_hashed = hash("sha512", $email);
    $password_hashed = hash("sha512", $password);

    $sql = "SELECT * FROM usuarios WHERE correo = $email_hashed AND contrasena = $password_hashed";
    $stmt = $conect_service->prepare($sql);
    
    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conect_service->error);
    }

    // Vincular parámetros
    $stmt->bind_param("ss", $email_hashed, $password_hashed);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontró un usuario que coincida
    if ($result->num_rows > 0) {
        // Redirigir a la página de solicitudes pendientes
       
        exit();
    } else {
        echo "Correo o contraseña incorrectos.";
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
    $conn->close();
}
?>