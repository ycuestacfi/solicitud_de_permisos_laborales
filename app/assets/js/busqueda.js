function filtrarTabla() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("busqueda");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabla_registros");
    tr = table.getElementsByTagName("tr");

    // Itera sobre las filas de la tabla y oculta las que no coincidan con la búsqueda
    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";  // Oculta las filas por defecto
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";  // Muestra la fila si hay coincidencia
                    break;
                }
            }
        }
    }
}