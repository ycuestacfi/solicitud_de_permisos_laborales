<?php
session_start();

 // Archivo de configuración para conectar a la base de datos
require '../config/config.php'; // Asegúrate de incluir el archivo de correo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['user_id']; // Asumiendo que el ID del usuario está almacenado en la sesión
    $fecha_permiso = $_POST['fecha_permiso'];
    $hora_permiso = $_POST['hora_permiso'];
    $tipo_permiso = $_POST['tipo_permiso'];

    // Insertar solicitud en la base de datos
    $stmt = $pdo->prepare("INSERT INTO solicitudes (usuario_id, fecha_permiso, hora_permiso, tipo_permiso) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$usuario_id, $fecha_permiso, $hora_permiso, $tipo_permiso])) {
        // Enviar correo (utiliza una librería como PHPMailer)
        $asunto = "Nueva Solicitud de Permiso";
        $mensaje = "Se ha generado una nueva solicitud de permiso.";
        // Aquí deberías agregar la lógica para enviar el correo a usuario y líder
        // mail($correo_destino, $asunto, $mensaje);
        echo "Solicitud enviada con éxito.";
    } else {
        echo "Error al enviar la solicitud.";
    }
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... (lógica existente)
    
    if ($stmt->execute([$usuario_id, $fecha_permiso, $hora_permiso, $tipo_permiso])) {
        // Enviar correos
        $correo_solicitante = $_SESSION['correo']; // Asumiendo que el correo del usuario está en la sesión
        $lider_correo = obtenerCorreoLider($departamento); // Función para obtener el correo del líder

        $asunto = "Nueva Solicitud de Permiso";
        $mensaje = "Se ha generado una nueva solicitud de permiso para el día $fecha_permiso a las $hora_permiso.";

        // Enviando correos
        enviarCorreo($correo_solicitante, $asunto, $mensaje);
        enviarCorreo($lider_correo, $asunto, $mensaje);

        echo "Solicitud enviada con éxito.";
    }
}

function obtenerCorreoLider($departamento) {
    global $pdo; // Usar la conexión PDO
    $stmt = $pdo->prepare("SELECT correo FROM usuarios WHERE departamento = ? AND rol = 'aprobador'");
    $stmt->execute([$departamento]);
    $usuario = $stmt->fetch();
    return $usuario ? $usuario['correo'] : null;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Permiso</title>
</head>
<body>
    <h2>Solicitud de Permiso</h2>
    <form method="POST">
        <label for="fecha_permiso">Fecha de Permiso:</label>
        <input type="date" id="fecha_permiso" name="fecha_permiso" required>
        <label for="hora_permiso">Hora de Permiso:</label>
        <input type="time" id="hora_permiso" name="hora_permiso" required>
        <label for="tipo_permiso">Tipo de Permiso:</label>
        <select id="tipo_permiso" name="tipo_permiso">
            <option value="personal">Personal</option>
            <option value="laboral">Laboral</option>
            <option value="calamidad doméstica">Calamidad Doméstica</option>
            <option value="estudio">Estudio</option>
            <option value="cita médica">Cita Médica</option>
        </select>
        <button type="submit">Enviar Solicitud</button>
    </form>
</body>
</html>