<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /app/views/login.php ");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Estructura HTML5</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* Estilos generales */
        * {
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
            font-size: 17px;
            font-family: "Inter";
            }
        :root {
            --verde-corporativo: #72BE44;
        --verde-claro: #B7C19D;
        --azul-verde: #567572;
        --blanco: #F9F9F9;
        --verde-opaco: #2F4C3F;
        --veich:#E8D9cE;
        --gris-fondo: #ACB0AE;
        }
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background: url(/solicitud_de_permisos_laborales/app/assets/img/loginBackground.jpg)center center /cover no-repeat ;
        }
        
        header {
            background: var(--verde-claro);
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        #navigation{
            position: relative;
            display: flex;
            justify-content: space-around;
            width: 100%;
            background-color:var(--azul-verde);
            border-radius: 25px 25px 0 0;
        }
        nav{
            position: relative;
            padding: 8px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        nav ul li a {
            display: inline-flex;
            text-decoration: none;
            list-style-type: none;
            padding: 0;
            color: var(--verde-claro);
            
        }
        nav ul li a:hover{
            scale: 1.2;
            color: var(--blanco);
            text-shadow: 2px 2px 5px var(--blanco);
            
        }

        nav ul li {
            display: inline;
            margin-right: 15px;
        }

        main {
          position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50% , -50%);
            margin: auto;
             background-color:  rgba(255, 255, 255, 0.6);
            border-radius: 25px;
            border: solid 2px  var(--verde-opaco);
            width: 85%;
            height: 80vh;
            padding: 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* CSS para gestion de solicitudes */
        #tabla_registros{
             border: solid 2px var(--blanco);
             width: 75%; 
             max-height: 60%;
             padding: 10px;
             position: absolute; 
             left: 50%; 
             top: 50%;
             transform:  translateX(-50%) translatey(-50%); 
             background-color: var(--azul-verde); 
            
        }
        .td_solicitud{
            border:solid 1px var(--blanco);
             
             text-align:center;
        }
        .btn_accion_solicitud{
            height: 40px;
            background:none;  
            border:none; 
            width:40px;
        }
        #observaciones{
    height: 80px;
}
textarea::placeholder {
    color: var(--blanco); /* Cambia a tu color preferido */
    opacity: 1; /* Asegura que el color sea visible */
}
        /* #tipo-permiso{
    -webkit-appearance: none; /* Eliminar estilo nativo en Safari/Chrome *
    -moz-appearance: none; /* Eliminar estilo nativo en Firefox 
    appearance: none; /* General 
    background-image: url("data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23FFFFFF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' width='24' height='24'><polyline points='6 9 12 15 18 9'></polyline></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px 16px;
} */
#formulario-solicitud {
    height: 75%;
    width: 35%;
    margin: 0;
    padding: 12px 20px;
    flex-direction: column;
    align-items: center;
    display: flex;
    top: 55%;
    position: absolute;
    left: 50%;
    background-color: var(--azul-verde);
    z-index: 3;
    border-radius: 25px;
    transform: translateY(-50%) translateX(-50%);
}
.input_solicitud {
    width: 90%;
    background-color: var(--azul-oscuro-contraste);
    color: var(--blanco)!important;
    height: 30px;
    padding-left: 8px;
    margin: 0;
    position: relative;
    border: none;
    border-bottom: solid 1px var(--blanco);
    outline: none;
}
.contenedor-permiso {
    position: relative;
    width: 90%;
    cursor: pointer;
}

.selected-option {
    padding: 10px;
    background-color: transparent;
    border-bottom: 1px solid var(--blanco);
    color: var(--blanco);
}

.select-options {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: var(--blanco);
    border: 1px solid var(--verde-claro);
    border-radius: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
    z-index: 10;
}

.select-options li {
    height: 25px;
    border-bottom: 1px solid;
    display: flex;
    align-items: center;
    padding: 10px;
    color: var(--azul-verde);
    background-color: var(--blanco);
}

