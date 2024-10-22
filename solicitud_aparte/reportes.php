<?php
session_start();
require 'config.php';

if ($_SESSION['rol'] != 'administrador') {
    header("Location: index.php");
    exit();
}

// Ejemplo de consulta para obtener estadísticas
$stmt = $pdo->query("SELECT estado, COUNT(*) as total FROM solicitudes GROUP BY estado");
$reportes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Solicitudes</title>
</head>
<body>
    <h2>Reportes de Solicitudes</h2>
    <table>
        <tr>
            <th>Estado</th>
            <th>Total</th>
        </tr>
        <?php foreach ($reportes as $reporte): ?>
        <tr>
            <td><?php echo $reporte['estado']; ?></td>
            <td><?php echo $reporte['total']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>