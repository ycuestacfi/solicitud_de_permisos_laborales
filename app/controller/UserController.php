<?php
require_once __DIR__ . '/../models/UserModel.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class UserController {
    private $userModel;

    public function __construct() {
        // Guardar la conexión en una propiedad de la clase
        $this->userModel = new UserModel();
    }

    public function selecion_de_lider(){
        $usuarios = $this->userModel->selecionar_lider();
        if($usuarios){
            return $usuarios;
        }else{
            return 'No se encontraron usuarios';
        }
        
    }

    public function registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $usuario, $password) {
        // Verificar duplicados
        if ($this->userModel->verificarDuplicado('correo', $correo) > 0) {
            return ['error' => true, 'mensaje' => 'El correo ya está en uso. Por favor, utiliza otro.'];
        }

        if ($this->userModel->verificarDuplicado('cedula', $cedula) > 0) {
            return ['error' => true, 'mensaje' => 'La cédula ya se encuentra inscrita. Por favor, verifica la información.'];
        }

        if ($this->userModel->verificarDuplicado('usuario', $usuario) > 0) {
            return ['error' => true, 'mensaje' => 'El usuario ya está en uso. Por favor, utiliza otro.'];
        }

        // Encriptar contraseña
        $passwordHash = hash('sha512', $password);

        // Registrar usuario
        $registroExitoso = $this->userModel->registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $usuario, $passwordHash);
        
        if ($registroExitoso) {
            return ['error' => false, 'mensaje' => 'Registro exitoso.'];
        } else {
            return ['error' => true, 'mensaje' => 'Error en el registro. Por favor, intenta de nuevo.'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Instanciar el controlador
    $userController = new UserController();

    // Procesar la solicitud PUT
    $respuesta = $userController->registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $usuario, $password);

    if (!$respuesta['error']) {
        $_SESSION['mensaje'] = [
            'titulo' => '¡Bien!',
            'texto' => 'Registro de usuario exitoso.',
            'icono' => 'success'
        ];
        header("Location: /solicitud_de_permisos_laborales/app/views/register.php");
        exit();
    } else {
        $_SESSION['mensaje'] = [
            'titulo' => 'Vaya...',
            'texto' => 'Error en el registro. Por favor, intenta de nuevo.',
            'icono' => 'error'
        ];
        header("Location: /solicitud_de_permisos_laborales/app/views/register.php");
        exit();
    }
}