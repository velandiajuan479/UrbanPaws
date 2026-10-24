$(function () {
    if ($.fn.DataTable) {
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
    }

    document.querySelectorAll('[data-card-table]').forEach(function (table) {
        var list = table.querySelector('[data-card-list]');
        if (!list) return;

        var items = Array.prototype.slice.call(list.querySelectorAll('[data-card-item]'));
        if (!items.length) return;

        var controls = document.createElement('div');
        controls.className = 'row g-2 align-items-center mb-3';

        var searchColumn = document.createElement('div');
        searchColumn.className = 'col-12 col-md-6';
        var search = document.createElement('input');
        search.type = 'search';
        search.className = 'form-control';
        search.placeholder = 'Buscar...';
        search.setAttribute('aria-label', 'Buscar en las tarjetas');
        searchColumn.appendChild(search);
        controls.appendChild(searchColumn);

        function makeSelect(columnClass, ariaLabel, options) {
            var column = document.createElement('div');
            column.className = columnClass;
            var select = document.createElement('select');
            select.className = 'form-select';
            select.setAttribute('aria-label', ariaLabel);
            options.forEach(function (optionData) {
                var option = document.createElement('option');
                option.value = optionData[0];
                option.textContent = optionData[1];
                select.appendChild(option);
            });
            column.appendChild(select);
            controls.appendChild(column);
            return select;
        }

        var sortLabel = table.getAttribute('data-card-sort-label') || 'Contenido';
        var sort = makeSelect('col-6 col-md-3', 'Ordenar tarjetas', [
            ['asc', sortLabel + ' (A–Z)'],
            ['desc', sortLabel + ' (Z–A)']
        ]);
        var pageSize = makeSelect('col-6 col-md-3', 'Tarjetas por página', [
            ['10', '10 por página'],
            ['25', '25 por página'],
            ['50', '50 por página'],
            ['0', 'Todas']
        ]);

        var emptyMessage = document.createElement('p');
        emptyMessage.className = 'col-12 text-muted';
        emptyMessage.textContent = 'No se encontraron tarjetas.';
        emptyMessage.hidden = true;
        list.appendChild(emptyMessage);

        var pagination = document.createElement('div');
        pagination.className = 'd-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mt-3';
        var info = document.createElement('span');
        info.className = 'text-muted';
        info.setAttribute('aria-live', 'polite');
        var buttons = document.createElement('div');
        buttons.className = 'd-flex gap-2';
        var previous = document.createElement('button');
        previous.type = 'button';
        previous.className = 'btn btn-outline-secondary';
        previous.textContent = 'Anterior';
        var next = document.createElement('button');
        next.type = 'button';
        next.className = 'btn btn-outline-secondary';
        next.textContent = 'Siguiente';
        buttons.appendChild(previous);
        buttons.appendChild(next);
        pagination.appendChild(info);
        pagination.appendChild(buttons);

        table.insertBefore(controls, list);
        table.insertBefore(pagination, list.nextSibling);

        var page = 1;
        function render() {
            var query = search.value.trim().toLocaleLowerCase();
            var filtered = items.filter(function (item) {
                var text = item.getAttribute('data-card-search') || item.textContent;
                return text.toLocaleLowerCase().indexOf(query) !== -1;
            });
            filtered.sort(function (a, b) {
                var textA = a.getAttribute('data-card-sort') || a.textContent;
                var textB = b.getAttribute('data-card-sort') || b.textContent;
                var comparison = textA.localeCompare(textB, undefined, { numeric: true, sensitivity: 'base' });
                return sort.value === 'asc' ? comparison : -comparison;
            });

            var size = Number(pageSize.value);
            var pageCount = size === 0 ? 1 : Math.max(1, Math.ceil(filtered.length / size));
            page = Math.min(page, pageCount);
            var start = size === 0 ? 0 : (page - 1) * size;
            var visible = size === 0 ? filtered : filtered.slice(start, start + size);
            items.forEach(function (item) { item.hidden = visible.indexOf(item) === -1; });
            emptyMessage.hidden = filtered.length !== 0;
            info.textContent = filtered.length
                ? 'Mostrando ' + (start + 1) + '–' + (start + visible.length) + ' de ' + filtered.length + ' tarjetas'
                : '0 tarjetas';
            previous.disabled = page === 1;
            next.disabled = page === pageCount;
        }

        search.addEventListener('input', function () { page = 1; render(); });
        sort.addEventListener('change', render);
        pageSize.addEventListener('change', function () { page = 1; render(); });
        previous.addEventListener('click', function () { page -= 1; render(); });
        next.addEventListener('click', function () { page += 1; render(); });
        render();
    });
});
