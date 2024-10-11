document.addEventListener('DOMContentLoaded', () => {
    let alertaMostrada = false; // Bandera para verificar si la alerta ya se mostró

    function validarCorreo() {
        const emailInput = document.getElementById('email');
        const email = emailInput.value;

        // Verificar si el correo no es válido
        if (!email.endsWith('@providenciacfi.com')) {
            emailInput.style.border = 'solid 1px red'; // Agregar borde rojo si no es válido
            if (!alertaMostrada) { // Solo mostrar la alerta si no se mostró antes
                alertaMostrada = true; // Marcar que la alerta se ha mostrado
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El correo no es válido. Debe ser del dominio @providenciacfi.com.',
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        confirmButton: 'button-aceptar-alert' // Aplica la clase personalizada aquí
                    }
                }).then(() => {
                    emailInput.focus(); // Pone el foco sobre el input de email
                    // Mantener alertaMostrada en true hasta que el correo sea corregido
                });
            }
            return false; // Indicar que la validación falló
        } else {
            // Reiniciar la bandera si el correo es válido y cambiar el borde a verde
            emailInput.style.border = 'solid 2px var(--verde-corporativo)';
            emailInput.style.boxShadow = '4px 4px 0px var(--verde-corporativo)';
            alertaMostrada = false; 
        }
        return true; // Indicar que la validación fue exitosa
    }

    // Reiniciar la bandera alertaMostrada al cambiar el contenido del email
    document.getElementById('email').addEventListener('input', () => {
        alertaMostrada = false; // Permitir que la alerta se vuelva a mostrar si el correo sigue siendo inválido
    });

    // Verificar el correo al hacer clic en el campo de contraseña
    document.getElementById('password').addEventListener('focus', function() {
        const esValido = validarCorreo();
        if (!esValido) {
            const emailInput = document.getElementById('email');
            emailInput.focus(); // Coloca el foco en el input de email si es inválido
        }
    });

    // Verificar el correo al enviar el formulario
    document.getElementById('login-form').addEventListener('submit', function(event) {
        if (!validarCorreo()) {
            event.preventDefault(); // Evitar que el formulario se envíe
        }
    });

    // Para verificar el correo al presionar 'Tab'
    document.getElementById('email').addEventListener('keydown', function(event) {
        if (event.key === 'Tab') {
            validarCorreo();
        }
    });

    
    
});