<?php
require_once '../models/departamentosmodel.php';

class departamentoControler {
    private $departamentomodel;

    public function __construct() {
        $this->departamentomodel = new departamentomodel();
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
?>
