document.addEventListener('DOMContentLoaded', function () {
    const mobileMenu = document.getElementById('mobileMenu');
    if (!mobileMenu || !window.bootstrap) return;

    const menu = bootstrap.Collapse.getOrCreateInstance(mobileMenu, { toggle: false });
    const toggler = document.querySelector('[data-bs-target="#mobileMenu"]');
    const togglerIcon = toggler ? toggler.querySelector('i') : null;

    mobileMenu.addEventListener('shown.bs.collapse', function () {
        if (toggler) toggler.setAttribute('aria-label', 'Cerrar navegación');
        if (togglerIcon) togglerIcon.classList.replace('fa-bars', 'fa-xmark');
    });

    mobileMenu.addEventListener('click', function (event) {
        if (event.target.closest('a[href]')) menu.hide();
    });

    mobileMenu.addEventListener('hidden.bs.collapse', function () {
        if (toggler) toggler.setAttribute('aria-label', 'Abrir navegación');
        if (togglerIcon) togglerIcon.classList.replace('fa-xmark', 'fa-bars');
        if (toggler) toggler.focus({ preventScroll: true });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && mobileMenu.classList.contains('show')) {
            menu.hide();
        }
    });
});
