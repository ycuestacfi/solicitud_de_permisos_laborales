<?php

require_once __DIR__ . '/../models/SolicitudModel.php';

class SolicitudController {
    public $solicitudModel;

    public function __construct() {
        $this->solicitudModel = new solicitudModel();
    }

    // Método para cambiar el estado de la solicitud
    public function cambiarEstadoSolicitud($datos) {
        try {
            // Llamamos al modelo para actualizar el estado de la solicitud en la base de datos
            $resultado = $this->solicitudModel->actualizarEstado($datos['idSolicitud'], $datos['nuevoEstado']);
            
            // Si la actualización fue exitosa, redirigimos o mostramos un mensaje
            if ($resultado) {

                $this->solicitudModel->enviarCorreoEstado($datos);

                if ($datos['tipo_permiso'] == 'laboral' && $datos['nuevoEstado'] == 'aprobada') {

                    $info = $this->conseguirInfoLaboral($datos['identificador']);

                    $this->solicitudModel->enviarCorreoLaboral($datos, $info);
                    
                }

                // Aquí se redirige a una página o se pasa una variable de éxito
                return $resultado;
            } else {
                // return "No se pudo actualizar el estado.";
                return $resultado;
            }
        } catch (Exception $e) {
            // Si ocurre algún error, lo capturamos y mostramos el mensaje
            return "Error al actualizar el estado: " . $e->getMessage();
        }
    }

    public function conseguirInfoLaboral($identificador) {
        if ($identificador != null) {
            $info = $this->solicitudModel->infoLaboral($identificador);
            if ($info) {
                return $info;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function solicitudesDeDepartamento($id_departamento){
        if (!$id_departamento) {
            return json_encode(['error' => 'El ID del departamento es obligatorio']);
        } else {
            $solicitudes = $this->solicitudModel->solicitudesDeDepartamento($id_departamento);
            if ($solicitudes) {
                return $solicitudes;
            } else {
                return false;
            }
        }
    }

    public function solicitudesDeTerminadas(){
        $aprovadas = $this->solicitudModel->solicitudesDeTerminadas();
        if ($aprovadas) {
            return $aprovadas;
        } else {
            return json_encode(['error' => 'No se encontro ninguna sollitud']);
        }
    }

    public function solicitudesRealizadas($cedula, $id_departamento) {
        // Si no se proporciona la cédula, retorna un array vacío
        if (!$cedula) {
            return [];
        }
    
        try {
            // Obtén las solicitudes realizadas por el usuario
            $soli = $this->solicitudModel->solicitudes_realizadas($cedula);
            // Procesa el resultado para combinar
                $resultado = $soli;
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

    public function procesarFormulario() {
        // Variables comunes
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $cedula = $_POST['cedula'];
        $departamento = $_POST['departamento'];
        $fecha_de_solicitud = $_POST['fecha_de_solicitud'];
        $fecha_de_permiso = $_POST['fecha_de_permiso'];
        $hora_de_salida = $_POST['hora_de_salida'];
        $hora_de_llegada = $_POST['hora_de_llegada'];
        $observaciones = $_POST['observaciones'];
        // $evidencias = $_FILES['evidencias']; // Para manejar archivos
        $tipo_permiso = $_POST['tipo_permiso'];
        $rol = $_POST['rol'];
    
        // Variables específicas para permisos laborales
        $motivo_del_desplazamiento = "";
        $departamento_de_desplazamiento = "";
        $municipio_del_desplazamiento = "";
        $lugar_desplazamiento = "";
        $medio_de_transporte = "";
        $placa_vehiculo = "";
    
        // Asignar valores específicos si el tipo de permiso es "laboral"
        if ($tipo_permiso === 'laboral') {
            $motivo_del_desplazamiento = $_POST['motivo_del_desplazamiento'];
            $departamento_de_desplazamiento = $_POST['departamento_de_desplazamiento'];
            $municipio_del_desplazamiento = $_POST['municipio_del_desplazamiento'];
            $lugar_desplazamiento = $_POST['lugar_desplazamiento'];
            $medio_de_transporte = $_POST['medio_de_transporte'];
    
            if ($medio_de_transporte === 'AUTOMOVIL' || $medio_de_transporte === 'MOTOCICLETA') {
                $placa_vehiculo = $_POST['placa_vehiculo'];
            }
        }
    
        try {
            
            if ($rol == "lider_aprobador" && $departamento == "11") {
                
                return "El lider aprobador de administración no puede solicitar permisos";

            } else {
                // Llamar al modelo para registrar la solicitud con todos los campos
                $registroExitoso = $this->solicitudModel->registrarSolicitud(
                    $nombre,
                    $email,
                    $cedula,
                    $departamento,
                    $fecha_de_solicitud,
                    $fecha_de_permiso,
                    $hora_de_salida,
                    $hora_de_llegada,
                    $observaciones,
                    $tipo_permiso,
                    $motivo_del_desplazamiento,
                    $departamento_de_desplazamiento,
                    $municipio_del_desplazamiento,
                    $lugar_desplazamiento,
                    $medio_de_transporte,
                    $placa_vehiculo
                    // ,
                    // $evidencias
                );
        
                if ($registroExitoso) {
                    // Obtener el email del líder del proceso
                    $info_lider = $this->solicitudModel->lideres_proceso($departamento);
                    // $this->solicitudModel->enviarCorreo($nombre, $cedula, $email, $fecha_de_solicitud, $tipo_permiso, $fecha_de_permiso, $hora_de_salida, $hora_de_llegada, $observaciones, $info_lider);
                    // return header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php");
                    exit;
                
                }
        
                return $registroExitoso;

            }
        } catch (Exception $e) {
            error_log("Error en procesarFormulario: " . $e->getMessage());
            // return false;
            return json_encode(['error' => 'Error al procesar la solicitud' . $e->getMessage()]); 
        }
    }

    // Método para manejar las solicitudes PUT
    public function procesarPutRequest() {
        // Limpiar cualquier salida previa
        ob_clean();
        // Verificar si la solicitud es PUT
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Obtener los datos en formato JSON del cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);

            // Verificar que los datos necesarios estén presentes
            if (isset($data['idSolicitud']) && isset($data['nuevoEstado'])) {
                // Llamar a la función cambiarEstadoSolicitud con los datos recibidos
                $resultado = $this->cambiarEstadoSolicitud($data);
                
                // Responder con los resultados en formato JSON
                echo json_encode(['resultado' => 'Estado cambiado.']);
            } else {
                // Si faltan parámetros, responder con un error
                echo json_encode(['error' => 'Faltan parámetros']);
            }
        } 
    }
    
    public function historico($datos) {
        $historicos = $this->solicitudModel->historico($datos);
        if ($historicos) {
            return $historicos;
        } else {
            return json_encode(['error' => 'No se encontraron ningun historico']);
        }
    }

    public function horaIngreso() {
        $aceptadas = $this->solicitudModel->hora_ingreso();
        if ($aceptadas) {
            return $aceptadas;
        } else {
            return json_encode(['error' => 'No se encontraron solicitudes de llegada pendientes']);
        }
    }

    public function edicionHora($hora,$id) {

        $resultado = $this->solicitudModel->edicionHora($hora,$id);

        if ($resultado) {
            return $resultado;
        } else {
            return json_encode(['error' => 'No se puedo editar la hora de llegada']);
        }

    }

}

// Instanciar el controlador
$solicitudController = new SolicitudController();

// Procesar la solicitud PUT
$solicitudController->procesarPutRequest();