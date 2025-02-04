<?php

require_once __DIR__ . '/../models/SolicitudModel.php';
require_once __DIR__ . '/../models/departamentosModel.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class SolicitudController {
    public $solicitudModel;
    public $departamentosModel;

    public function __construct() {
        $this->solicitudModel = new solicitudModel();
        $this->departamentosModel = new DepartamentoModel();
    }

    // Método para cambiar el estado de la solicitud
    public function cambiarEstadoSolicitud($datos) {
        try {
            // Llamamos al modelo para actualizar el estado de la solicitud en la base de datos
            $resultado = $this->solicitudModel->actualizarEstado($datos['idSolicitud'], $datos['nuevoEstado'], $datos['comentario']);
            
            // Si la actualización fue exitosa, devolvemos una respuesta exitosa
            if ($resultado) {
    
                $this->solicitudModel->enviarCorreoEstado($datos);
    
                if ($datos['tipo_permiso'] == 'laboral' && $datos['nuevoEstado'] == 'aprobada') {
    
                    $info = $this->conseguirInfoLaboral($datos['identificador']);
                    $this->solicitudModel->enviarCorreoLaboral($datos, $info);
                }
    
                // Respuesta exitosa
                echo json_encode([
                    'success' => true,
                    'titulo' => '¡Bien!',
                    'texto' => 'Solicitud ' . $datos['nuevoEstado'] . ' con éxito.',
                    'icono' => 'success'
                ]);
                exit(); // Asegúrate de que el script termine aquí
            } else {
                // Respuesta de error
                echo json_encode([
                    'success' => false,
                    'titulo' => 'Vaya...',
                    'texto' => 'Error. Por favor, intenta de nuevo.',
                    'icono' => 'error'
                ]);
                exit(); // Asegúrate de que el script termine aquí
            }
        } catch (Exception $e) {
            // Si ocurre algún error, devolvemos un mensaje de error
            echo json_encode([
                'success' => false,
                'titulo' => 'Error',
                'texto' => 'Ocurrió un error: ' . $e->getMessage(),
                'icono' => 'error'
            ]);
            exit();
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

    public function solicitudesRealizadas($cedula) {
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

    public function procesarFormulario($nombre, $email, $cedula, $departamento, $fecha_de_solicitud, $fecha_de_permiso, $hora_de_salida, $hora_de_llegada) {
        if (!empty($_POST['observaciones'])) {
            // La variable no está vacía la declaramos
            $observaciones = $_POST['observaciones'];
        } else {
            // La variable no tiene valores y la declaramos manualmente
            $observaciones = "No se registraron observaciones en esta solicitud ";
        }
        
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
        $evidenciaPath = $this->guardarArchivo();
    
        try {
            
            if ($rol == "lider_aprobador" && $departamento == "11") {
                
                $_SESSION['mensaje'] = [
                    'titulo' => 'Error',
                    'texto' => 'El lider aprobador de administración no puede solicitar permisos',
                    'icono' => 'error'
                ];

                return true;

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
                    $placa_vehiculo,
                    $evidenciaPath
                );
        
                if ($registroExitoso) { // Se evalúa si es verdadero
                    // Obtener el email del líder del proceso
                    $info_lider = $this->solicitudModel->lideres_proceso($departamento);
                    $this->solicitudModel->enviarCorreo($nombre, $cedula, $email, $fecha_de_solicitud, $tipo_permiso, $fecha_de_permiso, $hora_de_salida, $hora_de_llegada, $observaciones, $info_lider);
                    $_SESSION['mensaje'] = [
                        'titulo' => '¡Bien!',
                        'texto' => 'Registro de solicitud exitoso.',
                        'icono' => 'success'
                    ];
                    // Redirigir a la página de solicitudes o retornar el registro exitoso
                    header("Location: /solicitud_de_permisos_laborales/app/views/solicitud_de_permisos.php");
                    exit();
                } else {
                    // Si la consulta no fue exitosa
                    $_SESSION['mensaje'] = [
                        'titulo' => 'Error',
                        'texto' => 'Hubo un problema al registrar la solicitud.',
                        'icono' => 'error'
                    ];
                    header("Location: /solicitud_de_permisos_laborales/app/views/solicitud_de_permisos.php");
                    exit();
                }

            }
        } catch (Exception $e) {
            error_log("Error en procesarFormulario: " . $e->getMessage());
            return false;
            // return json_encode(['error' => 'Error al procesar la solicitud' . $e->getMessage()]); 
        }
    }

    private function guardarArchivo() {
        if (isset($_FILES['evidencias']) && $_FILES['evidencias']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/evidencias/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $file = $_FILES['evidencias'];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxFileSize = 100 * 1024 * 1024;
            
            if (!in_array($fileExt, $allowedExtensions)) {
                return null;
            } elseif ($file['size'] > $maxFileSize) {
                return null;
            } else {
                $uniqueId = uniqid('solicitud_', true) . '.' . $fileExt;
                $uploadPath = $uploadDir . $uniqueId;
                
                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    return $uploadPath;
                }
            }
        }elseif (isset($_FILES['subir_evidencia']) && $_FILES['subir_evidencia']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/evidencias/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $file = $_FILES['subir_evidencia'];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxFileSize = 100 * 1024 * 1024;
            
            if (!in_array($fileExt, $allowedExtensions)) {
                return null;
            } elseif ($file['size'] > $maxFileSize) {
                return null;
            } else {
                $uniqueId = uniqid('solicitud_', true) . '.' . $fileExt;
                $uploadPath = $uploadDir . $uniqueId;
                
                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    return $uploadPath;
                }
            }
        }
        return null;
    } 
    
    public function historico($datos) {
        $historicos = $this->solicitudModel->historico($datos);
        if ($historicos) {
            return $historicos;
        } else {
            return json_encode(['error' => 'No se encontraron ningun historico']);
        }
    }

    public function ver_historico() {
        $historicos = $this->solicitudModel->ver_historico();
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

    public function subirEvidencia() {
        $evidenciaPath = $this->guardarArchivo();
        $identificador = $_POST['identificador_solicitud'];

        return $this->solicitudModel->subirEvidencia($evidenciaPath,$identificador);
    }

}

