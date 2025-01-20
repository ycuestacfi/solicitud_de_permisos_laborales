

<?php
require_once __DIR__ . '/../../conexion.php';


class DepartamentoModel {
    private $db;

    public function __construct()
    {
        $this->db = ConectService::conectar();
    }

    // Obtener todos los departamentos con el nombre del líder
    public function getDepartamentos() {
        $query = "SELECT d.id_departamento, d.nombre_departamento, u.nombre AS lider_nombre
                  FROM departamentos d
                  LEFT JOIN usuarios u ON d.id_lider = u.id_usuario";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los usuarios para asignarlos como líderes
    public function getUsuarios() {
        $query = "SELECT id_usuario, nombre FROM usuarios";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear o actualizar un departamento
    public function guardarDepartamento($nombre_departamento, $id_lider, $id_departamento = null) {
        if ($id_departamento) {
            // Actualizar departamento
            $query = "UPDATE departamentos SET nombre_departamento = ?, id_lider = ? WHERE id_departamento = ?";
            $this->db->prepare($query)->execute([$nombre_departamento, $id_lider, $id_departamento]);
        } else {
            // Crear nuevo departamento
            $query = "INSERT INTO departamentos (nombre_departamento, id_lider) VALUES (?, ?)";
            $this->db->prepare($query)->execute([$nombre_departamento, $id_lider]);
        }
    }

    // Eliminar departamento
    public function eliminarDepartamento($id_departamento) {
        $query = "DELETE FROM departamentos WHERE id_departamento = ?";
        $this->db->prepare($query)->execute([$id_departamento]);
    }
}
?>


?>

