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

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /app/views/login.php ");
    exit();
}
if ($_SESSION['rol'] !== "seguridad" && $_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php ");
    exit();
}
require_once __DIR__ . '/../controller/solicitudController.php';

// Ahora, pasar la conexión a la clase solicitudModel
$solicitudController = new SolicitudController();

// Obtener solicitudes
$solicitudes = $solicitudController->solicitudesDeTerminadas();

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
    top:20%;
}

/* Estilo de la X para cerrar */
.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

/* Mensaje dentro del modal */
#mensajeConfirmacion {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
    font-family: 'Arial', sans-serif;
}

/* Contenedor de los botones */
.modal-buttons {
    display: flex;
    justify-content: space-around;
}

/* Estilo de los botones */
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
                    <th >Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($solicitudes): ?>
                <?php foreach ($solicitudes as $pruebas1): ?>
                <tr id="fila_<?php echo $pruebas1['id_solicitud']; ?>"
                    data-info='<?php echo json_encode($pruebas1, JSON_HEX_APOS | JSON_HEX_QUOT); ?>'>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['identificador_solicitud']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['cedula']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['nombre']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['fecha_permiso']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_salida']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['hora_ingreso']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($pruebas1['tipo_permiso']); ?></td>

                    <td class="td_solicitud">
                        <button class="btn_accion_solicitud" 
                            onclick="procesarSolicitudConConfirmacion(this)">
                            <i class="fa-solid fa-file-lines" style="font-size: 22px; color:var(--verde-corporativo);"></i>
                        </button>
                    </td>
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
    <script>
    function procesarSolicitudConConfirmacion(boton) {
        // Buscar la fila más cercana al botón y obtener el atributo data-info
        let fila = boton.closest("tr");
        let datos = JSON.parse(fila.getAttribute("data-info"));

        console.log("Solicitud recibida:", datos);

        // Crear un formulario oculto y enviarlo al mismo archivo PHP
        let form = document.createElement("form");
        form.method = "POST";
        form.action = ""; // Se envía al mismo archivo

        // Agregar los datos como inputs ocultos
        for (let key in datos) {
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = datos[key];
            form.appendChild(input);
        }

        // Input adicional para indicar que se está procesando la solicitud
        let actionInput = document.createElement("input");
        actionInput.type = "hidden";
        actionInput.name = "accion";
        actionInput.value = "guardar_historico";
        form.appendChild(actionInput);

        // Agregar el formulario al documento y enviarlo
        document.body.appendChild(form);
        form.submit();
    }
    </script>
    <?php 
    // Verifica si se envió el formulario desde JavaScript
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"]) && $_POST["accion"] === "guardar_historico") {
        // Captura los datos de POST y guárdalos en un array
        $datos = [
            "id_solicitud" => $_POST["id_solicitud"],
            "estado" => "terminada"
        ];

        // Llamar a la función para registrar en el histórico
        $resultado = $solicitudController->historico($datos);

        // Redirigir o mostrar mensaje según el resultado
        if ($resultado) {
            echo "<script>alert('Solicitud registrada en el histórico correctamente');</script>";
        } else {
            echo "<script>alert('Error al registrar la solicitud');</script>";
        }
    }
    ?>
</body>
</html>
