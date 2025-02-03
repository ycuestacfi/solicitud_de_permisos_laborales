function mostrarEvidencia(url) {
    if (url == "") {
        alert("No hay evidencia disponible.");
        return;
    }

    document.getElementById("imagenEvidencia").src = url;
    document.getElementById("modalEvidencia").style.display = "flex";
}

function cerrarModalE() {
    const modalElement = document.getElementById('modalEvidencia');
    if (modalElement) {
        modalElement.style.display = 'none';
    }
}

// Cerrar el modal si se hace clic fuera de la imagen
document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("modalEvidencia");

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            cerrarModalE();
        }
    });
});

// Cierra el modal si el usuario hace clic fuera de la imagen
window.onclick = function(event) {
    var modal = document.getElementById("modalEvidencia");
    if (event.target === modal) {
        cerrarModal();
    }
};