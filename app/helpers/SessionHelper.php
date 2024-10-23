<?php
class SessionHelper {
    public static function iniciarSesion($usuario) {
        session_start();
        $_SESSION['nombres'] = $usuario['nombres'];
        $_SESSION['apellidos'] = $usuario['apellidos'];
        $_SESSION['cedula'] = $usuario['cedula'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['id_departamento'] = $usuario['id_departamento'];
        $_SESSION['rol'] = $usuario['rol'];
    }

    public static function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function esViernesDespuesDeLasCuatro() {
        $fecha_actual = new DateTime();
        $dia_semana = $fecha_actual->format('N'); // 5 = Viernes
        $hora_actual = $fecha_actual->format('H:i');

        return $dia_semana == 5 && $hora_actual >= '16:00';
    }
}
?>