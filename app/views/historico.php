<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';

// Ahora, pasar la conexión a la clase solicitudModel
$solicitudController = new SolicitudController();

// Obtener solicitudes
$id_departamento = $_SESSION['id_departamento'];
$solicitudes = $solicitudController->historico();

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
            <li><a href="departamentos.php">Departamentos</a></li>
            <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
            <li><a href="rechazadas.php">Rechazadas</a></li>
            <?php if ($_SESSION['rol'] == 'administrador'){
                    echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                    echo '<li><a href="historico.php"> Historico </a></li>';
                } ?>
            <li><a href="historico.php"> Historico </a></li>
            <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
        </ul>
         
    </nav>
</section>
        <input type="text" id="busqueda" onkeyup="filtrarTabla()" placeholder="Buscar en el histórico...">
        <div class="tabla_registro">
            <table id="tabla_registros" style="height: 100% ;width: 100%;">
                <thead>
                    <tr>
                        <th >N° Solicitud</th>
                        <th >Estado</th>
                        <th >Fecha de permiso</th>
                        <th >Departamento</th>
                        <th >Fecha de cambio</th>
                    </tr>
                </thead>
                <tbody>
                   
                    <tr> 
                        
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitudes); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitudes['estado']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitudes['fecha_permiso']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitudes['nombre_departamento']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitudes['fecha_cambio']); ?></td>
                        
                    </tr>
                   
                </tbody>
            </table>
        </div>

    </main>

    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/busqueda.js"></script>
</body>
</html>
