<?php
require_once '../helpers/CookieHelper.php';
$correo_recordado = isset($_COOKIE['correo']) ? $_COOKIE['correo'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/app/assets/css/login.css">
    <link rel="stylesheet" href="/app/assets/css/global.css">
    <!-- Incluyendo SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <?php include_once '../controller/LoginController.php';?>
    
    
</head>
<body>
    <main>
        <p id="text_bienvenida">Bienvenidos</p>
        <section id="content_form-login">
            
            <article id="content_figure_login">
                <figure id="figure_login">
                    <img src="/app/assets/img/logoOficial.png" alt="Logo Centro De Formación Integral Providencia." id="img_login">
                </figure>
            </article>
            <h2 id="text_login">Inicia sesión</h2>
            <form id="form-login" method="POST">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $correo_recordado; ?>" tabindex="1" title="Ingrese su correo"><br><br>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required pattern=".{9,}[*.#]$" tabindex="2" title="La contraseña debe tener minimo 8 caracteres y terminar con * o # o .">
                <input type="checkbox" name="remember_me" id="remember_me" tabindex="3">
                <label for="remember_me">Recordarme</label>

                <button type="submit" tabindex="4">Iniciar sesión</button>
            </form>
        </section>
        
    </main>
    <script src="/app/assets/js/verificar_correo.js"></script>
    <!-- <script src="/assets/js/verificar_contra.js"></script> -->
</body>
</html>