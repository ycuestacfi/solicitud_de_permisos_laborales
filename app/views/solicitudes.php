<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';
include_once __DIR__ . '/../controller/departamentoController.php';

$solicitudController = new SolicitudController();
$departamentocontroler = new departamentoControler();

$cedula = $_SESSION['cedula'];
$id_departamento = $_SESSION['id_departamento'];

$departamento_data = $departamentocontroler->getDepartamentodata($id_departamento);
$solicitudes = $solicitudController->solicitudesRealizadas($cedula,$id_departamento);


$respuesta_solicitudes = $solicitudes;


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/style.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/tarjetas.css">
</head>
<body>
    <main>
        <section id="navigation">
            <nav>
                <figure style="margin:0; padding:0; width:150px;">
                    <a href="dashboard.php">
                        <img src="/solicitud_permisos/app/assets/img/logocfipblanco.png" style="width: 100%;" alt="">
                    </a>
                </figure>
                <div id="btn_menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>  
                <ul id="menu">
            
                    <?php if ($_SESSION['rol'] == "lider_aprobador" || $_SESSION['rol'] == "administrador" || $_SESSION['rol'] == "TI"){
                        echo '<li><a href="dashboard.php">Inicio</a></li>';
                    }
                    ?>
                    <li><a href="solicitudes.php">Mis solicitudes</a></li>
                    <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
                    
                    
                    
                    <?php if ($_SESSION['rol'] == 'administrador' || $_SESSION['rol'] == "TI"){
                            
                        echo '<li><a href="departamentos.php">Departamentos</a></li>';
                        echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                        echo '<li><a href="historico.php"> Historico </a></li>';
                        }
                    ?>
                    <?php if ($_SESSION['rol'] == 'seguridad' || $_SESSION['rol'] == "TI"){
                        echo '<li><a href="solicitudes_hora_ingreso.php"> solicitudes hoy </a></li>'; 
                        }
                    ?>
                    
                    <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
                </ul>
            </nav>
        </section>
        <div class="tabla_registro">
            <table id="tabla_registros" style="height: 100% ;width: 100%;">
                <thead>
                    <tr>
                        <th>Codigo de solicitudes</th>
                        <th>Líder Aprobador</th>
                        <th>Fecha Solicitud</th>
                        <th>Hora de salida</th>
                        <th>Hora de ingreso</th>
                        <th>Estado</th>
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($respuesta_solicitudes) ):?>
                        <?php foreach ($respuesta_solicitudes as $solicitud): ?>
                        <tr>
                            <td class="td_solicitud">
                                <?php echo htmlspecialchars($solicitud['identificador_solicitud']); ?>
                            </td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($lider_proceso['nombres']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['fecha_permiso']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['hora_salida']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['hora_ingreso']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['estado']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars("comentario"); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No se encontraron solicitudes. Puedes realizar una nueva.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Copyright: Aviso de privacidad, Términos y condiciones. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/tarjetas.js"></script>
</body>
</html>
