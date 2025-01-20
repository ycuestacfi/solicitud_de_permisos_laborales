document.addEventListener('DOMContentLoaded', () => {
    // Element selectors
    const elements = {
        dropdown: document.getElementById('contenedor-permiso'),
        selectedOption: document.getElementById('selected-option'),
        dropdownOptions: document.getElementById('select-options'),
        hiddenInput: document.getElementById('tipo_permiso'),
        envioSolicitud: document.getElementById('btn-enviar-permiso'),
        permisoLaboral: document.getElementById('permiso-laboral'),
        medioTransporteSeleccion: document.getElementById('medio_transporte_seleccion'),
        medioTransporteOpciones: document.getElementById('medio-transporte-opciones'),
        medioTransporteInput: document.getElementById('medio_de_transporte'),
        placaVehiculoInput: document.getElementById('placa_vehiculo'),
    };

    /**
     * Toggle visibility of a given element
     * @param {HTMLElement} element - The element to toggle
     * @param {boolean} [force] - Optional force display (true for show, false for hide)
     */
    const toggleVisibility = (element, force = null) => {
        if (force !== null) {
            element.style.display = force ? 'block' : 'none';
        } else {
            element.style.display = element.style.display === 'block' ? 'none' : 'block';
        }
    };

    /**
     * Handle selection of dropdown options
     * @param {Event} event - The click event
     */
    const handleDropdownSelection = (event) => {
        if (event.target.tagName === 'LI') {
            const value = event.target.dataset.value;
            const text = event.target.textContent;

            elements.selectedOption.textContent = text;
            elements.hiddenInput.value = value;
            toggleVisibility(elements.dropdownOptions, false);

            updateFormBasedOnSelection(value);
        }
    };

    /**
     * Update form based on the selected permission type
     * @param {string} value - Selected permission type
     */
    const updateFormBasedOnSelection = (value) => {
        if (value === 'laboral') {
            toggleVisibility(elements.envioSolicitud, false);
            toggleVisibility(elements.permisoLaboral, true);

            elements.dropdown.style.zIndex = '3';
            elements.dropdown.style.bottom = '40px';
        } else {
            toggleVisibility(elements.envioSolicitud, true);
            toggleVisibility(elements.permisoLaboral, false);

            elements.dropdown.style.bottom = '0';
        }
    };

    /**
     * Handle selection of transportation options
     * @param {Event} event - The click event
     */
    const handleTransportSelection = (event) => {
        const selectedValue = event.target.dataset.value;
        if (selectedValue) {
            elements.medioTransporteSeleccion.textContent = event.target.textContent;
            elements.medioTransporteInput.value = selectedValue;
            toggleVisibility(elements.medioTransporteOpciones, false);

            // Show/hide the vehicle plate field based on transport type
            toggleVisibility(elements.placaVehiculoInput, selectedValue === 'MOTOCICLETA' || selectedValue === 'AUTOMOVIL');
        }
    };

    /**
     * Close dropdowns when clicking outside
     * @param {Event} event - The click event
     */
    const closeDropdownsOnClickOutside = (event) => {
        if (!elements.dropdown.contains(event.target)) {
            toggleVisibility(elements.dropdownOptions, false);
        }
    };

    // Event listeners
    elements.selectedOption.addEventListener('click', () => toggleVisibility(elements.dropdownOptions));
    elements.dropdownOptions.addEventListener('click', handleDropdownSelection);
    elements.medioTransporteSeleccion.addEventListener('click', () => toggleVisibility(elements.medioTransporteOpciones));
    elements.medioTransporteOpciones.addEventListener('click', handleTransportSelection);
    document.addEventListener('click', closeDropdownsOnClickOutside);
});
