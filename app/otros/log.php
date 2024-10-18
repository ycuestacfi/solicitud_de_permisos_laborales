<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="" method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Ingrese un correo válido"><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required pattern=".{9,}[*.#]$" title="La contraseña debe tener más de 8 caracteres y terminar con * o # o ."><br><br>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>