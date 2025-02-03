<?php
// encabezado
header("ACCESS-CONTROL-ALLOW-ORIGIN: *");
class ConectService {

    static public function conectar()
    {
     
        //local
             $rutaServidor = "localhost";
             $puerto = "3306";
             $usuario = "providencia_solicitud_de_permisos_laborales";
             $contrasena = "Pr0v1d3nc14$#2025*";
             $BD = "providencia_solicitud_de_permisos";

        // real
            // $contrasena = "Pr0v1d3nc14$#cfip2025*";
            // $usuario = "junior47895_solicitud_permisos_desarrolladores";
            // $BD = "junior47895_solicitud_permisos_laborales";
            // $rutaServidor = "167.114.11.220";
            // $puerto = "2083";

        $base_de_datos = null;

        try {
            $base_de_datos = new PDO("mysql:host=$rutaServidor;port=$puerto;dbname=$BD", $usuario, $contrasena);
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Conecto con la base de datos ";
        } catch (PDOException $e) {
            throw new Exception("Error al conectar a la base de datos: " . $e->getMessage());
        }
        return  $base_de_datos;
    }

}
?>
