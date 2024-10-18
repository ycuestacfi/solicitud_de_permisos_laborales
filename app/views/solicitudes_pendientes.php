<?php include_once '.\estructure\head.php';

$prueba1 = [
    ['nombre' => 'Juan Pérez', 'departamento' => 'Ventas', 'lider_aprobador' => 'Carlos Torralba', 'fecha_solicitud' => '2024-10-15', 'estado' => 'Aprobado'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
    
];
?>

    <table id="tabla_registros" style=" border: solid 2px var(--blanco);
    width: 65%;
    padding: 10px;
    background-color: var(--azul-oscuro-contraste);
    position: relative;
    left: 52%;
    transform: translateX(-50%);
    bottom: 130px; " >
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>lider aprobador</th>
                <th>Fecha solicitud</th>
                <th>Estado</th>
               
                <?php if ($_SESSION['rol']='lider_aprobador'): ?>
                <th>acciones</th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($prueba1 as $pruebas1): ?>
        <tr>
            <td><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
            <td><?php echo htmlspecialchars($pruebas1['departamento']); ?></td>
            <td><?php echo htmlspecialchars($pruebas1['lider_aprobador']); ?></td>
            <td><?php echo htmlspecialchars($pruebas1['fecha_solicitud']); ?></td>
            <td><?php echo htmlspecialchars($pruebas1['estado']); ?></td>

            <?php if ($_SESSION['rol']='lider_aprobador'): ?>
            <td><?php echo '<button style="height: 40px; background:none; border:none; width:40px"><i class="fa-solid fa-circle-info" style=" color:var(--verde-corporativo); font-size:22px;"></i></button>' ?> </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
              
        </tbody>
    </table>

<?php include_once '.\estructure\footer.php'; ?>