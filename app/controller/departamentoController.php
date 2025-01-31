<?php
require_once '../models/departamentosmodel.php';

class departamentoControler {
    private $departamentomodel;

    public function __construct() {
        $this->departamentomodel = new departamentomodel();
    }

    public function gestion_departamentos(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            $accion = $_POST['accion'];
            $id_departamento = $_POST['id_departamento'] ?? null;
            $nombre_departamento = $_POST['nombre_departamento'] ?? '';
            $id_lider = $_POST['id_lider'] ?? null;
    
            if ($accion === 'crear') {
                $resultado = $this->departamentomodel->crearDepartamento($nombre_departamento, $id_lider);
                echo $resultado ? "Departamento creado correctamente" : "Error al crear el departamento";
            } elseif ($accion === 'actualizar' && !empty($id_departamento)) {
                $resultado = $this->departamentomodel->actualizarDepartamento($id_departamento, $nombre_departamento, $id_lider);
                echo $resultado ? "Departamento actualizado correctamente" : "Error al actualizar el departamento";
            } else {
                echo "Acción no válida";
            }
            exit();
        }
    }
    // funcion para solicitudes 
    public function getDepartamentodata($id_departamento) {
        if (!empty($id_departamento)) {
            $data_departamento = $this->departamentomodel->departamentos_data($id_departamento);
            if ($data_departamento) {
                return $data_departamento;
            } else {
                return "No hay datos de un líder para este departamento.";
            }
        } else {
            return "No hay datos de un líder para este departamento.";
        }
    }
    
    // lista de departamentos para administracion TTHH
    public function listarDepartamentos() {
        $departamentos = $this->departamentomodel->getDepartamentos();
        if($departamentos){
            return $departamentos;
        }else{
            return 'No se encontraron departamentos establecidos';
        }
    }
    
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
        $departamentoController = new departamentoControler();
        $departamentoController->gestion_departamentos();
    }
?>