<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['estado'])) {
    if ($_SESSION['estado'] !== "activo"){
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
    }
}

if ($_SESSION['rol'] !== "lider_aprobador" && $_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';

// Ahora, pasar la conexión a la clase solicitudModel
$solicitudController = new SolicitudController();

// Obtener solicitudes
$id_departamento = $_SESSION['id_departamento'];
$solicitudes = $solicitudController->solicitudesDeDepartamento($id_departamento);

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
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/tarjetas.css">
    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/modal_evidencia.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<!-- Modal para mostrar mensajes -->
<div id="modalMensaje" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <p id="mensajeModal"></p>
    </div>
</div>

<div id="modalEvidencia" class="modal">
    <div class="modal-contenido">
        <span class="close" onclick="cerrarModalE()">&times;</span>
        <img id="imagenEvidencia" src="" alt="Evidencia" class="imagen-evidencia">
    </div>
</div>

<!-- Estilos del modal -->
<style>
/* Estilo del Modal */
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

/* Contenido del Modal */
.modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    width: 300px;
    margin: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
    position: relative;
    top: 20%;
    max-width: 90%;
}
/* Asegurar que el input sea visible y bien espaciado */
.modal-content input {
    width: 100%; /* Que ocupe todo el ancho */
    padding: 10px;
    margin-top: 10px; /* Espaciado superior */
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    outline: none; /* Quita el borde azul al hacer clic */
}

/* Estilo de la X para cerrar */
.close {
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

.close:hover,
.close:focus {
    background: rgba(0, 0, 0, 0.3); /* Fondo más oscuro al pasar el mouse */
    color: #fff; /* La X se vuelve blanca */
}

/* Estilo del mensaje */
#mensajeModal {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
    font-family: 'Arial', sans-serif;
}

/* Asegurar que el input de comentario sea visible */
#comentario {
    display: block; /* Forzar visibilidad */
    width: calc(100% - 20px); /* Ajustar el ancho */
    padding: 10px;
    margin-top: 15px;
    border: 1px solid #aaa;
    border-radius: 5px;
    font-size: 16px;
    margin: 10px;
}

/* Botones dentro del modal de confirmación */
.modal-buttons {
    display: flex;
    justify-content: space-around;
}

.modal-buttons button {
    background-color: #4CAF50; /* Verde para el "Sí" */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Estilo del botón "Sí" */
.modal-buttons button:first-child {
    background-color: #4CAF50;
}

.modal-buttons button:first-child:hover {
    background-color: #45a049;
}

/* Estilo del botón "No" */
.modal-buttons button:nth-child(2) {
    background-color: #f44336; /* Rojo para el "No" */
}

.modal-buttons button:nth-child(2):hover {
    background-color: #e53935;
}
</style>
    
    <main>
    <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<script>
                Swal.fire({
                    title: '" . $_SESSION['mensaje']['titulo'] . "',
                    text: '" . $_SESSION['mensaje']['texto'] . "',
                    icon: '" . $_SESSION['mensaje']['icono'] . "'
                });
            </script>";
            unset($_SESSION['mensaje']); // Limpiar la sesión después de mostrar la alerta
        }    
    ?>
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
          
            <li><a href="aprovadas.php">aprovadas</a></li>
            <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
        </ul>
         
    </nav>
