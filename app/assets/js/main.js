document.addEventListener('DOMContentLoaded', () => {
    const dropdown = document.getElementById('contenedor-permiso');
    const selectedOption = document.getElementById('selected-option');
    const dropdownOptions = document.getElementById('select-options');
    const hiddenInput = document.getElementById('tipo_permiso');
    const envio_solicitud = document.getElementById('btn-enviar-permiso');
    const permiso_laboral = document.getElementById('permiso-laboral');
    const medioTransporte = document.getElementById('medio_de_transporte');
    const placaVehicular = document.getElementById('placa_vehicular');
    const medioTransporteSeleccion = document.getElementById('medio_transporte_seleccion');
    const medioTransporteOpciones = document.getElementById('medio-transporte-opciones');
    const medioTransporteInput = document.getElementById('medio_de_transporte');
    const placaVehiculoInput = document.getElementById('placa_vehiculo');

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
                permiso_laboral.style.display="flex";
                dropdown.style.zIndex="3";
                dropdown.style.bottom="40px";
                placaVehicular.style.display = "none";

// Mostrar/ocultar las opciones del dropdown
medioTransporteSeleccion.addEventListener('click', () => {
    medioTransporteOpciones.style.display = 
        medioTransporteOpciones.style.display === 'block' ? 'none' : 'block';
});

// Seleccionar una opción del dropdown
medioTransporteOpciones.addEventListener('click', (event) => {
    const selectedValue = event.target.getAttribute('data-value');
    if (selectedValue) {
        medioTransporteSeleccion.textContent = event.target.textContent;
        medioTransporteInput.value = selectedValue;
        medioTransporteOpciones.style.display = 'none';

        // Mostrar campo de placa solo si el transporte requiere
        if (selectedValue === 'MOTOCICLETA' || selectedValue === 'AUTOMOVIL') {
            placaVehiculoInput.style.display = 'block';
        } else {
            placaVehiculoInput.style.display = 'none';
        }
    }
});
                
            }else{
                envio_solicitud.style.display="block";
                permiso_laboral.style.display="none"
                dropdown.style.bottom="0";
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