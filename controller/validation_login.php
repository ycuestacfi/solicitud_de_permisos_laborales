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
        session_start();
        $row = $result->fetch_assoc();
        
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['cedula'] = $row['cedula'];
        $_SESSION['correo'] = $row['correo'];
        $_SESSION['id_departamento'] = $row['id_departamento'];
        $_SESSION['rol'] = $row['rol'];
        
        $rol = $_SESSION['rol'];
        
        if ($rol === 'solicitante') {
            header("Location: /views/solicitud.php");
            exit();
        } elseif (strtolower($rol) === 'lider_aprobador') {
            header("Location: /index.php");
            exit();
        } elseif ($rol === 'administrador') {
            header("Location: /views/administrador.php");
            exit();
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
    $conect_service->close();
}
?>