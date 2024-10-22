<?php
session_start();
require 'config.php';

// Verificar que el usuario sea aprobador
if ($_SESSION['rol'] != 'aprobador') {
    header("Location: index.php");
    exit();
}

// Obtener solicitudes pendientes
$stmt = $pdo->query("SELECT s.*, u.nombre, u.apellido FROM solicitudes s JOIN usuarios u ON s.usuario_id = u.id WHERE s.estado = 'en solicitud'");
$solicitudes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aprobar Solicitudes</title>
</head>
<body>
    <h2>Solicitudes Pendientes</h2>
    <table>
        <tr>
            <th>Solicitante</th>
            <th>Fecha de Solicitud</th>
            <th>Tipo de Permiso</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($solicitudes as $solicitud): ?>
        <tr>
            <td><?php echo $solicitud['nombre'] . " " . $solicitud['apellido']; ?></td>
            <td><?php echo $solicitud['fecha_solicitud']; ?></td>
            <td><?php echo $solicitud['tipo_permiso']; ?></td>
            <td>
                <form method="POST" action="aprobar.php">
                    <input type="hidden" name="solicitud_id" value="<?php echo $solicitud['id']; ?>">
                    <button type="submit" name="accion" value="aprobar">Aprobar</button>
                    <button type="submit" name="accion" value="rechazar">Rechazar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>