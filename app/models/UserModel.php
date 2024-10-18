<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verificarCredenciales($email, $password) {
        // Consulta SQL
        $sql = "SELECT nombre , cedula , correo, id_departamento , rol FROM usuarios WHERE correo = ? AND contrasena = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $this->db->error);
        }

        // Encriptacion de datos con haslib sha512
        $email_hashed = hash("sha512", $email);
        $password_hashed = hash("sha512", $password);

        // Ejecutar consulta
        $stmt->bind_param("ssi", $email_hashed, $password_hashed);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el usuario
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return false;
    }
}