(function () {
    // Reusable: items use data-card-status; filters are { value, label } and "all" shows every item.
    window.crearFiltrosTarjetas = function (contenedor, filtros) {
        if (!contenedor || !Array.isArray(filtros) || !filtros.length) return;

        var lista = contenedor.querySelector('[data-card-list]');
        if (!lista) return;

        var items = Array.prototype.slice.call(lista.querySelectorAll('[data-card-item]'));
        if (!items.length) return;

        var anterior = contenedor.querySelector('[data-card-filter-controls]');
        if (anterior) anterior.remove();

        var controles = document.createElement('div');
        controles.className = 'd-flex flex-wrap gap-2 mb-3';
        controles.setAttribute('data-card-filter-controls', '');
        controles.setAttribute('role', 'group');
        controles.setAttribute('aria-label', 'Filtrar tarjetas');

        var botones = [];
        var filtroActual = contenedor.getAttribute('data-card-filter-value') || 'all';
        var valores = filtros.map(function (filtro) { return filtro.value; });
        if (valores.indexOf(filtroActual) === -1) filtroActual = valores[0];

        function actualizarBotones() {
            botones.forEach(function (boton) {
                var activo = boton.getAttribute('data-filter-value') === filtroActual;
                boton.className = 'btn ' + (activo ? 'btn-primary' : 'btn-outline-secondary');
                boton.setAttribute('aria-pressed', activo ? 'true' : 'false');
            });
        }

        filtros.forEach(function (filtro) {
            var boton = document.createElement('button');
            var cantidad = filtro.value === 'all'
                ? items.length
                : items.filter(function (item) {
                    return item.getAttribute('data-card-status') === filtro.value;
                }).length;
            boton.type = 'button';
            boton.className = 'btn btn-outline-secondary';
            boton.textContent = filtro.label + ' (' + cantidad + ')';
            boton.setAttribute('data-filter-value', filtro.value);
            boton.setAttribute('aria-pressed', 'false');
            boton.addEventListener('click', function () {
                filtroActual = filtro.value;
                contenedor.setAttribute('data-card-filter-value', filtroActual);
                actualizarBotones();

                if (contenedor.hasAttribute('data-card-table')) {
                    contenedor.dispatchEvent(new CustomEvent('card-filter-change', {
                        detail: { value: filtroActual }
                    }));
                } else {
                    items.forEach(function (item) {
                        item.hidden = filtroActual !== 'all'
                            && item.getAttribute('data-card-status') !== filtroActual;
                    });
                }
            });
            botones.push(boton);
            controles.appendChild(boton);
        });

        actualizarBotones();
        contenedor.setAttribute('data-card-filter-value', filtroActual);
        contenedor.insertBefore(controles, lista);
    };

    window.filterByTab = function (tabId) {
        var botones = document.querySelectorAll('[data-bs-toggle="tab"][data-bs-target]');
        var boton = Array.prototype.filter.call(botones, function (elemento) {
            return elemento.getAttribute('data-bs-target') === '#' + tabId;
        })[0];

        if (boton && window.bootstrap && window.bootstrap.Tab) {
            window.bootstrap.Tab.getOrCreateInstance(boton).show();
        }
    };

    function iniciarFiltrosDeclarados() {
        document.querySelectorAll('[data-card-filters]').forEach(function (contenedor) {
            window.crearFiltrosTarjetas(contenedor, [
                { value: 'all', label: contenedor.getAttribute('data-card-filter-all-label') || 'Todas' },
                { value: 'active', label: contenedor.getAttribute('data-card-filter-active-label') || 'Activas' },
                { value: 'inactive', label: contenedor.getAttribute('data-card-filter-inactive-label') || 'Inactivas' }
            ]);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', iniciarFiltrosDeclarados, { once: true });
    } else {
        iniciarFiltrosDeclarados();
    }
})();
