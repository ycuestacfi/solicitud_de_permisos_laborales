<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/CookieHelper.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../../conexion.php';

// Crear instancia de la clase de conexión
$conectService = new ConectService();
$db = $conectService->getConnection();

// Clase LoginController
class LoginController {
    private $db;
    private $userModel;

    public function __construct($db) {
        // Guardar la conexión en una propiedad de la clase
        $this->db = $db;
        $this->userModel = new UserModel($db);
    }

    public function iniciarSesion() {
        // Verificar si la solicitud es POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $usuario_log = $_POST["usuario"];
            $password = $_POST["password"];

            // Verificar las credenciales
            $usuario = $this->userModel->verificarCredenciales($usuario_log, $password);

            if ($usuario) {
                // Iniciar sesión si las credenciales son válidas
                SessionHelper::iniciarSesion($usuario);

                // Si el usuario marcó "Recordarme", guardar las cookies
                if (isset($_POST['remember_me'])) {
                    CookieHelper::guardarCookies($usuario_log);
                }
 
                // Redirigir según el rol del usuario
                // $rol = strtolower($usuario['rol']);
                if ($_SESSION['rol'] === 'solicitante') {
                    header("Location: /app/views/solicitud_de_permisos.php");
                    exit();
                } elseif ($_SESSION['rol'] === 'lider_aprobador' || $_SESSION['rol'] === 'administrador') {
                    header("Location: /app/views/dashboard.php"); 
                    exit(); // Asegurar la terminación del script después del redireccionamiento
                }
               
            } else {
                // Credenciales incorrectas, mostrar mensaje de error
                echo "<script>alert('Credenciales incorrectas.');</script>";
            }
        }
    }
    // // Registra los usuarios 
    // public function registrarUsuario($correo, $cedula, $usuario) {
    //     // Verificar duplicados utilizando el modelo
    //     $duplicados = $this->userModel->verificarDuplicados($correo, $cedula, $usuario);

    //     // Manejar los errores de duplicados
    //     if ($duplicados) {
    //         if ($duplicados['correo'] == $correo) {
    //             $mensaje = "El correo ya está en uso. Por favor, utiliza otro.";
    //         } elseif ($duplicados['cedula'] == $cedula) {
    //             $mensaje = "La cédula ya se encuentra inscrita. Por favor, verifica la información.";
    //         } elseif ($duplicados['usuario'] == $usuario) {
    //             $mensaje = "El usuario ya está en uso. Por favor, utiliza otro.";
    //         }

    //         // Retornar mensaje a la vista
    //         return ['error' => true, 'mensaje' => $mensaje];
    //     } else {
    //         // Continuar con el registro (por ejemplo, insertar en la base de datos)
    //         // ...
    //         return ['error' => false, 'mensaje' => "Registro exitoso."];
    //     }
    // }

    public function cerrarSesion() {
        // Cerrar sesión y eliminar cookies
        SessionHelper::cerrarSesion();
        CookieHelper::eliminarCookies();
        // Redirigir al login después de cerrar la sesión
        header("Location: /app/views/login.php");
        exit();
    }

    public function verificarCierreViernes() {
        // Verificar si es viernes después de las 4 y cerrar sesión si es necesario
        if (SessionHelper::esViernesDespuesDeLasCuatro()) {
            $this->cerrarSesion();
        }
    }
}

// Instanciar el controlador de login y ejecutar iniciarSesion
$loginController = new LoginController($db);
$loginController->iniciarSesion();

?>
