<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM solicitudes WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$solicitudes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Solicitudes</title>
</head>
<body>
    <h2>Historial de Solicitudes</h2>
    <table>
        <tr>
            <th>Fecha de Solicitud</th>
            <th>Tipo de Permiso</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($solicitudes as $solicitud): ?>
            <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-info">
        <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
    </div>
    <?php endif; ?>
        <tr>
            <td><?php echo $solicitud['fecha_solicitud']; ?></td>
            <td><?php echo $solicitud['tipo_permiso']; ?></td>
            <td><?php echo $solicitud['estado']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="solicitar_permiso.php">Solicitar nuevo permiso</a>
    <form method="GET">
    <label for="estado">Estado:</label>
    <select id="estado" name="estado">
        <option value="">Todos</option>
        <option value="aprobada">Aprobadas</option>
        <option value="rechazada">Rechazadas</option>
        <option value="en solicitud">En Solicitud</option>
    </select>
    <button type="submit">Filtrar</button>
</form>

    <?php
    $estado_filtro = $_GET['estado'] ?? '';
    if ($estado_filtro) {
    $stmt = $pdo->prepare("SELECT * FROM solicitudes WHERE usuario_id = ? AND estado = ?");
    $stmt->execute([$usuario_id, $estado_filtro]);
    } else {
    $stmt = $pdo->prepare("SELECT * FROM solicitudes WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    }
    $solicitudes = $stmt->fetchAll();
    ?>
</body>
</html>
