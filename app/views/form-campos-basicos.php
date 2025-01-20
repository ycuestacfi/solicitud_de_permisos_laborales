<div class="form-group">
    <input class="form-control" 
           type="text" 
           name="nombre" 
           id="nombre" 
           value="<?php echo htmlspecialchars($_SESSION['nombres'] . ' ' . $_SESSION['apellidos']); ?>" 
           required 
           readonly>
           
    <input class="form-control" 
           type="email" 
           name="email" 
           id="email" 
           value="<?php echo htmlspecialchars($_SESSION['correo']); ?>" 
           required 
           readonly>
           
    <input type="hidden" 
           name="cedula" 
           value="<?php echo htmlspecialchars($_SESSION['cedula']); ?>">
           
    <input type="hidden" 
           name="departamento" 
           value="<?php echo htmlspecialchars($_SESSION['id_departamento']); ?>">
</div>

<div class="form-group">
    <input class="form-control" 
           type="date" 
           name="fecha_de_solicitud" 
           id="fecha_de_solicitud" 
           required 
           min="<?php echo date('Y-m-d'); ?>">
           
    <input class="form-control" 
           type="date" 
           name="fecha_de_permiso" 
           id="fecha_de_permiso" 
           required 
           min="<?php echo date('Y-m-d'); ?>">
</div>

<div class="form-group">
    <input class="form-control" 
           type="time" 
           name="hora_de_salida" 
           id="hora_de_salida" 
           required>
           
    <input class="form-control" 
           type="time" 
           name="hora_de_llegada" 
           id="hora_de_llegada" 
           required>
</div>

<div class="form-group">
    <textarea class="form-control" 
              name="observaciones" 
              id="observaciones" 
              placeholder="Observaciones adicionales" 
              required></textarea>
</div>

<div class="form-group">
    <label for="evidencias" class="file-upload">
        <i class="fas fa-upload"></i> Cargar evidencias
    </label>
    <input type="file" 
           id="evidencias" 
           name="evidencias" 
           accept=".pdf,.jpg,.jpeg,.png">
</div>