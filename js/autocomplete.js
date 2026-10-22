// shortcut: selects simples con etiquetas únicas; multi-selects requieren una interfaz por tokens.
document.querySelectorAll('select[data-autocomplete]:not([multiple])').forEach(function (select, index) {
    var id = select.id ? select.id + '-autocomplete' : 'autocomplete-select-' + index;
    var label = (select.labels && select.labels[0]) || (select.previousElementSibling && select.previousElementSibling.tagName === 'LABEL' ? select.previousElementSibling : null);
    var wrapper = document.createElement('div');
    var input = document.createElement('input');
    var toggle = document.createElement('button');
    var list = document.createElement('div');
    var options = Array.from(select.options).filter(function (option) {
        return option.value !== '' && !option.disabled;
    }).map(function (option) {
        return { value: option.value, label: option.label.trim() };
    });
    var visibleOptions = [];
    var activeIndex = -1;

    wrapper.className = 'up-autocomplete';
    input.type = 'text';
    input.id = id;
    input.className = select.className;
    input.classList.remove('form-select');
    input.required = select.required;
    input.disabled = select.disabled;
    input.placeholder = select.dataset.placeholder || Array.from(select.options).find(function (option) {
        return option.value === '';
    })?.label.trim() || '';
    input.setAttribute('role', 'combobox');
    input.setAttribute('aria-autocomplete', 'list');
    input.setAttribute('aria-haspopup', 'listbox');
    input.setAttribute('aria-controls', id + '-options');
    input.setAttribute('aria-expanded', 'false');
    input.setAttribute('autocomplete', 'off');

    if (label) {
        label.htmlFor = id;
    } else if (select.getAttribute('aria-label')) {
        input.setAttribute('aria-label', select.getAttribute('aria-label'));
    }
    if (select.getAttribute('aria-describedby')) {
        input.setAttribute('aria-describedby', select.getAttribute('aria-describedby'));
    }

    toggle.type = 'button';
    toggle.className = 'up-autocomplete__toggle';
    toggle.disabled = select.disabled;
    toggle.setAttribute('aria-label', 'Mostrar opciones');
    toggle.setAttribute('tabindex', '-1');
    toggle.innerHTML = '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';

    list.id = id + '-options';
    list.className = 'up-autocomplete__list';
    list.setAttribute('role', 'listbox');
    list.hidden = true;

    function closeList() {
        list.hidden = true;
        input.setAttribute('aria-expanded', 'false');
        input.removeAttribute('aria-activedescendant');
        activeIndex = -1;
    }

    function choose(option) {
        var changed = select.value !== option.value;
        select.value = option.value;
        input.value = option.label;
        input.setCustomValidity('');
        closeList();
        if (changed) {
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    function setActive(index) {
        if (!visibleOptions.length) { return; }
        activeIndex = (index + visibleOptions.length) % visibleOptions.length;
        Array.from(list.querySelectorAll('[role="option"]')).forEach(function (item, itemIndex) {
            item.classList.toggle('is-active', itemIndex === activeIndex);
        });
        input.setAttribute('aria-activedescendant', id + '-option-' + activeIndex);
        list.children[activeIndex].scrollIntoView({ block: 'nearest' });
    }

    function renderOptions(query) {
        var search = query.trim().toLocaleLowerCase();
        visibleOptions = options.filter(function (option) {
            return option.label.toLocaleLowerCase().includes(search);
        });
        list.replaceChildren();

        visibleOptions.forEach(function (option, optionIndex) {
            var item = document.createElement('div');
            item.id = id + '-option-' + optionIndex;
            item.className = 'up-autocomplete__option';
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', String(select.value === option.value));
            item.textContent = option.label;
            item.addEventListener('mousedown', function (event) { event.preventDefault(); });
            item.addEventListener('click', function () { choose(option); });
            list.appendChild(item);
        });

        if (!visibleOptions.length) {
            var empty = document.createElement('div');
            empty.className = 'up-autocomplete__empty';
            empty.textContent = 'Sin resultados';
            list.appendChild(empty);
        }

        var selectedIndex = visibleOptions.findIndex(function (option) {
            return option.value === select.value;
        });
        if (selectedIndex >= 0) {
            setActive(selectedIndex);
        } else {
            activeIndex = -1;
            input.removeAttribute('aria-activedescendant');
        }
    }

    function openList(query) {
        renderOptions(query);
        list.hidden = false;
        input.setAttribute('aria-expanded', 'true');
    }

    function syncSelection() {
        var query = input.value.trim().toLocaleLowerCase();
        var match = options.find(function (option) { return option.label.toLocaleLowerCase() === query; });
        var previousValue = select.value;
        select.value = match ? match.value : '';
        if (match) { input.value = match.label; }
        input.setCustomValidity(input.value && !match ? 'Selecciona una opción de la lista.' : '');
        if (previousValue !== select.value) {
            select.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    input.value = select.value ? select.options[select.selectedIndex].label.trim() : '';
    input.addEventListener('focus', function () { openList(''); });
    input.addEventListener('input', function () {
        syncSelection();
        openList(input.value);
    });
    input.addEventListener('blur', function () { setTimeout(closeList, 100); });
    input.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault();
            if (list.hidden) {
                openList('');
            } else {
                setActive(activeIndex + (event.key === 'ArrowDown' ? 1 : -1));
            }
        } else if (event.key === 'Enter' && !list.hidden && activeIndex >= 0) {
            event.preventDefault();
            choose(visibleOptions[activeIndex]);
        } else if (event.key === 'Escape') {
            closeList();
        }
    });
    toggle.addEventListener('mousedown', function (event) { event.preventDefault(); });
    toggle.addEventListener('click', function () {
        if (list.hidden) {
            input.focus();
            openList('');
        } else {
            closeList();
        }
    });

    if (select.form) {
        select.form.addEventListener('reset', function () {
            setTimeout(function () {
                input.value = select.value ? select.options[select.selectedIndex].label.trim() : '';
                input.setCustomValidity('');
                closeList();
            });
        });
    }

    wrapper.append(input, toggle, list);
    select.required = false;
    select.hidden = true;
    select.parentNode.insertBefore(wrapper, select);
});
