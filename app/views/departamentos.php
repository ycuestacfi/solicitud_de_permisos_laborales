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

if ($_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}

include_once '../controller/departamentoController.php';
include_once '../controller/UserController.php';

$rol = $_SESSION['rol'];
$departamentocontroler = new departamentoControler();
$usercontroler = new UserController();
$departamentos = $departamentocontroler->listarDepartamentos();
$usuarios_selecion_lider = $usercontroler->selecion_de_lider();  
 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/departamentos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 15% auto; padding: 20px; width: 50%; border-radius: 8px; position: relative; }
    .close { position: absolute; top: 10px; right: 20px; font-size: 25px; cursor: pointer; }
</style>
</head>
<body>
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
            <?php if ($_SESSION['rol'] == 'seguridad' || $_SESSION['rol'] == "TI"){
                    echo '<li><a href="solicitudes_hora_ingreso.php"> solicitudes hoy </a></li>'; 
                }
            ?>
            
            <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
        </ul>
                
            </nav>
        </section>

        <h1>Gestión de Departamentos</h1>

        <!-- Formulario para crear o editar departamento -->
        
    <section id="gestion_departamentos">
    <form  id="form_gestion_departamentos" action="/solicitud_de_permisos_laborales/app/controller/departamentoController.php" method="POST">
    <input type="hidden" name="id_departamento" value="<?php echo isset($departamento) ? $departamento['id_departamento'] : ''; ?>">

    <label for="nombre_departamento">Nombre del Departamento</label>
    <input type="text" id="nombre_departamento" name="nombre_departamento" required>

    <label for="id_lider">Líder</label>
    <select id="id_lider" name="id_lider">
        <option value="4">Seleccione un líder</option>

        <?php if (!empty($usuarios_selecion_lider)): ?>
            <?php foreach ($usuarios_selecion_lider as $posibles_lideres): ?>
                <option value="<?php echo htmlspecialchars($posibles_lideres['id_usuario']); ?>">
                    <?php echo htmlspecialchars($posibles_lideres['nombres'].' '.$posibles_lideres['apellidos']); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay líderes disponibles</option>
        <?php endif; ?>
    </select>

    <!-- Botón para crear un nuevo departamento -->
    <button type="submit" name="accion" value="crear">Crear Departamento</button>

    <!-- Botón para actualizar un departamento existente -->
    <!-- <button type="submit" name="accion" value="actualizar">Actualizar Departamento</button> -->
</form>
    </section>

 


        

        <!-- Tabla de Departamentos -->
         <section id="tabla_departamentos">
         <h2>Departamentos Existentes</h2>
         <table id="tabla_registros" class="tabla-departamentos">
    <thead>
        <tr>
            <th>ID Departamento</th>
            <th>Nombre del Departamento</th>
            <th>Nombre del Líder</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($departamentos)): ?>
            <?php foreach ($departamentos as $departamento): ?>
                <tr data-id="<?php echo $departamento['id_departamento']; ?>"
                    data-nombre="<?php echo $departamento['nombre_departamento']; ?>"
                    data-lider="<?php echo $departamento['id_lider']; ?>">
                    
                    <td class="td_solicitud"><?php echo htmlspecialchars($departamento['id_departamento']); ?></td>
                    <td class="td_solicitud"><?php echo htmlspecialchars($departamento['nombre_departamento']); ?></td>
                    <?php if (!empty($departamento['lider_nombre'] && $departamento['lider_apellido'])): ?>
                        <td class="td_solicitud"><?php echo htmlspecialchars($departamento['lider_nombre'] . ' ' . $departamento['lider_apellido']); ?></td>
                    <?php else: ?>
                        <td class="td_solicitud">No hay líder asignado</td>
                    <?php endif; ?>
                    <td class="td_solicitud">
                        <button style="background:none; border:none;" onclick="abrirModal(this)"><i class="fa-solid fa-pen-to-square" style="font-size: 22px; color:var(--verde-corporativo);"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay departamentos disponibles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal de actualización -->
<!-- Modal de actualización -->
<div id="modalActualizar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2>Actualizar Departamento</h2>
        <form id="formActualizar">
            <input type="hidden" id="modal_id_departamento">
            
            <label>Nombre del Departamento:</label>
            <input type="text" id="modal_nombre_departamento" required>
            
            <label>Líder del Departamento:</label>
            <select id="modal_id_lider" required>
            <?php if (!empty($usuarios_selecion_lider)): ?>
            <?php foreach ($usuarios_selecion_lider as $posibles_lideres): ?>
                <option value="<?php echo htmlspecialchars($posibles_lideres['id_usuario']); ?>">
                    <?php echo htmlspecialchars($posibles_lideres['nombres'].' '.$posibles_lideres['apellidos']); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">No hay líderes disponibles</option>
        <?php endif; ?>
            </select>

            <button type="button" onclick="guardarCambios()">Guardar Cambios</button>
        </form>
    </div>
</div>


         </section>
        
    </main>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/actualizar_departamentos.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/respuesta_departamentos.js"></script>
</body>
</html>