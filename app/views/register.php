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
include_once __DIR__ . '/estructure/head.php';
include_once '../controller/UserController.php';

// Obtener la conexión a la base de datos
$db = new ConectService();
// $pdo = $db->getConnection();

// Instanciar modelo y controlador
$userModel = new UserModel($pdo);
$userController = new UserController($userModel);

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

<!-- Formulario de registro de usuarios -->
<form method="POST" style="position: relative; left: 50%; transform: translateX(-50%); height: 60%; width: 25%; display: flex; flex-direction: column; gap: 5px; background-color: var(--azul-oscuro-contraste); padding: 25px; border:solid 1px var(--blanco);">
    <h2 style="color: var(--verde-corporativo); font-size: 22px; margin:0px auto 20px; font-weight: 600;">Registro de nuevos usuarios</h2>
    
    <input type="text" class="input_solicitud" name="nombres" value="<?= htmlspecialchars($nombres) ?>" required placeholder="Ingrese los nombres del usuario:">

    <input type="text" class="input_solicitud" name="apellidos" value="<?= htmlspecialchars($apellidos) ?>" required placeholder="Ingrese los apellidos del usuario:">

    <input type="text" class="input_solicitud" name="cedula" value="<?= htmlspecialchars($cedula) ?>" required placeholder="Ingrese la cédula del usuario:">

    <input type="email" class="input_solicitud" name="correo" value="<?= htmlspecialchars($correo) ?>" required placeholder="Ingrese el Correo corporativo del usuario:">

    <label for="departamento">Seleccione el departamento:</label>
    <select class="input_solicitud" name="departamento" required>
        <!-- Opciones de departamentos -->
        <option value="2" <?= $departamento == '2' ? 'selected' : '' ?>>Académicas</option>
        <!-- Añadir más opciones -->
    </select>

    <label for="rol">Seleccione el rol del usuario:</label>
    <select class="input_solicitud" name="rol" required>
        <option value="solicitante" <?= $rol == 'solicitante' ? 'selected' : '' ?>>Solicitante</option>
        <option value="lider_aprobador" <?= $rol == 'lider_aprobador' ? 'selected' : '' ?>>Líder Aprobador</option>
        <option value="administrador" <?= $rol == 'administrador' ? 'selected' : '' ?>>Administrador</option>
    </select>

  
    <input type="text" class="input_solicitud" name="usuario" value="<?= htmlspecialchars($usuario) ?>" required placeholder="Ingrese un nombre de Usuario para ingreso al sistema:">

   
    <input type="password" class="input_solicitud" name="password" required placeholder="Ingrese una Contraseña:">

    <button type="submit" style="background-color: var(--verde-corporativo); border: solid 1px var(--blanco); width: 50%; margin: 0 auto; top: 13px; position: relative;">Registrar</button>
</form>

<?php include_once __DIR__ . '/estructure/footer.php';;
