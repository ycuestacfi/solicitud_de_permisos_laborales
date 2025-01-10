<?php
    /* versión 4.7 */

    if ($_SERVER['REQUEST_METHOD'] != 'POST') { // Validación de petición

        header("Location: http://arcano.digital/hermex", TRUE, 301);
        exit;

    } else {

        if ($_POST['OPERACION'] == "" || !isset($_POST['OPERACION'])) { // Validación del campo OPERACION

            $titulo = "ERROR";
            $aviso = "Ha ocurrido un error en la operación con el servidor de ARCANO.";

            $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

            include 'mensaje.php';

            exit;

        } else {

            // CUSTODIO
            if (strlen($_POST['runner']) >= 6 && strlen($_POST['runner']) <= 15) {

                $runner = $_POST['runner'];
                $distancia = strlen($_POST['runner_distancia']) > 0 && strlen($_POST['runner_distancia']) <= 2 ? $_POST['runner_distancia'] : 0;
                $precio = $_POST['runner_precio_distancia'];
                $talla = strlen($_POST['runner_talla']) > 0 && strlen($_POST['runner_talla']) <= 2 ? $_POST['runner_talla'] : 0;
                $grupo = filter_input(INPUT_POST, "runner_grupo", FILTER_SANITIZE_SPECIAL_CHARS);
                $forma_pago = $_POST['runner_forma_pago'];

                unset($_POST['runner'],$_POST['runner_distancia'],$_POST['runner_precio_distancia'],$_POST['runner_talla'],$_POST['runner_grupo'],$_POST['runner_forma_pago']);

                /* `id_num`= $runner, `grupo`, `distancia`= $distancia, `precio_distancia`= $precio, `talla`= $talla, `estado`, `forma_pago`= $forma_pago */

                switch ($_POST['OPERACION']) { // Operaciones validas

                    case 'INSCRIPCION':

                        $runner_movil_hist = strlen($_POST['runner_movil_hist']) == 10 ? $_POST['runner_movil_hist'] : 0;
                        $runner_movil = strlen($_POST['runner_movil']) == 10 ? $_POST['runner_movil'] : 0;

                        $runner_movemer_hist = strlen($_POST['runner_movemer_hist']) == 10 ? $_POST['runner_movemer_hist'] : 0;
                        $runner_movil_emergencia = strlen($_POST['runner_movil_emergencia']) == 10 ? $_POST['runner_movil_emergencia'] : 0;

                        $pre_correo_hist = filter_input(INPUT_POST, "runner_correo_hist", FILTER_SANITIZE_EMAIL);
                        $runner_correo_hist = filter_var($pre_correo_hist, FILTER_VALIDATE_EMAIL) ? $pre_correo_hist : 0;

                        $pre_correo = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                        $runner_correo = filter_var($pre_correo, FILTER_VALIDATE_EMAIL) ? $pre_correo : 0;

                        $runner_grupo_hist = $_POST['runner_grupo_hist'];

                        unset($_POST['runner_movil_hist'], $_POST['runner_movil'], $_POST['runner_correo_hist'], $_POST['runner_correo'], $_POST['runner_grupo_hist'], $_POST['runner'], $_POST['runner_distancia'], $_POST['runner_precio_distancia'], $_POST['runner_talla'], $_POST['OPERACION'], $_POST['runner_grupo'], $_POST['runner_forma_pago']);

                        if ($runner_movil_hist != $runner_movil || $runner_correo_hist != $runner_correo || $runner_grupo_hist != $grupo || $runner_movemer_hist != $runner_movil_emergencia) { // Incio de actualización de datos del runner

                            $conexion_arcano = require '../hmx_codigos/conexion_hmx.php';

                            if (!$conexion_arcano) { // Conexión Personas

                                $titulo = "ERROR";
                                $aviso = "Ha ocurrido un error en la conexión con el servidor de ARCANO para actualizar runner.";

                                $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                include 'mensaje.php';

                                exit;

                            } else { // Actualización datos runner

                                $nom_evento = nom_evento;

                                $sentencias = require 'sentencias_hmx.php';

                                if (!$sentencias) { // Carga de sentencias preparadas

                                    $titulo = "ERROR";
                                    $aviso = "Ha ocurrido un error en la conexión con el servidor de ARCANO para actualizar runner.";

                                    $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                    include 'mensaje.php';

                                    exit;

                                } else { // Actualización de datos

                                    // Busqueda del grupo en la base de datos
                                    $buscar_grupo->bind_param("s",$grupo);
                                    if ($buscar_grupo) {
                                        $buscar_grupo->execute();
                                        if($buscar_grupo) {
                                            $resultado = $buscar_grupo->get_result();
                                            $buscar_grupo->close();
                                        }
                                    }

                                    if ($runner_grupo_hist != $grupo && $resultado->num_rows < 1) { // Adición del grupo a la tabla de grupos
                                        $grupo_nuevo->bind_param("s",$grupo);
                                        if ($grupo_nuevo) {
                                            $grupo_nuevo->execute();
                                            if ($grupo_nuevo) {
                                                $grupo_nuevo->close();
                                            }
                                        }
                                    }

                                    $runner_actualizar->bind_param("sssss",$runner_movil,$runner_correo,$runner_movil_emergencia,$grupo,$runner);

                                    if (!$runner_actualizar) { // Validación del bind_param

                                        $arcano_link->close();

                                        unset($runner_movil_hist,$runner_movil,$runner_correo_hist,$runner_correo,$runner_grupo_hist,$runner_movemer_hist,$runner_movil_emergencia,$pre_correo_hist,$pre_correo);

                                        $titulo = "ERROR";
                                        $aviso = "Ha ocurrido un error en la preparación de datos con el servidor de ARCANO para actualizar los datos del runner.";

                                        $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                        include 'mensaje.php';

                                        exit;

                                    } else { // Ejecución de update

                                        $runner_actualizar->execute();

                                        if (!$runner_actualizar) { // Validadación de update

                                            $titulo = "OUH";
                                            $aviso = "Ha ocurrido un error en la ejecución de datos con el servidor de ARCANO para actualizar runner.";

                                            $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                            include 'mensaje.php';

                                            exit;
                                        } // Fin execute de actualizar datos

                                        unset($runner_movil_hist,$runner_movil,$runner_correo_hist,$runner_correo,$runner_grupo_hist,$runner_movemer_hist,$runner_movil_emergencia,$pre_correo_hist,$pre_correo);

                                        $arcano_link->close();

                                    } // Fin validación del bind_param

                                } // Fin sentencias preparadas y update de datos runner

                            } // Fin conexión personas

                        } // Fin actualización runner

                        /*  */

                        $evento = require '../hmx_codigos/conexion_evento.php';

                        if (!$evento) { // Fallo conexión Evento

                            $titulo = "ERROR";
                            $aviso = "Ha ocurrido un error en la conexión con el servidor de ARCANO para el evento.";

                            $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                            include 'mensaje.php';

                            exit;

                        } else { // Inscripción al evento

                            $sentencias = require 'sentencias_evento.php';

                            $runner_buscar->bind_param("s",$runner);

                            if (!$runner_buscar) {

                                $evento_link->close();

                                $titulo = "ERROR";
                                $aviso = "Ha ocurrido un error preparando tus datos en el evento.";

                                $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                include 'mensaje.php';

                            } else {

                                $runner_buscar->execute();

                                if (!$runner_buscar) {

                                    $evento_link->close();

                                    $titulo = "ERROR";
                                    $aviso = "Ha ocurrido un error ejecutando tus datos en el evento.";

                                    $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                    include 'mensaje.php';

                                } else {

                                    $inscrito = $runner_buscar->get_result();
                                    $runner_buscar->close();

                                    $encontrado = $inscrito->fetch_assoc();

                                    //var_dump($encontrado);

                                    if (!is_null($encontrado)) {

                                        $evento_link->close();

                                        $titulo = "ERROR";
                                        $aviso = "Según nuestro sistema ya estás inscrito desde el " . $encontrado['fecha_registro'] . ".";

                                        $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                        include 'mensaje.php';

                                    } else { /* RUTINA PARA INSCRIBIR AL CORREDOR CONOCIDO */

                                        $runner_inscribir->bind_param("sssiss",$runner,$grupo,$distancia,$precio,$talla,$forma_pago);

                                        $runner_inscribir->execute();

                                        if (!$runner_inscribir) {

                                            $evento_link->close();

                                            unset($runner,$grupo,$distancia,$precio,$talla,$forma_pago);

                                            $titulo = "ERROR";
                                            $aviso = "No se ha podido procesar tu inscripción en $nom_evento; intentalo de nuevo más tarde por favor. $runner_inscribir->errorInfo().";

                                            $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                            include 'mensaje.php';

                                        } else {

                                            $evento_link->close();

                                            unset($runner,$grupo,$distancia,$precio,$talla,$forma_pago);

                                            $titulo = "SUPER";
                                            $aviso = "Ya estás inscrito en $nom_evento, muchas gracias por el apoyo; si vas a pagar con un medio diferente al pago en linea no olvides confirmar tu pago vía WhatsApp.";

                                            $enlace_wapp = '<a id="btn_wapp" class="btn-gris-ss" href="https://wa.me/573183000598?text=Hola%20!!!,%20quiero%20confirmar%20mi%20inscripción,%20mi%20número%20de%20identificación%20es:%20" target="_blank"><i class="fab fa-whatsapp fa-2x"></i>Escribir</a>';

                                            $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                                            include 'mensaje.php';

                                        }

                                    }

                                }

                            }

                        } // Fin ejecución inscripción al evento

                        break; // Fin INSCRIPCION

                    case 'REGISTRO':


                        break;

                    default:

                        $titulo = "ERROR";
                        $aviso = "Operación no valida para el servidor de ARCANO.";

                        $enlace = '<a href="../" target="_self"><i class="fa-solid fa-person-running"></i> CONTINUAR</a>';

                        include 'mensaje.php';

                        break;
                } // Fin de operaciones validas


            } // Fin validación CUSTODIO

        } // Fin de OPERACION

    }