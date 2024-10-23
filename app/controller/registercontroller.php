<?php
require_once __DIR__ . '/../../conexion.php'; // Archivo de configuración para conectar a la base de datos
$db = new ConectService(); // Asegúrate de que tu clase de conexión se llame 'ConectService'
$pdo = $db->getConnection(); // Obtener la conexión PDO

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
      $stmt->execute([$correo]);
      $resultcount = $stmt->fetchColumn();
    var_dump($resultcount);
  
    //   // Verificar si la cédula ya existe
    //   $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE cedula = ?");
    //   $stmt->execute([$cedula]);
    //   $countCedula = $stmt->fetchColumn();

    //   // Verificar si la cédula ya existe
    //   $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
    //   $stmt->execute([$usuario]);
    //   $countUsuario = $stmt->fetchColumn();
  
      // Manejar los errores de duplicados
      if ($countCorreo > 0) {
            echo "El correo ya está en uso. Por favor, utiliza otro.";
      } elseif ($countCedula > 0) {
            echo "La cédula ya se encuentra inscrita . Por favor, verifica la informacion.";
      } elseif ($countUsuario > 0) {
            echo "El usuario ya está en uso. Por favor, utiliza otro.";
      }else{
        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, correo, id_departamento, rol, contrasena, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Manejo de errores en la preparación de la consulta
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . implode(":", $pdo->errorInfo()));
        }

        // Ejecutar la consulta
        if ($stmt->execute([$nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario])) {
            echo "Registro exitoso.";
        } else {
            // Aquí obtienes información de error específica del statement
            $errorInfo = $stmt->errorInfo();
            echo "Error en el registro: " . implode(":", $errorInfo);
        }
    }
}
?>