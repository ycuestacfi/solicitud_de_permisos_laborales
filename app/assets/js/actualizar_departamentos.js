function abrirModal(button) {
    let row = button.closest("tr");
    
    let id_departamento = row.getAttribute("data-id");
    let nombre_departamento = row.getAttribute("data-nombre");
    let id_lider = row.getAttribute("data-lider");
   
    // Updated to match new modal input IDs
    document.getElementById("modal_id_departamento").value = id_departamento;
    document.getElementById("modal_nombre_departamento").value = nombre_departamento;
   
    let liderSelect = document.getElementById("modal_id_lider");
    liderSelect.value = id_lider;
   
    document.getElementById("modalActualizar").style.display = "block";
}

function guardarCambios() {
    let id_departamento = document.getElementById("modal_id_departamento").value;
    let nombre_departamento = document.getElementById("modal_nombre_departamento").value;
    let id_lider = document.getElementById("modal_id_lider").value;

    let formData = new FormData();
    formData.append("accion", "actualizar");
    formData.append("id_departamento", id_departamento);
    formData.append("nombre_departamento", nombre_departamento);
    formData.append("id_lider", id_lider);

    fetch("/solicitud_de_permisos_laborales/app/controller/departamentoController.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        Swal.fire({
            title: data.includes("correctamente") ? '¡Éxito!' : 'Error',
            text: data,
            icon: data.includes("correctamente") ? 'success' : 'error',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            cerrarModal();
            location.reload();
        });
    })
    .catch(error => {
        console.error("Error:", error);
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al actualizar el departamento',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
}

function cerrarModal() {
    document.getElementById("modalActualizar").style.display = "none";
}