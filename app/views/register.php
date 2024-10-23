<?php
include_once "./estructure/head.php";
require_once __DIR__ . '/../../conexion.php'; // Archivo de configuración para conectar a la base de datos

$db = new ConectService(); // Asegúrate de que tu clase de conexión se llame 'ConectService'
$pdo = $db->getConnection(); // Obtener la conexión PDO

$nombres = $apellidos = $cedula = $correo = $departamento = $rol = $usuario = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $password = hash('sha512', $_POST['password']); // Encriptar contraseña

      // Verificar si el correo ya existe
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = ? AND cedula = ? AND usuario = ? ");
      $stmt->execute([$correo,$cedula,$usuario]);
      $resultcount = $stmt->fetchColumn();
       
      if(!$resultcount){
        $resultu = $resultcount['correo'];
        $resultc= $resultcount['cedula'];
        $resultuser = $resultcount['usuario'];
        echo $resultc. $resultu. $resultuser ;
      }
  
    //   // Verificar si la cédula ya existe
    //   $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE cedula = ?");
    //   $stmt->execute([$cedula]);
    //   $countCedula = $stmt->fetchColumn();

    //   // Verificar si la cédula ya existe
    //   $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
    //   $stmt->execute([$usuario]);
    //   $countUsuario = $stmt->fetchColumn();
  
      // Manejar los errores de duplicados
    //   if ($countCorreo > 0) {
    //         echo "El correo ya está en uso. Por favor, utiliza otro.";
    //   } elseif ($countCedula > 0) {
    //         echo "La cédula ya se encuentra inscrita . Por favor, verifica la informacion.";
    //   } elseif ($countUsuario > 0) {
    //         echo "El usuario ya está en uso. Por favor, utiliza otro.";
    //   }else{
    //     // Insertar en la base de datos
    //     $stmt = $pdo->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, correo, id_departamento, rol, contrasena, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
    //     // Manejo de errores en la preparación de la consulta
    //     if ($stmt === false) {
    //         die("Error en la preparación de la consulta: " . implode(":", $pdo->errorInfo()));
    //     }

    //     // Ejecutar la consulta
    //     if ($stmt->execute([$nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario])) {
    //         echo "Registro exitoso.";
    //     } else {
    //         // Aquí obtienes información de error específica del statement
    //         $errorInfo = $stmt->errorInfo();
    //         echo "Error en el registro: " . implode(":", $errorInfo);
    //     }
    // }
}
?>

    <form method="POST" style="position: relative; left: 50%; transform: translateX(-50%); height: 60%; width: 25%; display: flex; flex-direction: column; gap: 5px; background-color: var(--azul-oscuro-contraste); padding: 25px; border:solid 1px var(--blanco);">

    <h2 style="color: var(--verde-corporativo); font-size: 22px; margin: auto; font-weight: 600; "> Registro de nuevos usuarios</h2>
        <label for="nombres">ingrese los nombres del usuario:</label>
        <input type="text" class="input_solicitud" name="nombres" value="<?= htmlspecialchars($nombres) ?>" required placeholder="Nombres">
        <label for="apellidos">ingrese los apellidos del usuario:</label>
        <input type="text" class="input_solicitud" name="apellidos" value="<?= htmlspecialchars($apellidos) ?>" required placeholder="Apellidos">
        <label for="cedula">ingrese la cedula del usuario:</label>
        <input type="text" class="input_solicitud" name="cedula" value="<?= htmlspecialchars($cedula) ?>" required placeholder="Cédula">
        <label for="correo">ingrese el correo del usuario:</label>
        <input type="email" class="input_solicitud" name="correo" value="<?= htmlspecialchars($correo) ?>" required placeholder="Correo">
        <label for="departamento">seleccione el departamento al que pertenecera el usuario:</label>
        <select class="input_solicitud" name="departamento" required>
            <option value="2" <?= $departamento == '2' ? 'selected' : '' ?>>Academicas</option>
            <option value="3" <?= $departamento == '3' ? 'selected' : '' ?>>Almacen y logistica</option>
            <option value="4" <?= $departamento == '4' ? 'selected' : '' ?>>Big bag</option>
            <option value="5" <?= $departamento == '5' ? 'selected' : '' ?>>Calidad</option>
            <option value="6" <?= $departamento == '6' ? 'selected' : '' ?>>Comercial</option>
            <option value="7" <?= $departamento == '7' ? 'selected' : '' ?>>Contabilidad</option>
            <option value="8" <?= $departamento == '8' ? 'selected' : '' ?>>Desarrollo de producto</option>
            <option value="9" <?= $departamento == '9' ? 'selected' : '' ?>>Producción</option>
            <option value="10" <?= $departamento == '10' ? 'selected' : '' ?>>Talento Humano</option>
            <option value="1" <?= $departamento == '1' ? 'selected' : '' ?>>Tecnología Informática</option>
        </select>
        <label for="rol">seleccione el rol del usuario:</label>
        <select class="input_solicitud" name="rol" required>
            <option value="solicitante" <?= $rol == 'solicitante' ? 'selected' : '' ?>>Solicitante</option>
            <option value="lider_aprobador" <?= $rol == 'lider_aprobador' ? 'selected' : '' ?>>Líder Aprobador</option>
            <option value="administrador" <?= $rol == 'administrador' ? 'selected' : '' ?>>Administrador</option>
            <!-- Otras opciones -->
        </select>
        <label for="usuario">ingrese un nombre de usuario:</label>
        <input type="text" class="input_solicitud" name="usuario" value="<?= htmlspecialchars($usuario) ?>" required placeholder="Usuario">
        <label for="password">ingrese la contraseña del usuario:</label>
        <input type="password" class="input_solicitud" name="password" required placeholder="Contraseña">
        <button type="submit" style="    background-color: var(--verde-corporativo);
    border: solid 1px var(--blanco);
    width: 50%;
    margin: 0 auto;
    top: 13px;
    position: relative;">Registrar</button>
    </form>

<?php 
include_once "./estructure/footer.php"
?>
