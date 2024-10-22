<?php
require_once __DIR__ . '/../../conexion.php';
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verificarCredenciales($usuario, $password) {
        // Consulta SQL corregida
        $sql = "SELECT nombres, cedula, correo, id_departamento, rol FROM usuarios WHERE usuario = ? AND contrasena = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . implode(":", $this->db->errorInfo()));
        }

        // Encriptar contraseña usando SHA512
        $password_hashed = hash("sha512", $password);

        // Ejecutar la consulta con los valores
        $stmt->execute([$usuario, $password_hashed]);

        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el usuario
        return $result ?: false;
    }
}
