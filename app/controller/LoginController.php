<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/UserModel.php';
// require_once __DIR__ . '/../helpers/CookieHelper.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';


// Clase LoginController
class LoginController {
    private $userModel;

    public function __construct() {
        // Guardar la conexión en una propiedad de la clase
        $this->userModel = new UserModel();
    }

    public function iniciarSesion() {
    // Verificar si la solicitud es POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $usuario_log = $_POST["usuario"];
        $password = $_POST["password"];

        // Verificar las credenciales
        $usuario = $this->userModel->verificarCredenciales($usuario_log, $password);
        
        if ($usuario) {
            // Verificar si el estado del usuario es "activo"
            if ($usuario['estado'] == 'activo') {
                // Iniciar sesión si las credenciales son válidas
                SessionHelper::iniciarSesion($usuario);

                // $misSolicitudes = $this->solicitudModel->solicitudes_realizadas($usuario['cedula']);
                // var_dump($misSolicitudes);
                // Si el usuario marcó "Recordarme", guardar las cookies
                if (isset($_POST['remember_me'])) {
                    CookieHelper::guardarCookies($usuario_log);
                }

                // Redirigir según el rol del usuario
                if ($_SESSION['rol'] === 'solicitante') {   
                    header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php");
                    exit();
                } elseif ($_SESSION['rol'] === 'lider_aprobador' || $_SESSION['rol'] === 'administrador') {
                      
                        header("Location: /solicitud_de_permisos_laborales/app/views/dashboard.php");
                        exit();
                }
            } else {
                // Si el estado del usuario no es "activo", redirigir o mostrar mensaje
                $mensaje = "Usuario inactivo, por favor contacte al administrador.";
                $titulo = "Error";
                $icono = "error";
               
                // Redirigir a la página de login con parámetros GET
                header("Location: /solicitud_de_permisos_laborales/app/views/login.php");
                exit();
            }
        } else {
            // Credenciales incorrectas, mostrar mensaje de error
                $mensaje = "Credenciales incorrectas por favor intentelo de nuevo.";
                $titulo = "Error";
                $icono = "error";
                
                // Redirigir a la página de login con parámetros GET
                header("Location: /solicitud_de_permisos_laborales/app/views/login.php");
                exit();
        }
    }
}
    

    public function cerrarSesion() {
        // Cerrar sesión y eliminar cookies
        SessionHelper::cerrarSesion();
        // CookieHelper::eliminarCookies();
        // Redirigir al login después de cerrar la sesión
        header("Location: /solicitud_de_permisos_laborales/app/views/login.php");
        exit();
    }

}

// Instanciar el controlador de login y ejecutar iniciarSesion
$loginController = new LoginController();
$loginController->iniciarSesion();

?>
