<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-8">                
            <div class="card card-form p-4 auth-card">
                <div class="text-center mb-4">
                    <h2 class="auth-title">Recuperación de Contraseña</h2>
                    <p class="auth-subtitle">Actualiza tu contraseña de forma segura</p>
                </div>
                
                <?php if(isset($mensaje) && $mensaje != ""): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Correo Electrónico<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" name="emailu" class="form-control-custom" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Nueva Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="nueva_pass" class="form-control-custom" id="nueva_pass" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn-toggle-password" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="confirm_pass" class="form-control-custom" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn-toggle-password" type="button" id="togglePassword2"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                   <button type="submit" class="btn btn-brand-primary mt-4">
                        <i class="fa-solid fa-envelope"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.auth-card {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-light);
}

.auth-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--brand-dark);
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    font-family: 'Nunito', sans-serif;
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
}

.form-label-custom {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--brand-dark);
    text-transform: uppercase;
    margin-bottom: 0.5rem;
    display: block;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: var(--brand-accent);
    font-size: 0.9rem;
    z-index: 2;
}

.form-control-custom {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
    font-size: 0.9rem;
    transition: var(--transition);
}

.form-control-custom:focus {
    border-color: var(--brand-primary);
    box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.2);
    outline: none;
}

.btn-toggle-password {
    position: absolute;
    right: 0.75rem;
    background: transparent;
    border: none;
    color: var(--brand-accent);
    cursor: pointer;
    padding: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-toggle-password:hover {
    color: var(--brand-accent-hover);
}

.btn-brand-primary {
    background: linear-gradient(135deg, var(--brand-dark), var(--brand-primary));
    color: #fff;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: var(--transition);
    width: 100%;
}

.btn-brand-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(26, 58, 92, 0.3);
    color: #fff;
}

.required-mark {
    color: var(--brand-accent);
}
</style>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('nueva_pass');
    var icon = this.querySelector('i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('togglePassword2').addEventListener('click', function() {
    var passwordField = document.getElementById('confirm_pass');
    var icon = this.querySelector('i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
