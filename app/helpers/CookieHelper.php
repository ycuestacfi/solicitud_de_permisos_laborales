<?php
class CookieHelper {
    public static function guardarCookies($email) {
        setcookie('correo', $email, time() + (86400 * 30), '/'); // Guarda por 30 días
    }

    public static function eliminarCookies() {
        setcookie('correo', '', time() - 3600, '/');
    }
}
?>