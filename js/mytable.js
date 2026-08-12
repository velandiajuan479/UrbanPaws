$(document).ready(function () {
    $('#mitabla').DataTable({
        autoWidth: false,
        scrollX: false,
        responsive: false,
        pageLength: 10,
        
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
        }
    });
});