<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
if ($_SESSION['rol'] != 'administrador') {
    // Si no es administrador, redirigir al dashboard
    header("Location: /solicitud_de_permisos_laborales/app/views/dashboard.php ");
    exit();
}

include_once '../controller/departamentoController.php';
include_once '../controller/UserController.php';

$rol = $_SESSION['rol'];
$departamentocontroler = new departamentoControler();
$usercontroler = new UserController();
$departamentos = $departamentocontroler->listarDepartamentos();
if ($rol === "administrador"){
    $usuarios_selecion_lider = $usercontroler->selecion_de_lider($rol);
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <section id="navigation">
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
                    <?php if ($_SESSION['rol'] == 'administrador'){ echo '<li><a href="register.php"> Registrar Usuarios</a></li>'; } ?>
                    <li><a href="/cierre_de_sesion.php" id="btn_salir">Cerrar sesión</a></li>
                </ul>
            </nav>
        </section>

        <h1>Gestión de Departamentos</h1>

        <!-- Formulario para crear o editar departamento -->
        
    <section id="crear_departamento">
        <form action="" method="POST">
            <input type="hidden" name="id_departamento" value="<?php echo isset($departamento) ? $departamento['id_departamento'] : ''; ?>">

            <label for="nombre_departamento">Nombre del Departamento</label>
            <input type="text" id="nombre_departamento" name="nombre_departamento" required>

            <label for="id_lider">Líder</label>
            <select id="id_lider" name="id_lider">
                <option value="">Seleccione un líder</option>
                <option value=""></option>
            </select>

            <button type="submit"></button>
        </form>
    </section>


    <section id="actualizar_departamento">
        <?php if (!empty($usuarios_selecion_lider));?>
        <form action="" method="POST">
                <input type="hidden" name="id_departamento" value="<?php echo isset($departamento) ? $departamento['id_departamento'] : ''; ?>">

                <label for="nombre_departamento">Nombre del Departamento</label>
                <input type="text" id="nombre_departamento" name="nombre_departamento" required>

                <label for="id_lider">Líder</label>
                <select id="id_lider" name="id_lider">
                    <option value="">Seleccione un líder</option>
                    <?php foreach ($usuarios_selecion_lider as $usuario): ?>
                        <option value="<?php echo $usuario['nombres']; ?>" >
                            <?php echo htmlspecialchars($usuario['nombres']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <button type="submit"> actualizar departamento</button>
        </form>
    </section>


        

        <!-- Tabla de Departamentos -->
         <section>
         <h2>Departamentos Existentes</h2>
        <table style="border: solid 1px var(--blanco);" class="tabla-departamentos">
            <thead>
                <tr>
                    <th>ID Departamento</th>
                    <th>Nombre del Departamento</th>
                    <th>Nombre del Líder</th>
                </tr>
            </thead>
            <tbody style="background-color: var(--blanco);">
                <?php if (!empty($departamentos)): ?>
                    <?php foreach ($departamentos as $departamento): ?>
                        <tr >
                            <td style="border:solid 1px var(--blanco); text-align: center;"><?php echo htmlspecialchars($departamento['id_departamento']); ?></td>
                            <td style="border:solid 1px var(--blanco); "><?php echo htmlspecialchars($departamento['nombre_departamento']); ?></td>
                            <td style="border:solid 1px var(--blanco); ">
                                <?php 
                                // Si no hay líder asignado, mostrar un mensaje
                                echo htmlspecialchars(!empty($departamento['lider_nombre'] . $departamento['lider_apellido']) ? $departamento['lider_nombre'] .' '. $departamento['lider_apellido'] : 'Sin líder asignado'); 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No hay departamentos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
         </section>
        
    </main>
</body>
</html>