.select-options li:hover {
    background-color: var(--verde-claro);
    color: var(--blanco);
}
#permiso-laboral{
    display: none;
    left: 400px;
    height: 100%;
    width: 100%;
    position: absolute;
    border: 1px solid var(--blanco);
    border-radius: 25px;
    top: 0;
    padding: 10px 20px;
    backdrop-filter: blur(10px); /* Aplica el desenfoque */
    -webkit-backdrop-filter: blur(10px); /* Para compatibilidad con Safari */
}
input[type="file"]{
    display: none;
}
#label_file{
    height: 35px;
    width: 90%;
    margin-top: 8px;
    border-radius: 6px;
    border: 2px dashed var(--blanco);
    align-items: center;
    display: flex;
    justify-content: center;
    color: var(--blanco);
}
#label_file:hover{
    color: var(--blanco);
    border: 3px dashed var(--verde-claro);
    scale: 1.1;
    cursor: pointer;

}
        /* termina el css de gestion de solicitudes */
        

        footer {
            background-color: var(--verde-claro);
            text-align: center;
            padding: 10px 0;
            color: white;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php
    $prueba1 = [
        ['nombre' => 'Juan Pérez', 'departamento' => 'Ventas', 'lider_aprobador' => 'Carlos Torralba', 'fecha_solicitud' => '2024-10-15', 'estado' => 'Aprobado'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        ['nombre' => 'Ana García', 'departamento' => 'Contabilidad', 'lider_aprobador' => 'John Medina', 'fecha_solicitud' => '2024-10-14', 'estado' => 'Pendiente'],
        
    ]; ?>
<!-- <header>
        <h1>Título de la Página</h1>
        <nav>
            <ul>
                <li><a href="#home" style="color: white;">Inicio</a></li>
                <li><a href="#about" style="color: white;">Acerca de</a></li>
                <li><a href="#services" style="color: white;">Servicios</a></li>
                <li><a href="#contact" style="color: white;">Contacto</a></li>
            </ul>
        </nav>
    </header> -->
    
    <main>
        <section id="navigation">
            <!-- <nav>
                <figure style="margin:0; padding:0; width:150px;">
                    <a href="dashboard.php" ><img src="/solicitud_de_permisos_laborales/app/assets/img/logocfipblanco.png" style=" width: 100%; " alt=""></a>
            
                </figure>
                <ul>
                <li><a href="dashboard.php">inicio</a></li>
                <li><a href="solicitudes.php">Mis solicitudes</a></li>
                
                <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
                
                <li><a href="rechazadas.php">Rechazadas</a></li>
                
                </ul>
                <ul>
                    <li><a   href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión </a></li>
                </ul>
            </nav> -->
            <nav>
                <figure style="margin:0; padding:0; width:150px;">
                    <a href="dashboard.php"><img src="/solicitud_de_permisos_laborales/app/assets/img/logocfipblanco.png" style="width: 100%;" alt=""></a>
                </figure>
                <div id="btn_menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                
                <ul id="menu">
                    <li><a href="dashboard.php">Inicio</a></li>
                    <li><a href="solicitudes.php">Mis solicitudes</a></li>
                    <li><a href="departamentos.php">Departamentos</a></li>
                    <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
                    <li><a href="rechazadas.php">Rechazadas</a></li>
                    <?php if ($_SESSION['rol'] == 'administrador'){
                            echo '<li><a href="register.php"> Registrar Usuarios</a></li>';
                        } ?>
                    <li><a href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
                </ul>
                
            </nav>
        </section>
        <section id="fondo-form" >
            <a style="left: 50%; transform: translateX(-50%); position: absolute; top: 10%px; color: var(--azul-contraste); font-size: 30px; font-weight: 600;">
                <?php echo 'Bienvenido '. $_SESSION['nombres']  ." ". $_SESSION['apellidos'] ; ?>
            </a> 
            <form action="" method="POST"  id="formulario-solicitud" style="display: flex; flex-direction:column; gap:15px;">     
                <!-- <form action="" method="POST"  id="formulario-solicitud">
                   -->
                    <h1>Formulario De Solicitud</h1>

                    <input   placeholder="Nombre y Apellido" type="text" name="nombre" id="nombre" title="rellene el campo con su Nombre y Apellido"  pattern="[A-Za-z\s]{2,}"  minlength="2" required>

                    <input   placeholder="Correo" type="email" id="correo" name="email" required>
                    
                    
                    <input type="text" name="departamento" id="departamento" value="<?php echo $_SESSION['id_departamento']; ?>" required readonly hidden />
                    <!-- <label for="tipo-permiso" class="input-d">Seleccione el departamento al que pertenece</label>
                    <select class="input_solicitud" name="departamento" id="departamento" required>
                        <option class="optiones" value="Talento Humano">Talento Humano</option>
                        <option class="optiones" value="Contabilidad">Contabilidad</option>
                        <option class="optiones" value="Tecnologia Informatica">Tecnologia Informatica</option>
                        <option class="optiones" value="Comercial">Comercial</option>
                        <option class="optiones" value="Producción">Producción</option>
                        <option class="optiones" value="Almacen y logistica">Almacen y Logistica</option>
                        <option class="optiones" value="Big bag">Big Bag</option>
                        <option class="optiones" value="Academicas">Academicas</option>
                    </select> -->
    
                    <input class="input_solicitud" placeholder="Fecha de Solicitud" type="date" id="fecha-de-solicitud" name="fecha-de-solicitud" required >
                        
                    <input class="input_solicitud" placeholder="Fecha del permiso" type="date" id="fecha-de-permiso" name="fecha-de-permiso" required>

                    <!-- <select class="input-d input_solicitud" name="tipo-permiso" id="tipo-permiso" required>
                        <option class="optiones" value="personal">Personal</option>
                        <option class="optiones" value="cita-medica">Cita Medica</option>
                        <option class="optiones" value="calamidad-domestica">Calamidad Domestica</option>
                        <option class="optiones" value="estudio">Estudio</option>
                        <option class="optiones" value="laboral">Laboral</option>
                    </select> -->
                    
    
                    
                    <input class="input-d input_solicitud" placeholder="Hora de salida" type="time" id="hora-de-salida" name="hora-de-salida" required>

                    <input class="input-d input_solicitud" placeholder="Hora de llegada" type="time" id="hora-de-llegada" name="hora-de-llegada" required>

                    <textarea  class="input-d input_solicitud" placeholder="Observaciones" name="observaciones" id="observaciones" required></textarea>
                    
                    <label for="evidencias" id="label_file"> 
                    <i class="lni lni-file-plus-circle"></i>
                    Deseas cargar una evidencia? </label>
                    <input type="file" hidden name="evidencias" class="input-d input_solicitud" id="evidencias" title="Solo se permiten archivos PDF o imágenes (JPEG, PNG, GIF).">

                    <div id="contenedor-permiso" class="contenedor-permiso">
                        <div id="selected-option" class="selected-option">Seleccione un tipo de permiso</div>
                        <ul id="select-options" class="select-options">
                            <li data-value="personal">Personal</li>
                            <li data-value="cita-medica">Cita Médica</li>
                            <li data-value="calamidad-domestica">Calamidad Doméstica</li>
                            <li data-value="estudio">Estudio</li>
                            <li data-value="laboral">Laboral</li>
                        </ul>
                        <input type="hidden" name="tipo-permiso" id="tipo-permiso" />
                    </div>
                    <button type="submit" id="btn-enviar-permiso">Enviar solicitud</button>

                    <div id="permiso-laboral" class="permiso-laboral" >
                        <input class="input_laboral" class="preguntas_laboral" type="text" name="nombre-proyecto" required id="nombre-proyecto" placeholder="Nombre del Proyecto">
                        <input class="input_laboral" class="preguntas_laboral" type="text" name="cliente" required id="cliente" placeholder="Cliente Asociado">
                        <input type="text" class="input_laboral preguntas_laboral" placeholder="inpu1">
                        <input type="text" class="input_laboral preguntas_laboral" placeholder="inpu1">
                        <input type="text" class="input_laboral preguntas_laboral" placeholder="inpu1">
                        <input type="text" class="input_laboral preguntas_laboral" placeholder="inpu1">
                        <button type="submit" id="btn-enviar-permiso-laboral">Enviar solicitud</button>
                    </div>
                </form>
            <div id="fondo-formulario">
            
            </div>
            <!-- <figure id="contenedor-logo">
                <img src="/app/assets/img/logoOficial.png" alt="">
            </figure> -->
        </section>
    </main>

    <footer >
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('contenedor-permiso');
        const selectedOption = document.getElementById('selected-option');
        const dropdownOptions = document.getElementById('select-options');
        const hiddenInput = document.getElementById('tipo-permiso');
        const envio_solicitud = document.getElementById('btn-enviar-permiso');
        const permiso_laboral = document.getElementById('permiso-laboral');
        
        // Toggle dropdown visibility
        selectedOption.addEventListener('click', () => {
            dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
        });

        // Handle option selection
        dropdownOptions.addEventListener('click', (event) => {
            if (event.target.tagName === 'LI') {
                const value = event.target.dataset.value;
                const text = event.target.textContent;

                // Set the selected value
                selectedOption.textContent = text;
                hiddenInput.value = value;

                // Hide the dropdown
                dropdownOptions.style.display = 'none';
                if (hiddenInput.value ==="laboral"){
                    envio_solicitud.style.display="none";
                    permiso_laboral.style.display="block";
                    
                }else{
                    envio_solicitud.style.display="block";
                    permiso_laboral.style.display="none"
                }
            }
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdownOptions.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
