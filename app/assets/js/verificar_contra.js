document.addEventListener('DOMContentLoaded', () => {
    // Función para validar la contraseña
    function validarPassword() {
        const passwordInput = document.getElementById('password');
        const password = passwordInput.value;

        // Verificar si la contraseña tiene al menos 8 caracteres
        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe tener al menos 8 caracteres.',
                timer: 500, // Duración de 0.5 segundos
                timerProgressBar: true,
                showConfirmButton: false
            });
            return false;
        }

        // Verificar si contiene al menos una letra y un número
        const tieneLetra = /[a-zA-Z]/.test(password);
        const tieneNumero = /\d/.test(password);
        if (!tieneLetra || !tieneNumero) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe contener al menos una letra y un número.',
                timer: 500, // Duración de 0.5 segundos
                timerProgressBar: true,
                showConfirmButton: false
            });
            return false;
        }

        // Verificar si el último carácter es un punto (.), almohadilla (#) o asterisco (*)
        const ultimoCaracter = password.slice(-1);
        if (ultimoCaracter !== '.' && ultimoCaracter !== '#' && ultimoCaracter !== '*') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "La contraseña debe terminar en un '.', '#' o '*'.",
                timer: 500, // Duración de 0.5 segundos
                timerProgressBar: true,
                showConfirmButton: false
            });
            return false;
        }

        // Si todas las condiciones se cumplen, retornar verdadero
        return true;
    }

    // // Verificar el campo de contraseña al intentar enviar el formulario
    // document.getElementById('form-login').addEventListener('submit', function(event) {
    //     if (!validarPassword()) {
    //         event.preventDefault(); // Evitar que el formulario se envíe si la contraseña no es válida
    //     }
    // });
});