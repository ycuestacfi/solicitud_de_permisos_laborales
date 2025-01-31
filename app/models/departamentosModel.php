

<?php
require_once __DIR__ . '/../../conexion.php';


class DepartamentoModel {
    private $db;

    public function __construct()
    {
        $this->db = ConectService::conectar();
    }
    // obtiene los datos para manejo de solicitudes
    public function departamentos_data($id_departamento) {
        if (isset($id_departamento)) {
            $sql = "SELECT  usuarios.nombres,usuarios.apellidos,usuarios.correo
                    FROM usuarios 
                    INNER JOIN departamentos ON usuarios.id_usuario = departamentos.id_lider 
                    WHERE departamentos.id_departamento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_departamento]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }

    // Obtener todos los departamentos con el nombre del líder
    public function getDepartamentos() {
        try {
            $query = "SELECT d.id_departamento, d.nombre_departamento, d.id_lider , u.nombres AS lider_nombre,u.apellidos AS lider_apellido
                  FROM departamentos d
                  LEFT JOIN usuarios u ON d.id_lider = u.id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->execute();  // Ejecuta la consulta
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtiene los resultados

            return $result;  // Retorna los resultados obtenidos

        } catch (PDOException $e) {
            // Manejo de errores si la consulta falla
            error_log("Error en getDepartamentos: " . $e->getMessage());
            return false;  // Retorna false en caso de error
        }
    }

    // Obtener todos los usuarios para asignarlos como líderes
    public function getUsuarios() {
        $query = "SELECT id_usuario, nombres FROM usuarios";  // Cambié 'nombre' por 'nombres'
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