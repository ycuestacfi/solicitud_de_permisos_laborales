<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
if ( $_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI" && $_SESSION['rol'] !== 'visualizar') {
    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php ");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';

// Ahora, pasar la conexión a la clase solicitudModel
$solicitudController = new SolicitudController();

// Obtener solicitudes
$id_departamento = $_SESSION['id_departamento'];
$solicitudes = $solicitudController->ver_historico();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de solicitudes</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/style.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/tarjetas.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/modal_evidencia.css">

</head>
<body>

<div id="modalVerEvidencia" class="modal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModalVerEvidencia()">&times;</span>
        <img id="imagenEvidencia" src="" alt="Evidencia" class="imagen-evidencia">
    </div>
</div>   
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
            
            <?php if ($_SESSION['rol'] == "lider_aprobador" || $_SESSION['rol'] == "administrador" || $_SESSION['rol'] == "TI" || $_SESSION['rol'] === 'visualizar'){
                echo '<li><a href="dashboard.php">Inicio</a></li>';
            }
            ?>
            
            <?php if ($_SESSION['rol'] !== 'visualizar') {
                echo '<li><a href="solicitudes.php">Mis solicitudes</a></li>';
                echo '<li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>';
                }
            ?>
            
            
            <?php if ($_SESSION['rol'] == 'administrador' || $_SESSION['rol'] == "TI" || $_SESSION['rol'] === 'visualizar'){
                    
                    echo '<li><a href="departamentos.php">Departamentos</a></li>';
                    echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                    echo '<li><a href="historico.php"> Historico </a></li>';
                }
            ?>
          
          <?php if ($_SESSION['rol'] == 'visualizar'){
                    echo '<li><a href="aprovadas.php"> Aprovadas </a></li>'; 
            }?>
            <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
        </ul>
         
    </nav>
</section>
        <input type="text" id="busqueda" onkeyup="filtrarTabla()" placeholder="Buscar en el histórico...">
        <div class="tabla_registro">
            <table id="tabla_registros" style="height: 100% ;width: 100%;">
                <thead>
                    <tr>
                        <th >Codigo Solicitud</th>
                        <th >Nombre</th>
                        <th >N°Cedula</th>
                        <th >Departamento</th>
                        <th >Fecha de permiso</th>
                        <th >Hora Salida</th>
                        <th >Hora ingreso</th>
                        <th >Tipo de permiso</th>
                        <th >Evidencia</th>
                        <th >Estado</th>
                        <th >Fecha de aprovacion</th>
                        <th >Fecha de porteria</th>
                        <th >Fecha de revision</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    foreach ($solicitudes as $pruebas1): 
                        // Procesar la ruta de la evidencia
                        $ruta = $pruebas1['evidencia'];
                        $ruta_relativa = ($ruta == "") ? null : str_replace("C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\", "http://localhost/solicitud_de_permisos_laborales/app/", $ruta);    
                    ?>
                    <tr>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['identificador_solicitud']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['cedula']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre_departamento']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_permiso']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_salida']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_ingreso']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['tipo_permiso']); ?></td>
                        <td class="td_solicitud">
                            <button class="btn_accion_solicitud" onclick="verEvidencia('<?php echo $ruta_relativa; ?>')">
                                <i class="fa-regular fa-file-lines" style="font-size: 22px; color:var(--verde-corporativo);"></i>
                            </button>
                        </td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['estado_revision']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_estado']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_estado_vigilancia']); ?></td>
                        <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_estado_revision']); ?></td>
                    </tr>    
                    <?php endforeach; ?>
                
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
    <script src="/solicitud_de_permisos_laborales/app/assets/js/tarjetas.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/subir_evidencia.js"></script>
</body>
</html>