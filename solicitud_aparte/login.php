<?php
session_start();
require 'conexion.php'; // Ruta al archivo de configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $password_hashed = hash("sha512", $password);

    // Consulta para buscar el usuario
    // $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND contrasena = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam("ss", $usuario,$password_hashed);
    $stmt->execute();
    $usuario_db = $stmt->fetch();

    // Verificar si el usuario existe
    if ($usuario_db) {
        // Verificar la contraseña
        if (password_verify($password, $usuario_db['password'])) {
            // Inicio de sesión exitoso
            $_SESSION['user_id'] = $usuario_db['id'];
            $_SESSION['rol'] = $usuario_db['rol'];
            header("Location: solicitar_permiso.php"); // Redirige a la página principal
            exit();
        } else {
            // Contraseña incorrecta
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="usuario" required placeholder="Nombre de usuario">
        <input type="password" name="password" required placeholder="Contraseña">
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>