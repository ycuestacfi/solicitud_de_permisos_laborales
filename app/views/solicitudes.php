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
$solicitudes = $solicitudController->solicitudesRealizadas($cedula);


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
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/modal_evidencia.css">
</head>
<body>
    <!-- Modal para subir evidencia -->
<div id="modalSubirEvidencia" class="modal" style="display: none;">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModalEvidencia()">&times;</span>
        <form id="formSubirEvidencia" enctype="multipart/form-data" action="/solicitud_de_permisos_laborales/app/controller/solicitudController.php" method="POST">
            <input type="text" hidden id="identificador_solicitud" name="identificador_solicitud" value="">
            <label for="subir_evidencia" class="label-evidencia">Seleccionar Evidencia</label>
            <input type="file" id="subir_evidencia" name="subir_evidencia" accept=".jpg, .jpeg, .png, .pdf" required>
            <button type="submit" class="btn-subir">Subir</button>
        </form>
    </div>
</div>

<div id="modalVerEvidencia" class="modal">
    <div class="modal-contenido">
        <span class="close" onclick="cerrarModalVerEvidencia()">&times;</span>
        <img id="imagenEvidencia" src="" alt="Evidencia" class="imagen-evidencia">
    </div>
</div>

<!-- Estilos del modal -->
<style>
/* Modal general */
.modal {
    display: none; /* Ocultar por defecto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Fondo oscuro con transparencia */
    z-index: 9999;
    padding-top: 100px;
    text-align: center;
    justify-content: center;
    align-items: center;
}

/* Contenedor del modal */
.modal-contenido {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    position: relative;
    max-width: 90%;
    max-height: 90%;
    overflow: auto;
    margin: auto;
    width: 1000px;
}

/* Botón para cerrar */
.cerrar {
    color: #333; /* Más oscuro */
    font-size: 24px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.1); /* Fondo circular con transparencia */
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease, color 0.3s ease;
}

.cerrar:hover {
    background: rgba(0, 0, 0, 0.3); /* Fondo más oscuro al pasar el mouse */
    color: #fff; /* La X se vuelve blanca */
}

/* Input file */
input[type="file"] {
    margin: 15px 0;
    padding: 10px;
    border: 1px solid #A3B8C9;
    border-radius: 5px;
    background: white;
    width: 100%;
}

/* Botón de subir */
.btn-subir {
    background: #567572;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn-subir:hover {
    background: #3f5c58;
}

/* Estilo del label */
.label-evidencia {
    display: inline-block;
    font-size: 16px; /* Tamaño de fuente */
    font-weight: bold; /* Hacer el texto en negrita */
    padding: 10px 20px; /* Espaciado interno */
    border-bottom: 2px solid black; /* Línea negra en la parte inferior */
    cursor: pointer; /* Indica que es clickeable */
    transition: transform 0.2s; /* Transición suave */
    margin:5px;
}

/* Efecto cuando el mouse pasa por encima */
.label-evidencia:hover {
    background-color: #4b5c50; /* Color más oscuro en hover */
    transform: scale(1.05); /* Efecto de agrandado en hover */
}

/* Efecto cuando se hace clic */
.label-evidencia:active {
    transform: scale(0.98); /* Le da un efecto de "presionar" */
}
</style>
    <main>
        <section id="navigation">
            <nav>
                <figure style="margin:0; padding:0; width:150px;">
                    <a href="dashboard.php">
                        <img src="/solicitud_de_permisos_laborales/app/assets/img/logocfipblanco.png" style="width: 100%;" alt="">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($respuesta_solicitudes) ):?>
                        <?php foreach ($respuesta_solicitudes as $solicitud): ?>
                        <tr>
                            <td class="td_solicitud">
                                <?php echo htmlspecialchars($solicitud['identificador_solicitud']); ?>
                            </td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($departamento_data ['nombres'].' '.$departamento_data['apellidos']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['fecha_permiso']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['hora_salida']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['hora_ingreso']); ?></td>
                            <td class="td_solicitud"><?php echo htmlspecialchars($solicitud['estado']); ?></td>
                            <td class="td_solicitud">
                                <button class="btn_accion_solicitud" 
                                    onclick="abrirModalEvidencia()">
                                    <i class="fa-regular fa-comment" style="font-size: 22px; color:#A3B8C9;"></i>
                                </button>

                                <?php if (empty($solicitud['evidencia'])): ?>
                                    <!-- Botón para subir evidencia si no existe -->
                                    <button class="btn_accion_solicitud" onclick="mostrarModalSubirEvidencia('<?php echo $solicitud['identificador_solicitud']; ?>')">
                                        <i class="fa-solid fa-upload" style="font-size: 22px; color:#E6A57E;"></i>
                                    </button>
                                    <?php else: ?>
                                        <?php 
                                            $ruta = $solicitud['evidencia'];
                                            if($ruta == "") {
                                                $ruta_relativa = null;
                                            } else {
                                            $ruta_relativa = str_replace("C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\", "http://localhost/solicitud_de_permisos_laborales/app/", $ruta);
                                            }
                                        ?>
                                    <!-- Botón para ver evidencia si ya existe -->
                                    <button class="btn_accion_solicitud" onclick="verEvidencia('<?php echo $ruta_relativa; ?>')">
                                        <i class="fa-regular fa-file-lines" style="font-size: 22px; color:var(--verde-corporativo);"></i>
                                    </button>
                                <?php endif; ?>
                            </td>                        
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
    <script src="/solicitud_de_permisos_laborales/app/assets/js/subir_evidencia.js"></script>
</body>
</html>
