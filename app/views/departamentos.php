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
        <option value="">Seleccione un líder</option>

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
    <button type="submit" name="accion" value="actualizar">Actualizar Departamento</button>
</form>
    </section>

 


        

        <!-- Tabla de Departamentos -->
         <section id="tabla_departamentos">
         <h2>Departamentos Existentes</h2>
        <table id="tabla_registros"  class="tabla-departamentos">
            <thead>
                <tr>
                    <th>ID Departamento</th>
                    <th>Nombre del Departamento</th>
                    <th>Nombre del Líder</th>
                </tr>
            </thead>
            <tbody  >
                <?php if (($departamentos)): ?>
                    <?php foreach ($departamentos as $departamento): ?>
                        <tr >
                            <td  class=td_solicitud style=" text-align: center;"><?php echo htmlspecialchars($departamento['id_departamento']); ?></td>
                            <td  class=td_solicitud ><?php echo htmlspecialchars($departamento['nombre_departamento']); ?></td>
                            <td  class=td_solicitud >
                                <?php 
                                // Si no hay líder asignado, mostrar un mensaje
                                echo htmlspecialchars(!empty($departamento['lider_nombre'] . $departamento['lider_apellido']) ? $departamento['lider_nombre'] .' '. $departamento['lider_apellido'] : 'Sin líder asignado'); 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay departamentos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
         </section>
        
    </main>
</body>
</html>