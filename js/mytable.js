$(function () {
    if (!$.fn.DataTable) return;

    $('.table-responsive table[id="mitabla"]').each(function () {
        if ($.fn.DataTable.isDataTable(this)) return;

        $(this).DataTable({
            autoWidth: false,
            scrollX: false,
            responsive: false,
            pageLength: 10,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
            }
        });
    });
});
