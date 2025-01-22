<?php 
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}

include_once '../controller/departamentoController.php';

$departamentocontroler = new departamentoControler();
$departamentos = $departamentocontroler->listarDepartamentos()
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
        <?php if (isset($departamento)): ?>
            <h2>Editar Departamento</h2>
        <?php else: ?>
            <h2>Crear Nuevo Departamento</h2>
        <?php endif; ?>

        <form action="departamentos/<?php echo isset($departamento) ? 'actualizar/' . $departamento['id_departamento'] : 'guardar'; ?>" method="POST">
            <input type="hidden" name="id_departamento" value="<?php echo isset($departamento) ? $departamento['id_departamento'] : ''; ?>">

            <label for="nombre_departamento">Nombre del Departamento</label>
            <input type="text" id="nombre_departamento" name="nombre_departamento" value="<?php echo isset($departamento) ? htmlspecialchars($departamento['nombre_departamento']) : ''; ?>" required>

            <label for="id_lider">Líder</label>
            <select id="id_lider" name="id_lider">
                <option value="">Seleccione un líder</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo (isset($departamento) && $departamento['id_lider'] == $usuario['id_usuario']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($usuario['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"><?php echo isset($departamento) ? 'Actualizar Departamento' : 'Crear Departamento'; ?></button>
        </form>

        <!-- Tabla de Departamentos -->
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
    </main>
</body>
</html>
