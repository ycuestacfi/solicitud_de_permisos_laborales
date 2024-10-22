<?php
session_start();
require '../config/config.php';

// if ($_SESSION['rol'] != 'administrador') {
//     header("Location: index.php");
//     exit();
// }

$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $accion = $_POST['accion'];

    $nuevo_estado = ($accion == 'activar') ? 'activo' : 'inactivo';

    // Actualizar estado del usuario
    $stmt = $pdo->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
    $stmt->execute([$nuevo_estado, $usuario_id]);

    header("Location: gestionar_usuarios.php");
    exit();
}
?>
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Usuarios</title>
</head>
<body>
    <h2>Gestionar Usuarios</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></td>
            <td><?php echo $usuario['cedula']; ?></td>
            <td><?php echo $usuario['estado']; ?></td>
            <td>
                <form method="POST" action="activar_desactivar.php">
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                    <button type="submit" name="accion" value="<?php echo $usuario['estado'] == 'activo' ? 'desactivar' : 'activar'; ?>">
                        <?php echo $usuario['estado'] == 'activo' ? 'Desactivar' : 'Activar'; ?>
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>