<?php
session_start();
require 'config.php'; // Archivo de configuración para conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $password = hash('sha512', $_POST['password']); // Encriptar contraseña

    // Insertar en la base de datos
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, cedula, telefono, correo, departamento, rol, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nombre, $apellido, $cedula, $telefono, $correo, $departamento, $rol, $password])) {
        echo "Registro exitoso.";
    } else {
        echo "Error en el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
</head>
<body>
    <h2>Registro de Usuarios</h2>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>
        <label for="correo">Correo Corporativo:</label>
        <input type="email" id="correo" name="correo" required>
        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento" required>
        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="solicitante">Solicitante</option>
            <option value="aprobador">Aprobador</option>
            <option value="administrador">Administrador</option>
            <option value="superadmin">Superadmin</option>
        </select>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>