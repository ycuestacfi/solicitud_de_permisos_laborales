<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
if ($_SESSION['rol'] !== "seguridad" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php ");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';

// Ahora, pasar la conexión a la clase solicitudModel
$solicitudController = new SolicitudController();

// Obtener solicitudes
$solicitudes = $solicitudController->horaIngreso();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hora-input']) && isset($_POST['id_solicitud'])) {
    $hora_llegada = $_POST['hora-input'];
    $id_solicitud = $_POST['id_solicitud'];
    
    // Validar que la hora esté dentro del rango permitido
    $hora = strtotime($hora_llegada);
    $min_hora = strtotime('07:00');
    $max_hora = strtotime('16:00');
    
    if ($hora >= $min_hora && $hora <= $max_hora) {
        // Aquí tu código actual para actualizar la base de datos
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro hora de ingreso</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/style.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/tarjetas.css">

</head>
<body>
<!-- Modal para mostrar mensajes -->
<div id="modalMensaje" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <p id="mensajeModal"></p>
    </div>
</div>

<!-- Estilos del modal -->
<style>
    .modal {
        display: none; /* Ocultamos el modal por defecto */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
    
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
            
            
            <?php if ($_SESSION['rol'] == "TI"){
                echo '<li><a href="dashboard.php">Inicio</a></li>';
                }
            ?>

            <li><a href="solicitudes.php">Mis solicitudes</a></li>
            <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
            
            <?php if ($_SESSION['rol'] == "TI"){
                    
                echo '<li><a href="departamentos.php">Departamentos</a></li>';
                echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                echo '<li><a href="historico.php"> Historico </a></li>';
                echo '<li><a href="solicitudes_hora_ingreso.php"> solicitudes hoy </a></li>'; 
                }
            ?>

            <?php if ($_SESSION['rol'] == "TI"){
                echo '<li><a href="solicitudes_hora_ingreso.php"> Aprovadas </a></li>'; 
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
                    <th >Codigo de solicitudes</th>
                    <th >Nombre</th>
                    <th >Fecha Permiso</th>
                    <th >Hora de salida</th>
                    <th >Hora de ingreso</th>
                    <th >Tipo permiso</th>
                    <th >Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($solicitudes == '{"error":"No se encontraron solicitudes de llegada pendientes"}') :?>
                    <tr>
                        <td class="td_solicitud" colspan="7"> No se encontraron solicitudes para el dia de hoy</td>
                    </tr>
                    <?php else :?>
                <?php foreach ($solicitudes as $pruebas1): ?>
                <tr id ="tr-<?php echo $pruebas1['id_solicitud'];?>">
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['identificador_solicitud']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_permiso']); ?></td>
                    <td class="td_solicitud" ><?php echo htmlspecialchars($pruebas1['hora_salida']); ?></td>
                    <td class="td_solicitud" ><?php echo htmlspecialchars($pruebas1['hora_ingreso']); ?></td>
                    <td class="td_solicitud" ><?php echo htmlspecialchars($pruebas1['tipo_permiso']); ?></td>
                    <td class="td_solicitud">
                    <button onclick="editarHora(<?php echo $pruebas1['id_solicitud']; ?>)" 
                        class="btn_accion_solicitud" 
                        id="btn_hora_<?php echo $pruebas1['id_solicitud']; ?>">
                        <i class="fa fa-pencil-alt" style="font-size: 22px; color:#A9A9A9;"></i>
                    </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif;?>
            </tbody>
        </table>
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $resultado = $solicitudController->edicionHora($_POST['hora-input'],$_POST['id_solicitud']);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    echo '<div class="alert alert-error">Error inesperado</div>';
                }
            }
            ?>
    </div>
    <!-- Modal para editar hora -->
    <div id="horaModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: white; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 300px; border-radius: 5px;">
            <h3>Editar Hora de Llegada de la <?php echo htmlspecialchars($pruebas1['identificador_solicitud']);?></h3>
            <form id="formEditarHora" method="POST" action="">
                <input type="hidden" id="modal_id_solicitud" name="id_solicitud" value="">
                <div style="margin: 15px 0;">
                    <label for="hora-input">Hora de llegada:</label>
                    <input type="time" 
                        id="hora-input" 
                        name="hora-input" 
                        min="07:00" 
                        max="16:00" 
                        required 
                        style="width: 100%; padding: 5px; margin-top: 5px;">
                </div>
                <div style="text-align: right;">
                    <button type="button" 
                            onclick="cerrarModal()" 
                            style="margin-right: 10px; padding: 5px 10px;">
                        Cancelar
                    </button>
                    <button type="submit" 
                            style="padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 3px;">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/editar_hora.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/tarjetas.js"></script>
</body>
</html>
