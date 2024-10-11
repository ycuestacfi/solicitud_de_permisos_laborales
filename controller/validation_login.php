<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    
    $valid_mail = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $email = filter_var($valid_mail, FILTER_VALIDATE_EMAIL) ? $valid_mail : 0;

    echo " $valid_mail","<br>".$email;
    $password = $_POST["password"];




    $email_hashed = hash("sha512", $email);
    $password_hashed = hash("sha512", $password);
    
    $id_dep=1;
    
    $sql = "SELECT nombre , cedula , correo, id_departamento , rol FROM usuarios WHERE correo = ? AND contrasena = ? AND id_departamento = ?";
    $stmt = $conect_service->prepare($sql);
    
    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die("        Error en la preparación de la consulta: " . $conect_service->error);
        echo "<br> Formulario enviado correctamente";
    }

    // Vincular parámetros
    $stmt->bind_param("ssi", $email_hashed, $password_hashed, $id_dep);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    
    // Verificar si se encontró un usuario que coincida
    if ($result->num_rows > 0) {
        // asignacion de valores ala variable de session

        session_start(); // Esto inicia la variable de sesión
        
        // Obtener resultados por filas de la consulta
        $row = $result->fetch_assoc();
        
        // Asignar valores a la sesión
        $_SESSION['nombre'] = $row['nombre']; // Guarda el nombre
        $_SESSION['cedula'] = $row['cedula']; // Guarda la cédula
        $_SESSION['correo'] = $row['correo']; // Guarda el correo
        $_SESSION['id_departamento'] = $row['id_departamento']; // Guarda el ID del departamento
        $_SESSION['rol'] = $row['rol']; // Guarda el rol
    
        // Redirigir a la página de solicitudes
        if (isset($_SESSION['rol'])) {
            $rol = $_SESSION['rol']; // Obtiene el rol del usuario desde la sesión
        
            if ($rol === 'solicitante') {
                header("Location: /views/solicitud.php");
                exit();
            } elseif ($rol === 'líder aprobador') {
                header("Location: /views/solicitudes_lider.php");
                exit();
            } elseif ($rol === 'administrador') {
                header("Location: /views/administrador.php");
                exit();
            } else {
                // Si no coincide con ninguno de los roles esperados
                echo "<script>
            swal({
                title: 'Error',
                text: 'Rol no reconocido.',
                icon: 'error',
                button: 'Aceptar',
            }).then(function() {
            window.location.href = '/login.php'; 
        });
        </script>";
            }
        }
    } else {
        echo "<script>
        swal({
            title: 'Error',
            text: 'No se ha iniciado sesión.',
            icon: 'warning',
            button: 'Aceptar',
        }).then(function() {
            window.location.href = '/login.php'; 
        });
    </script>";
    }
        

    // Cerrar la consulta y la conexión
    $stmt->close();
    $conn->close();
}
?>