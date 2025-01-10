<?php
require_once __DIR__ . '/../models/SolicitudModel.php';

class SolicitudController {
    private $solicitudModel;

    public function __construct($solicitudModel) {
        $this->solicitudModel = $solicitudModel;
    }

    public function solicitudesRealizadas($cedula, $id_departamento) {
        // Si no se proporciona la cédula, retorna un array vacío
        if (!$cedula) {
            return [];
        }
    
        try {
            // Obtén el líder asociado al proceso
            $lider = $this->solicitudModel->lideres_proceso($id_departamento);
    
            // Obtén las solicitudes realizadas por el usuario
            $soli = $this->solicitudModel->solicitudes_realizadas($cedula);
    
            // Procesa el resultado para combinar
            $resultado = [
                'solicitudes' => $soli,
                'lider' => $lider,
            ];
    
            return $resultado;
    
        } catch (Exception $e) {
            // Registra el error en el log y retorna un array vacío
            error_log("Error en solicitudesRealizadas: " . $e->getMessage());
            return [];
        }
    }

    public function lideresProceso($id_departamento) {
        if (!$id_departamento) {
            return json_encode(['error' => 'El ID del departamento es obligatorio']);
        }

        try {
            $result = $this->solicitudModel->lideres_proceso($id_departamento);
            if ($result) {
                return json_encode(['success' => true, 'data' => $result]);
            }
            return json_encode(['error' => 'No se encontró líder para este departamento']);
        } catch (Exception $e) {
            error_log("Error en lideresProceso: " . $e->getMessage());
            return json_encode(['error' => 'Error al procesar la solicitud']);
        }
    }

    public function procesarFormulario($data) {
        // Validación básica de datos
        $campos_requeridos = [
            'nombre', 'email', 'departamento', 'fecha_solicitud',
            'fecha_permiso', 'hora_salida', 'hora_llegada',
            'observaciones', 'tipo_permiso'
        ];

        foreach ($campos_requeridos as $campo) {
            if (!isset($data[$campo]) || empty($data[$campo])) {
                return false;
            }
        }

        try {
            $registroExitoso = $this->solicitudModel->registrarSolicitud(
                $data['nombre'],
                $data['email'],
                $data['departamento'],
                $data['fecha_solicitud'],
                $data['fecha_permiso'],
                $data['hora_salida'],
                $data['hora_llegada'],
                $data['observaciones'],
                $data['tipo_permiso']
            );

            if ($registroExitoso) {
                $email_lider = $this->solicitudModel->lideres_proceso($data['departamento']);
                if ($email_lider) {
                    $this->solicitudModel->enviarCorreo($data['nombre'], $email_lider, $data['tipo_permiso']);
                }
            }

            return $registroExitoso;
        } catch (Exception $e) {
            error_log("Error en procesarFormulario: " . $e->getMessage());
            return false;
        }
    }
}