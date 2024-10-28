<?php
require_once __DIR__ . '/../../conexion.php';
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function lideres_proceso($id_departamento){
        if (isset($id_departamento)){
            $sql = "SELECT * FROM departamentos where id_departamento = ? ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }


    public function registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario) {
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, correo, id_departamento, rol, contrasena, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario]);
    }

}
?>    