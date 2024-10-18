<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/CookieHelper.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../../conexion.php';

class LoginController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
    }

    public function iniciarSesion() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = $_POST["password"];

            // Verificar las credenciales
            $id_dep = 1; // Asignar el departamento
            $usuario = $this->userModel->verificarCredenciales($email, $password, $id_dep);

            if ($usuario) {
                SessionHelper::iniciarSesion($usuario);

                // Si el usuario marcó "Recordarme", guardar las cookies
                if (isset($_POST['remember_me'])) {
                    CookieHelper::guardarCookies($email);
                }

                // Redirigir según el rol
                $rol = strtolower($usuario['rol']);
                if ($rol === 'solicitante') {
                    header("Location: /views/solicitud_de_permisos.php");
                } elseif ($rol === 'lider_aprobador') {
                    header("Location: /views/dashboard.php");
                } elseif ($rol === 'administrador') {
                    header("Location: /views/dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('Credenciales incorrectas.');</script>";
            }
        }
    }

    public function cerrarSesion() {
        SessionHelper::cerrarSesion();
        CookieHelper::eliminarCookies();
        header("Location: /app/views/login.php");
        exit();
    }

    public function verificarCierreViernes() {
        if (SessionHelper::esViernesDespuesDeLasCuatro()) {
            $this->cerrarSesion();
        }
    }
}
?>