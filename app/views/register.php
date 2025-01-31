<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
if ( $_SESSION['rol'] !== "administrador" && $_SESSION['rol'] !== "TI") {
    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php ");
    exit();
}
// Cargar dependencias

include_once '../controller/UserController.php';

include_once '../controller/departamentoController.php';
$departamentocontroler = new departamentoControler();
$departamentos = $departamentocontroler->listarDepartamentos();
// Obtener la conexión a la base de datos

// $pdo = $db->getConnection();

// Instanciar modelo y controlador

$userController = new UserController();

// Inicializar variables
$nombres = $apellidos = $cedula = $correo = $departamento = $rol = $usuario = $resultado = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Llamar al controlador para procesar el registro
    $resultado = $userController->registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $usuario, $password);
}

?>

<!-- Mostrar mensajes de error o éxito -->
<?php if (isset($resultado['error']) && $resultado['error']): ?>
    <p style="color:red;"><?php echo htmlspecialchars($resultado['mensaje']); ?></p>
<?php elseif (isset($resultado['mensaje'])): ?>
    <p style="color:green;"><?php echo htmlspecialchars($resultado['mensaje']); ?></p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/register.css">

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
<!-- Formulario de registro de usuarios -->
<form method="POST" id="form_register" action="/solicitud_de_permisos_laborales/app/controller/UserController.php">
    <h2 style="color: var(--verde-corporativo); font-size: 22px; margin:0px auto 20px; font-weight: 600;">Registro de nuevos usuarios</h2>
    
    <input type="text" class="input_solicitud" name="nombres" value="<?= htmlspecialchars($nombres) ?>" required placeholder="Ingrese los nombres del usuario:">

    <input type="text" class="input_solicitud" name="apellidos" value="<?= htmlspecialchars($apellidos) ?>" required placeholder="Ingrese los apellidos del usuario:">

    <input type="text" class="input_solicitud" name="cedula" value="<?= htmlspecialchars($cedula) ?>" required placeholder="Ingrese la cédula del usuario:">

    <input type="email" class="input_solicitud" name="correo" value="<?= htmlspecialchars($correo) ?>" required placeholder="Ingrese el Correo corporativo del usuario:">

    <label for="departamento">Seleccione el departamento:</label>
    <input class="input_solicitud" placeholder="lista de departamentos" list="departamentos" name="departamento" required>  
    <datalist id="departamentos">
        <?php if ($departamentos): ?>
            <?php foreach ($departamentos as $departamento): ?>
                <option value="<?php echo htmlspecialchars($departamento['id_departamento']); ?>" ><?php echo htmlspecialchars($departamento['nombre_departamento']); ?></option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="10">Debido a la falta de departamentos se asignará Talento Humano</option>
        <?php endif; ?>
    </datalist>

    <label for="rol">Seleccione el rol del usuario:</label>
    <input class="input_solicitud" placeholder="lista de roles" list="roles" name="rol" required>
    <datalist id="roles">
        <option value="solicitante">Solicitante</option>
        <option value="lider_aprobador">Líder Aprobador</option>
        <option value="administrador">Administrador</option>
    </datalist>
     

  
    <input type="text" class="input_solicitud" name="usuario" value="<?= htmlspecialchars($usuario) ?>" required placeholder="Ingrese un nombre de Usuario para ingreso al sistema:">

   
    <input type="password" class="input_solicitud" name="password" required placeholder="Ingrese una Contraseña:">

    <button type="submit" style="background-color: var(--verde-corporativo); border: solid 1px var(--blanco); width: 50%; margin: 0 auto; top: 13px; position: relative;">Registrar</button>
</form>

</main>
</body>
</html>