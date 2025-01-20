<?php
require_once __DIR__ . '/../controller/departamentoController.php';



class DepartamentosController {
    private $model;

    public function __construct() {
        $this->model = new DepartamentoModel(); // Crear una instancia del modelo
    }

    // Mostrar departamentos
    public function index() {
        // Obtener todos los departamentos y usuarios
        $departamentos = $this->model->getDepartamentos();
        $usuarios = $this->model->getUsuarios();

        // Incluir la vista
        require_once('views/departamentos.php');
    }

    // Crear o actualizar un departamento
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre_departamento = $_POST['nombre_departamento'];
            $id_lider = $_POST['id_lider'];
            $id_departamento = isset($_POST['id_departamento']) ? $_POST['id_departamento'] : null;
            
            // Llamar al modelo para guardar o actualizar
            $this->model->guardarDepartamento($nombre_departamento, $id_lider, $id_departamento);
            
            // Redirigir a la página de gestión de departamentos
            header('Location: /departamentos');
        }
    }

    // Eliminar un departamento
    public function eliminar($id_departamento) {
        // Llamar al modelo para eliminar el departamento
        $this->model->eliminarDepartamento($id_departamento);
        
        // Redirigir a la página de gestión de departamentos
        header('Location: /departamentos');
    }
}
?>

?>
