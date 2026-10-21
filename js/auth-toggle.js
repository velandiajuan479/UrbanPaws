// Toggle password (delegado, funciona en todas las vistas)
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-toggle-password');
    if (!btn) return;
    const input = btn.closest('.input-group').querySelector('input');
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

// Validación contraseñas coincidan (solo form #formRegistro)
document.addEventListener('submit', function(e) {
    const form = e.target.closest('#formRegistro');
    if (!form) return;
    const pass = form.querySelector('#passusu');
    const confirm = form.querySelector('#confirm_pass');
    if (pass && confirm && pass.value !== confirm.value) {
        e.preventDefault();
        confirm.setCustomValidity('Las contraseñas no coinciden');
        confirm.reportValidity();
    } else if (confirm) {
        confirm.setCustomValidity('');
    }
});