// Instanciar el controlador
$solicitudController = new SolicitudController();

// Procesar la solicitud PUT
$solicitudController->procesarPutRequest();

if (isset($_FILES['subir_evidencia']) && $_FILES['subir_evidencia']['error'] === UPLOAD_ERR_OK){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $solicitudController = new SolicitudController();
        $resultado = $solicitudController->subirEvidencia();

        if($resultado) {
            header("Location: /solicitud_de_permisos_laborales/app/views/solicitudes.php");
        } else {
            echo json_encode("ERROR");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["accion"]) && $_POST["accion"] != "guardar_historico") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];
    $departamento = $_POST['departamento'];
    $fecha_de_solicitud = $_POST['fecha_de_solicitud'];
    $fecha_de_permiso = $_POST['fecha_de_permiso'];
    $hora_de_salida = $_POST['hora_de_salida'];
    $hora_de_llegada = $_POST['hora_de_llegada'];

    $solicitudController = new SolicitudController();

    $solicitudController->procesarFormulario($nombre, $email, $cedula, $departamento, $fecha_de_solicitud, $fecha_de_permiso, $hora_de_salida, $hora_de_llegada);
} else if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {

    // Leer el cuerpo de la solicitud
    $jsonData = file_get_contents('php://input');  // Obtiene los datos JSON del cuerpo de la solicitud

    // Decodificar los datos JSON en un array asociativo
    $data = json_decode($jsonData, true);

    // Verificar que 'accion' y 'idSolicitud' estén en los datos recibidos
    if (isset($data["accion"]) && $data["accion"] === "Procesar") {
        // Capturar los datos del JSON
        $idSolicitud = $data["idSolicitud"];
        
        // Crear el array de datos a enviar al histórico
        $datos = [
            "id_solicitud" => $idSolicitud,
            "estado" => "terminada"
        ];

        // Llamar a la función para registrar en el histórico
        $resultado = $solicitudController->historico($datos);

        // Responder con JSON
        if ($resultado) {
            echo json_encode([
                "success" => true,
                "mensaje" => "Solicitud procesada correctamente."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "mensaje" => "Error al procesar la solicitud."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Acción no válida."
        ]);
    }
}