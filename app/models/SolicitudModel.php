<?php
require_once __DIR__ . '/../../conexion.php';
class solicitudModel {
    private $db;

    public function __construct()
    {
        $this->db = ConectService::conectar();
    }

    public function actualizarEstado($id_solicitud, $estado){
        // Asegúrate de que $id_solicitud es un valor entero
        $id_solicitud = (int) $id_solicitud;

        // La consulta SQL para actualizar el estado de la solicitud
        $sql = "UPDATE solicitudes SET estado = :estado WHERE id_solicitud = :id_solicitud";

        // Preparamos la consulta con la conexión de la base de datos
        $stmt = $this->db->prepare($sql);

        // Ejecutamos la consulta pasando los valores como un arreglo asociativo
        $stmt->execute([
            ':estado' => $estado,
            ':id_solicitud' => $id_solicitud
        ]);
        // Registrar el cambio en el historial
        $this->registrarHistorico($id_solicitud, $estado);
    
        return $stmt->rowCount();
    }
    
    public function registrarHistorico($id_solicitud, $estado){
        // Consulta para obtener los datos de la solicitud actual
        $sql = "SELECT id_departamento, fecha_permiso, estado, identificador_solicitud FROM solicitudes WHERE id_solicitud = :id_solicitud";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_solicitud' => $id_solicitud]);
    
        // Obtener los datos de la solicitud
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si se obtuvieron los datos
        if ($datos) {
            // Extraer los datos obtenidos de la solicitud
            $idDepartamento = $datos['id_departamento'];
            $fechaPermiso = $datos['fecha_permiso'];
            $identificadorSolicitud = $datos['identificador_solicitud'];
    
            // Otros datos a registrar, como la fecha y usuario
            $fechaRegistro = date('Y-m-d H:i:s'); // Fecha y hora actual
    
            // Insertar los datos en la tabla historial
            $insertSql = "INSERT INTO historial_solicitudes (id_solicitud, id_departamento, fecha_permiso, estado, identificador_solicitud, fecha_cambio)
                          VALUES (:id_solicitud, :id_departamento, :fecha_permiso, :estado, :identificador_solicitud, :fecha_cambio)";
    
            // Preparamos la consulta de inserción
            $insertStmt = $this->db->prepare($insertSql);
    
            // Ejecutamos la inserción con los datos actuales y anteriores
            $insertStmt->execute([
                ':id_solicitud' => $id_solicitud,
                ':id_departamento' => $idDepartamento,
                ':fecha_permiso' => $fechaPermiso,
                ':estado' => $estado, // Estado actual
                ':identificador_solicitud' => $identificadorSolicitud,
                ':fecha_cambio' => $fechaRegistro
            ]);
    
            return $insertStmt->rowCount(); // Verificar si se insertó correctamente
        }
    
        return false; // Si no se encontraron datos, retornar falso
    }

    public function solicitudesDeDepartamento($id_departamento){
        $sql = "SELECT * FROM solicitudes WHERE id_departamento = ? AND estado = 'pendiente';";
        $smtp = $this->db->prepare($sql);
        $smtp->execute([$id_departamento]);
        return $smtp->fetchAll(PDO::FETCH_ASSOC);
    }

    //Método para generar identificador_solicitud
    public function generarIdentificador(){
        $sql = "SELECT MAX(identificador_solicitud) AS ultimo_id FROM solicitudes";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        // Recuperamos el último identificador
        $ultimoIdentificador = $stmt->fetchColumn(); // fetchColumn devuelve el primer valor de la primera fila
        
        if ($ultimoIdentificador !== false) {
            // Extraemos el número del código usando preg_match
            preg_match('/(\d+)$/', $ultimoIdentificador, $matches); // Busca el número al final del código
            
            if (isset($matches[0])) {
                // Incrementamos el número (hacemos el parseo a entero, luego sumamos 1)
                $numero = (int)$matches[0] + 1;
        
                // Formateamos el número con ceros a la izquierda para que tenga siempre 5 dígitos
                $nuevoNumero = str_pad($numero, 5, '0', STR_PAD_LEFT);
        
                // Retornamos el nuevo código
                return 'SOLICITUD-' . $nuevoNumero;
            }
        } else {
            // Si no hay ningún identificador (es la primera solicitud, por ejemplo)
            return 'SOLICITUD-00001';
        }
    }