</section>
    <div class="tabla_registro">
        <table id="tabla_registros" style="height: 100% ;width: 100%;">
            <thead>
                <tr>
                    <th >Codigo de solicitudes</th>
                    <th >Cedula</th>
                    <th >Nombre</th>
                    <th >Fecha Salida</th>
                    <th >Hora de salida</th>
                    <th >Hora de ingreso</th>
                    <th >Tipo</th>
                    <th >Evidencia</th>
                    <th >Estado</th>
                    <?php if ($_SESSION['rol'] == 'lider_aprobador' || $_SESSION['rol']== 'TI' || $_SESSION['rol']== 'administrador'): ?>
                    <th >Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($solicitudes): ?>
                <?php foreach ($solicitudes as $pruebas1): ?>
                <tr id="fila_<?php echo $pruebas1['id_solicitud']; ?>">
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['identificador_solicitud']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['cedula']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_permiso']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_salida']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_ingreso']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['tipo_permiso']); ?></td>
                    <td class="td_solicitud">
                        <?php
                            $ruta = $pruebas1['evidencia'];
                            if($ruta == "") {
                                ?>
                                <button class="btn_accion_solicitud" 
                                <?php 
                                    $ruta_relativa = null;
                                    
                                    $ruta_relativa = str_replace("C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\", "http://localhost/solicitud_de_permisos_laborales/app/", $ruta);
                                    
                                ?>
                                onclick="mostrarEvidencia('<?php echo $ruta_relativa; ?>')">
                                <i class="fa-solid fa-xmark" style="font-size: 22px; color:red;"></i>
                                </button><?php 
                            } else {
                                ?>
                                <button class="btn_accion_solicitud" 
                                <?php 
                                    
                                    $ruta_relativa = str_replace("C:\\xampp\\htdocs\\solicitud_de_permisos_laborales\\", "http://localhost/solicitud_de_permisos_laborales/app/", $ruta);
                                    
                                ?>
                                onclick="mostrarEvidencia('<?php echo $ruta_relativa; ?>')">
                                <i class="fa-regular fa-file-lines" style="font-size: 22px; color:var(--verde-corporativo);"></i>
                                </button><?php 
                            }
                        ?>
                    </td>
                    <td class="td_solicitud" id="estado_<?php echo $pruebas1['id_solicitud']; ?>">
                        <?php echo htmlspecialchars($pruebas1['estado']); ?>
                    </td>

                    <?php if ($_SESSION['rol'] == 'lider_aprobador' || $_SESSION['rol']== 'TI' || $_SESSION['rol']== 'administrador'): ?>
                    <td class="td_solicitud">
                        <button class="btn_accion_solicitud" 
                            onclick="procesarSolicitudConConfirmacion(
                                'aprobada', 
                                <?php echo $pruebas1['id_solicitud']; ?>, 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['identificador_solicitud'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['nombre'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['cedula'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['correo'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['tipo_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['fecha_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_salida'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_ingreso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['observaciones'])); ?>'
                            )">
                            <i class="fa-regular fa-circle-check" style="font-size: 22px; color:var(--verde-corporativo);"></i>
                        </button>

                        <button class="btn_accion_solicitud" 
                            onclick="procesarSolicitudConConfirmacion(
                                'rechazada', 
                                <?php echo $pruebas1['id_solicitud']; ?>, 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['identificador_solicitud'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['nombre'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['cedula'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['correo'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['tipo_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['fecha_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_salida'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_ingreso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['observaciones'])); ?>'
                            )">
                            <i class="fa-regular fa-circle-xmark" style="font-size: 22px; color:red;"></i>
                        </button>

                        <button class="btn_accion_solicitud" 
                            onclick="procesarSolicitudConConfirmacion(
                                'eliminada', 
                                <?php echo $pruebas1['id_solicitud']; ?>, 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['identificador_solicitud'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['nombre'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['cedula'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($pruebas1['correo'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['tipo_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['fecha_permiso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_salida'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['hora_ingreso'])); ?>',
                                '<?php echo addslashes(htmlspecialchars($pruebas1['observaciones'])); ?>'
                            )">
                            <i class="fa fa-trash-can" style="font-size: 22px; color:grey;"></i>
                        </button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <td class="td_solicitud" colspan="10">No tienes solicitudes pendientes en tu departamento</td>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
    <!-- Modal de Confirmación -->
    <div id="modalConfirmacion" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <p id="mensajeConfirmacion">¿Estás seguro de que deseas realizar esta acción?</p>
            <input type="text" id="comentario" name="comentario" placeholder="Comentario">
            <div class="modal-buttons">
                <button id="btnConfirmar" onclick="realizarAccion()">Sí</button>
                <button onclick="cerrarModal()">No</button>
            </div>
        </div>
    </div>
    </main>

    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/estado_solicitud.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/tarjetas.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/evidencia.js"></script>
</body>
</html>
