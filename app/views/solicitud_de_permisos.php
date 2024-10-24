<?php session_start();
include_once './estructure/head.php'; ?>
        

        <section id="fondo-form" >
            <a style="left: 50%; transform: translateX(-50%); position: absolute; top: 25px; color: var(--blanco); font-size: 30px; font-weight: 600;">
                <?php echo 'Bienvenido '. $_SESSION['nombres']  ." ". $_SESSION['apellidos'] ; ?>
            </a> 
            
            <div id="fondo-formulario">
            <!-- <form action="https://formsubmit.co/efc8028f1cfa38148558f5c9cc1e98df" method="POST"  id="formulario-solicitud"> -->
                
                <form action="" method="POST"  id="formulario-solicitud">
                  
                    <h1>Formulario De Solicitud</h1>
                     
                          
                    
                   
                    <input class="input_solicitud" placeholder="Nombre y Apellido" type="text" name="nombre" id="nombre" title="rellene el campo con su Nombre y Apellido"  pattern="[A-Za-z\s]{2,}"  minlength="2" required>
    
                    
                    <input class="input_solicitud" placeholder="Correo" type="email" id="correo" name="email" required>
                    
                    
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
    
                    <label for="tipo-permiso" class="input-d">Seleccione un tipo de Permiso</label>
                    <select class="input-d input_solicitud" name="tipo-permiso" id="tipo-permiso" required>
                        <option class="optiones" value="personal">Personal</option>
                        <option class="optiones" value="cita-medica" color="red">Cita Medica</option>
                        <option class="optiones" value="calamidad-domestica">Calamidad Domestica</option>
                        <option class="optiones" value="estudio">Estudio</option>
                        <option class="optiones" value="laboral">Laboral</option>
                    </select>
    
                    
                    <input class="input-d input_solicitud" placeholder="Hora de salida" type="time" id="hora-de-salida" name="hora-de-salida" required>
    
                    
                    <input class="input-d input_solicitud" placeholder="Hora de llegada" type="time" id="hora-de-llegada" name="hora-de-llegada" required>
    
                    
                    <textarea  class="input-d input_solicitud" placeholder="Observaciones" name="observaciones" id="observaciones" required></textarea>
    
                    <button type="submit" id="btn-enviar">Enviar solicitud</button>
                </form>
            </div>
            <figure id="contenedor-logo">
                <img src="/app/assets/img/logoOficial.png" alt="">
            </figure>
        </section>
        
        <?php include_once './estructure/footer.php' ?>