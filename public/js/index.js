$(document).ready(function() {
    $('#tabla-ejemplo').DataTable({
        lengthChange: false,
        searching: false, // Habilitar filtrado por campo   
        columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
            {
                responsivePriority: 2,
                targets: -1
            }
        ],
        language: {
            paginate: {
                first: "Primera",
                last: "Última",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        lengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "Todos"]
        ],
        pageLength: 5,
    });
});