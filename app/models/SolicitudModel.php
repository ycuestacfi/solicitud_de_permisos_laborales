<?php
require_once __DIR__ . '/../../conexion.php';
class solicitudModel {
    private $db;

    public function __construct()
    {
        $this->db = ConectService::conectar();
    }

    public function actualizarEstado($id_solicitud, $estado, $comentario){

        $sql = "UPDATE solicitudes SET estado = :estado, fecha_estado = NOW() , comentario = :comentario WHERE id_solicitud = :id_solicitud";

        // Asegúrate de que $id_solicitud es un valor entero
        $id_solicitud = (int) $id_solicitud;

        // Preparamos la consulta con la conexión de la base de datos
        $stmt = $this->db->prepare($sql);

        // Ejecutamos la consulta pasando los valores como un arreglo asociativo
        $stmt->execute([
            ':estado' => $estado,
            ':id_solicitud' => $id_solicitud,
            ':comentario' => $comentario
        ]);
        // Registrar el cambio en el historial
        // $this->registrarHistorico($id_solicitud, $estado, "1");
    
        return $stmt->rowCount();
    }
    
    public function solicitudesDeDepartamento($id_departamento){
        $sql = "SELECT * FROM solicitudes WHERE id_departamento = ? AND estado = 'pendiente' ORDER BY fecha_solicitud DESC;";
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
     public function registrarSolicitud($nombre, $email, $cedula, $departamento, $fecha_solicitud, $fecha_permiso, $hora_salida, $hora_llegada, $observaciones, $tipo_permiso, $motivo_del_desplazamiento, $departamento_de_desplazamiento, $municipio_del_desplazamiento, $lugar_desplazamiento, $medio_de_transporte, $placa_vehiculo, $url_evidencia) {
        // Consulta para insertar los datos en la tabla de solicitudes
        $identificador = $this -> generarIdentificador();

        if ($tipo_permiso !== "laboral") {
            $sql = "INSERT INTO solicitudes (identificador_solicitud, nombre, cedula, correo, id_departamento, fecha_solicitud, fecha_permiso, hora_salida, hora_ingreso, observaciones, tipo_permiso, evidencia) 
                    VALUES (:identificador_solicitud, :nombre, :cedula, :email, :departamento, :fecha_solicitud, :fecha_permiso, :hora_salida, :hora_llegada, :observaciones, :tipo_permiso, :evidencia)";
            
            $stmt = $this->db->prepare($sql);
            
            
            // Enlace de parámetros
            $stmt->bindParam(':identificador_solicitud', $identificador);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':fecha_solicitud', $fecha_solicitud);
            $stmt->bindParam(':fecha_permiso', $fecha_permiso);
            $stmt->bindParam(':hora_salida', $hora_salida);
            $stmt->bindParam(':hora_llegada', $hora_llegada);
            $stmt->bindParam(':observaciones', $observaciones);
            $stmt->bindParam(':tipo_permiso', $tipo_permiso);
            $stmt->bindParam(':evidencia', $url_evidencia);

            var_dump($url_evidencia);

            // Ejecutar la consulta
            return $stmt->execute();

        }else {
            $sql = "INSERT INTO solicitudes (identificador_solicitud, nombre, cedula, correo, id_departamento, fecha_solicitud, fecha_permiso, hora_salida, hora_ingreso, observaciones, tipo_permiso, evidencia, motivo_del_desplazamiento, departamento_del_desplazamiento, municipio_del_desplazamiento, lugar_del_desplazamiento, medio_de_transporte, placa_vehiculo) 
            VALUES (:identificador_solicitud, :nombre, :cedula, :email, :departamento, :fecha_solicitud, :fecha_permiso, :hora_salida, :hora_llegada, :observaciones, :tipo_permiso, :evidencia, :motivo_del_desplazamiento, :departamento_del_desplazamiento, :municipio_del_desplazamiento, :lugar_del_desplazamiento, :medio_de_transporte, :placa_vehiculo)";
        
            $stmt = $this->db->prepare($sql);
            
            // Enlace de parámetros
            $stmt->bindParam(':identificador_solicitud', $identificador);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':fecha_solicitud', $fecha_solicitud);
            $stmt->bindParam(':fecha_permiso', $fecha_permiso);
            $stmt->bindParam(':hora_salida', $hora_salida);
            $stmt->bindParam(':hora_llegada', $hora_llegada);
            $stmt->bindParam(':observaciones', $observaciones);
            $stmt->bindParam(':tipo_permiso', $tipo_permiso);
            $stmt->bindParam(':evidencia', $url_evidencia);
            $stmt->bindParam(':motivo_del_desplazamiento', $motivo_del_desplazamiento);
            $stmt->bindParam(':departamento_del_desplazamiento', $departamento_de_desplazamiento);
            $stmt->bindParam(':municipio_del_desplazamiento', $municipio_del_desplazamiento);
            $stmt->bindParam(':lugar_del_desplazamiento', $lugar_desplazamiento);
            $stmt->bindParam(':medio_de_transporte', $medio_de_transporte);
            $stmt->bindParam(':placa_vehiculo', $placa_vehiculo);

            // Ejecutar la consulta
            return $stmt->execute();
        }
    }

    public function solicitudes_realizadas($cedula){
        $sql = "SELECT * FROM solicitudes WHERE cedula = ? ORDER BY fecha_solicitud DESC;";
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
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function registrarUsuario($nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario) {
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombres, apellidos, cedula, correo, id_departamento, rol, contrasena, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nombres, $apellidos, $cedula, $correo, $departamento, $rol, $password, $usuario]);
    }

    public function historico($datos) {
        $sql = "UPDATE solicitudes SET estado_revision = :estado, fecha_estado_revision = NOW() WHERE id_solicitud = :id_solicitud;";

        $stmt = $this->db->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute([
            ':estado' => $datos['estado'],
            ':id_solicitud' => $datos['id_solicitud']
        ]);

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados (si es necesario)
        return $resultados;
    }

    public function ver_historico() {
        $sql = "SELECT s.*, d.nombre_departamento AS nombre_departamento FROM solicitudes s JOIN departamentos d ON s.id_departamento = d.id_departamento WHERE s.estado_revision = 'terminada' ORDER BY s.fecha_permiso DESC;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function solicitudesDeTerminadas() {
        $sql = "SELECT * FROM solicitudes WHERE estado = 'aprobada' AND estado_porteria = 'terminada' AND estado_revision = 'pendiente' ORDER BY fecha_permiso DESC;";
        $stmt = $this->db->prepare($sql);
        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados (si es necesario)
        return $resultados;
    }

    public function hora_ingreso() {
        $stmt = $this->db->prepare("SELECT id_solicitud, identificador_solicitud, nombre, fecha_permiso, hora_salida, hora_ingreso, tipo_permiso FROM solicitudes WHERE fecha_permiso BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND estado = 'aprobada' AND estado_porteria = 'pendiente' ORDER BY fecha_permiso ASC, hora_ingreso ASC;");

        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }

    public function edicionHora($hora,$id_solicitud) {
        // La consulta SQL para actualizar el estado de la solicitud
        $sql = "UPDATE solicitudes SET hora_ingreso = :hora, estado_porteria = 'terminada', fecha_estado_vigilancia = NOW() WHERE id_solicitud = :id_solicitud";

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

    public function infoLaboral($identificador){

        $sql = "SELECT s.*, d.nombre_departamento AS departamento FROM solicitudes s JOIN departamentos d ON s.id_departamento = d.id_departamento WHERE s.identificador_solicitud = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$identificador]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function subirEvidencia($evidenciaPath,$identificador) {
        // Consulta SQL para actualizar la ruta de la evidencia en la base de datos
        $sql = "UPDATE solicitudes SET evidencia = :rutaEvidencia WHERE identificador_solicitud = :idSolicitud";

        // Preparar la consulta
        $stmt = $this->db->prepare($sql);

        // Enlazar los parámetros
        $stmt->bindParam(':rutaEvidencia', $evidenciaPath);
        $stmt->bindParam(':idSolicitud', $identificador);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;  // Si la actualización fue exitosa
        } else {
            return false; // Si hubo un error
        }
    }

    // Método para enviar un correo con la información de la solicitud
    public function enviarCorreo($nombre, $cedula, $email, $fecha_de_solicitud, $tipo_permiso, $fecha_de_permiso, $hora_de_salida, $hora_de_llegada, $observaciones, $info_lider) {

        $to      = $info_lider['correo'];
        $subject = 'Solicitud empleado ' . $nombre;
        $mensaje = '
            <html>
            <head>
            </head>
                <body>
                <div style="max-width: 600px; margin: 20px auto; border: solid 1px #e9e9e9; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">
            
            <h2 style="color: #002A3F;">Estimado Jefe, '.$info_lider['nombres'].'</h2>
            
            <p style="font-size:17px; border-bottom: solid 1px #e9e9e9;
            text-align: center;">El empleado <strong style="color:#002A3F;">  '.$nombre.'</strong> ha solicitado un permiso.</p>
            
            <ul style="list-style-type: none; padding: 0;">
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Numero De Documento:</strong></td>
                        <td style="text-align: right;">'.$cedula.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Correo Del Empleado:</strong></td>
                        <td style="text-align: right;">'.$email.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Fecha De la Solicitud:</strong></td>
                        <td style="text-align: right;">'.$fecha_de_solicitud.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Tipo De Permiso:</strong></td>
                        <td style="text-align: right;">'.$tipo_permiso.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Fecha Del Permiso:</strong></td>
                        <td style="text-align: right;">'.$fecha_de_permiso.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Hora De Salida:</strong></td>
                        <td style="text-align: right;">'.$hora_de_salida.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Hora De llegada:</strong></td>
                        <td style="text-align: right;">'.$hora_de_llegada.'</td>
                    </tr>
                </table>
            </li>
            <li style="font-size: 20px; border-bottom: solid 1px #e9e9e9;">
                <table style="width: 100%; border-spacing: 0;">
                    <tr>
                        <td style="text-align: left;"><strong>Observaciones:</strong></td>
                        <td style="text-align: right;">'.$observaciones.'</td>
                    </tr>
                </table>
            </li>
        </ul>

        
            <p><strong style="color:#002A3F;">¡Hola! Para gestionar esta solicitud, haz clic en el botón de abajo. Serás redirigido automáticamente para completar la acción.</strong></p>
        
            
            <a href="http://localhost/solicitud_de_permisos_laborales/app/views/dashboard.php" style="display: block; width: 200px; margin: 20px auto; padding: 10px; background-color: #002A3F; color: #FFFFFF; text-align: center; text-decoration: none; border-radius: 8px;">Responder Solicitud</a>
        
            
        
            </div>
            </body>
            <html>
            
            Gracias.
            ';
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: jhoyos@providenciacfi.com \r\n";
            // $headers .= "CC: ycuesta@providenciacfi.com \r\n";
            
        mail($to, $subject, $mensaje, $headers);

    }

    public function enviarCorreoEstado($datos) {
        $to      = $datos['email']; // Correo del usuario
        $subject = 'Estado de tu solicitud de solicitud de permiso';

        $mensaje = '
            <html>
            <head>
            </head>
                <body>
                <div style="max-width: 600px; margin: 20px auto; border: solid 1px #e9e9e9; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">

            <h2 style="color: #002A3F;">Hola, '.$datos['nombre'].'</h2>

            <p style="font-size:17px; border-bottom: solid 1px #e9e9e9; text-align: center;">
                Tu solicitud de permiso ha sido <strong style="color:#002A3F;">'.$datos['nuevoEstado'].'</strong>.
            </p>

            <ul style="list-style-type: none; padding: 0;">
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Codigo de solicitud:</strong></td>
                            <td style="text-align: right;">'.$datos['identificador'].'</td>
                        </tr>
                    </table>
                </li>

                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Tipo de Permiso:</strong></td>
                            <td style="text-align: right;">'.$datos['tipo_permiso'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Fecha del Permiso:</strong></td>
                            <td style="text-align: right;">'.$datos['fecha_permiso'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Hora de Salida:</strong></td>
                            <td style="text-align: right;">'.$datos['hora_salida'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Hora de Ingreso:</strong></td>
                            <td style="text-align: right;">'.$datos['hora_llegada'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Observaciones:</strong></td>
                            <td style="text-align: right;">'.$datos['observaciones'].'</td>
                        </tr>
                    </table>
                </li>
            </ul>

            <p style="font-size:16px; color:#333;">
                Para más detalles sobre tu solicitud, puedes ingresar al sistema utilizando el siguiente botón:
            </p>

            <a href="http://localhost/solicitud_de_permisos_laborales/app/views/solicitudes.php" 
            style="display: block; width: 200px; margin: 20px auto; padding: 10px; background-color: #002A3F; color: #FFFFFF; text-align: center; text-decoration: none; border-radius: 8px;">
            Ver mi solicitud
            </a>

            <p style="text-align: center; font-size: 14px; color: #666;">
                Si tienes alguna duda, por favor contacta con el área de Talento Humano.
            </p>

            </div>
            </body>
            </html>
        ';

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: jhoyos@providenciacfi.com \r\n";

        mail($to, $subject, $mensaje, $headers);
    }

    public function enviarCorreoLaboral($datos, $info) {
        $to      = $datos['email']; // Correo del usuario
        $subject = 'Estado de tu solicitud de permiso laboral - Seguridad y Salud en el Trabajo';

        $mensaje = '
            <html>
            <head>
            </head>
                <body>
                <div style="max-width: 600px; margin: 20px auto; border: solid 1px #e9e9e9; background-color: #FFFFFF; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); padding: 20px;">

            <h2 style="color: #002A3F;">Hola, '.$datos['nombre'].'</h2>

            <p style="font-size:17px; border-bottom: solid 1px #e9e9e9; text-align: center;">
                    La solicitud de permiso laboral con codigo <strong style="color:#002A3F;">'.$datos['identificador'].'</strong> fue  <strong style="color:#002A3F;">'.$datos['nuevoEstado'].'</strong>.
            </p>

            <ul style="list-style-type: none; padding: 0;">
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Código de solicitud:</strong></td>
                            <td style="text-align: right;">'.$datos['identificador'].'</td>
                        </tr>
                    </table>
                </li>

                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Cedula:</strong></td>
                            <td style="text-align: right;">'.$datos['cedula'].'</td>
                        </tr>
                    </table>
                </li>

                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Correo:</strong></td>
                            <td style="text-align: right;">'.$datos['email'].'</td>
                        </tr>
                    </table>
                </li>
                
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Departamento de trabajo:</strong></td>
                            <td style="text-align: right;">'.$info['departamento'].'</td>
                        </tr>
                    </table>
                </li>

                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Tipo de Permiso:</strong></td>
                            <td style="text-align: right;">'.$datos['tipo_permiso'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Fecha del Permiso:</strong></td>
                            <td style="text-align: right;">'.$datos['fecha_permiso'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Hora de Salida:</strong></td>
                            <td style="text-align: right;">'.$datos['hora_salida'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Hora de Ingreso:</strong></td>
                            <td style="text-align: right;">'.$datos['hora_llegada'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Observaciones:</strong></td>
                            <td style="text-align: right;">'.$datos['observaciones'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Motivo:</strong></td>
                            <td style="text-align: right;">'.$info['motivo_del_desplazamiento'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Departamento de destino:</strong></td>
                            <td style="text-align: right;">'.$info['departamento_del_desplazamiento'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Municipio de destino:</strong></td>
                            <td style="text-align: right;">'.$info['municipio_del_desplazamiento'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Lugar de destino:</strong></td>
                            <td style="text-align: right;">'.$info['lugar_del_desplazamiento'].'</td>
                        </tr>
                    </table>
                </li>
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Medio de transporte:</strong></td>
                            <td style="text-align: right;">'.$info['medio_de_transporte'].'</td>
                        </tr>
                    </table>
                </li>';

        // Agregar placa de vehículo si no es null
        if ($info['placa_vehiculo'] != null) {
            $mensaje .= '
                <li style="font-size: 18px; border-bottom: solid 1px #e9e9e9;">
                    <table style="width: 100%; border-spacing: 0;">
                        <tr>
                            <td style="text-align: left;"><strong>Placa de vehículo:</strong></td>
                            <td style="text-align: right;">'.$info['placa_vehiculo'].'</td>
                        </tr>
                    </table>
                </li>';
        }

        $mensaje .= '
            </ul>

            </div>
            </body>
            </html>
        ';

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: jhoyos@providenciacfi.com \r\n";

        mail($to, $subject, $mensaje, $headers);
    }

}
?>    