     // Método para registrar una solicitud en la base de datos
     public function registrarSolicitud($nombre, $email, $cedula, $departamento, $fecha_solicitud, $fecha_permiso, $hora_salida, $hora_llegada, $observaciones, $tipo_permiso) {
        // Consulta para insertar los datos en la tabla de solicitudes
        $identificador = $this -> generarIdentificador();

        $sql = "INSERT INTO solicitudes (identificador_solicitud, nombre, cedula, correo, id_departamento, fecha_solicitud, fecha_permiso, hora_salida, hora_ingreso, observaciones, tipo_permiso) 
                VALUES (:identificador_solicitud, :nombre, :cedula, :email, :departamento, :fecha_solicitud, :fecha_permiso, :hora_salida, :hora_llegada, :observaciones, :tipo_permiso)";
        
        $stmt = $this->db->prepare($sql);
        
        // Enlace de parámetros
        $stmt->bindParam(':identificador_solicitud', $identificador);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':fecha_solicitud', $fecha_solicitud);
        $stmt->bindParam(':fecha_permiso', $fecha_permiso);
        $stmt->bindParam(':hora_salida', $hora_salida);
        $stmt->bindParam(':hora_llegada', $hora_llegada);
        $stmt->bindParam(':observaciones', $observaciones);
        $stmt->bindParam(':tipo_permiso', $tipo_permiso);

        // Ejecutar la consulta
        return $stmt->execute();
    }

    // Método para enviar un correo con la información de la solicitud
    public function enviarCorreo($nombre, $email_lider, $tipo_permiso) {
        $to = $email_lider; // Destinatario
        $subject = "Confirmación de Solicitud de Permiso";
        $message = "
        <html>
        <head>
        <title>Solicitud de Permiso</title>
        </head>
        <body>
        <h2>Hola, $nombre</h2>
        <p>Tu solicitud de permiso de tipo <strong>$tipo_permiso</strong> ha sido recibida correctamente.</p>
        <p>Recibirás una notificación sobre su estado pronto.</p>
        </body>
        </html>
        ";

        // Para enviar el correo en formato HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@tudominio.com" . "\r\n"; // Cambia a tu dominio

        // return mail($to, $subject, $message, $headers);
        return "alert($to, $subject, $message, $headers)";
    }

    public function solicitudes_realizadas($cedula){
        $sql = "SELECT * FROM solicitudes WHERE cedula = ?";
        $smtp = $this->db->prepare($sql);
        $smtp->execute([$cedula]);
        return $smtp->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lideres_correo($id_departamento) {
        if ($id_departamento) {
            $sql = "SELECT usuarios.correo, usuarios.nombres 
                    FROM usuarios 
                    INNER JOIN departamentos ON usuarios.id_usuario = departamentos.id_lider 
                    WHERE departamentos.id_departamento = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_departamento]);
            return $stmt->fetchColumn(); // Retorna un solo valor (correo del líder)
        }
        return null; // Retorna null si no hay departamento
    }

    public function lideres_proceso($id_departamento){
        if (isset($id_departamento)){
            $sql = "SELECT u.nombres, u.correo FROM usuarios u INNER JOIN departamentos d ON u.id_usuario = d.id_lider WHERE d.id_departamento = ?;";
            // SELECT usuarios.nombres,usuarios.correo  FROM usuarios INNER JOIN departamentos ON usuarios.id_usuario = departamentos.id_lider INNER JOIN usuarios AS usuarios2 ON usuarios2.id_departamento = departamentos.id_departamento WHERE usuarios2.id_usuario = ? 
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_departamento]);
            return $stmt->fetchColumn();
        }
    }


    public function registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario) {
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, correo, id_departamento, rol, contrasena, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario]);
    }

    public function historico() {
        $sql = "SELECT historial_solicitudes.* , departamentos.nombre_departamento FROM historial_solicitudes INNER JOIN departamentos ON departamentos.id_departamento = historial_solicitudes.id_departamento WHERE departamentos.id_departamento = historial_solicitudes.id_departamento";
        $stmt = $this->db->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados (si es necesario)
        return $resultados;
    }

    public function hora_ingreso() {
        $stmt = $this->db->prepare("SELECT id_solicitud, nombre, fecha_solicitud, hora_ingreso FROM solicitudes");

        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function edicionHora($hora,$id_solicitud) {
        // La consulta SQL para actualizar el estado de la solicitud
        $sql = "UPDATE solicitudes SET hora_ingreso = :hora WHERE id_solicitud = :id_solicitud";

        // Preparamos la consulta con la conexión de la base de datos
        $stmt = $this->db->prepare($sql);

        // Ejecutamos la consulta pasando los valores como un arreglo asociativo
        $stmt->execute([
            ':hora' => $hora,
            ':id_solicitud' => $id_solicitud
        ]);
    
        // Verificamos si la consulta afectó alguna fila
        if ($stmt->rowCount() > 0) {
            return true; // Si se actualizó al menos una fila
        } else {
            return false; // Si no se actualizó ninguna fila
        }
    }

}
?>    