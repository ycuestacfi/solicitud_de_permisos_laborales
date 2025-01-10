<?php
class CookieHelper {
    public static function guardarCookies($usuario_log) {
        setcookie('usuario', $usuario_log, time() + (86400 * 30), '/'); // Guarda por 30 días
    }

    public static function eliminarCookies() {
        setcookie('usuario', '', time() - 3600, '/');
    }
}
?>