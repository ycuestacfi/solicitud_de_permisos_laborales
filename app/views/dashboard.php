<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Estructura HTML5</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/style.css">


</head>
<body>
    <?php
    $prueba1 = [
        ['nombre' => 'Juan Pérez', 'departamento' => 'Ventas', 'lider_aprobador' => 'Carlos Torralba', 'fecha_solicitud' => '2024-10-15', 'estado' => 'Aprobado'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        
    ]; ?>
<!-- <header>
        <h1>Título de la Página</h1>
        <nav>
            <ul>
                <li><a href="#home" style="color: white;">Inicio</a></li>
                <li><a href="#about" style="color: white;">Acerca de</a></li>
                <li><a href="#services" style="color: white;">Servicios</a></li>
                <li><a href="#contact" style="color: white;">Contacto</a></li>
            </ul>
        </nav>
    </header> -->
    
    <main>
    <section id="navigation">
    <nav>
        <figure style="margin:0; padding:0; width:150px;">
            <a href="dashboard.php"><img src="/solicitud_de_permisos_laborales/app/assets/img/logocfipblanco.png" style="width: 100%;" alt=""></a>
        </figure>
        <div id="btn_menu">
            <div></div>
            <div></div>
            <div></div>
        </div>
        
        <ul id="menu">
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="solicitudes.php">Mis solicitudes</a></li>
            <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
            <li><a href="rechazadas.php">Rechazadas</a></li>
            <?php if ($_SESSION['rol'] == 'administrador'){
                    echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                } ?>
            <li><a href="/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
        </ul>
         
    </nav>
</section>
        
        <table id="tabla_registros">
            <thead>
                <tr>
                    <th >Nombre</th>
                    <th >Departamento</th>
                    <th >Líder Aprobador</th>
                    <th >Fecha Solicitud</th>
                    <th >Estado</th>
                    <?php if ($_SESSION['rol'] == 'lider_aprobador'): ?>
                    <th >Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prueba1 as $pruebas1): ?>
                <tr>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['departamento']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['lider_aprobador']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_solicitud']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['estado']); ?></td>
                    <?php if ($_SESSION['rol'] == 'lider_aprobador'): ?>
                    <td class="td_solicitud">
                        <button class="btn_accion_solicitud"><i class="fa-regular fa-circle-check" style="font-size: 22px; color:var(--verde-claro);"></i></button>
                        <button class="btn_accion_solicitud"><i class="fa-regular fa-circle-xmark" style="font-size: 22px; color:red;"></i></button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
</body>
</html>
