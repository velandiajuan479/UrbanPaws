<div class="login-box w-100">
    <div class="card card-form p-4 auth-card">
        <div class="text-center mb-4">
            <h2 class="auth-title">Inicio de Sesión</h2>
            <p class="auth-subtitle">Bienvenido de nuevo a Urban Paws</p>
        </div>
        
        <?php if(isset($error_login) && $error_login != ""): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_login; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="ope" value="login">
            
            <div class="mb-3">
                <label class="form-label-custom">Usuario, Correo o Teléfono</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input type="text" name="usuario" class="form-control-custom" placeholder="Ingresa tu usuario, correo o teléfono" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Contraseña</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input type="password" name="contrasena" class="form-control-custom" id="contrasena" placeholder="Ingresa tu contraseña" required>
                    <button class="btn-toggle-password" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-brand-primary">
                    <i class="fa-solid fa-circle-user"></i> Ingresar
                </button>
            </div>

        </form>
        <div class="text-center mt-3">
            <a href="#" onclick="document.getElementById('olvido-tab').click(); return false;" class="auth-link">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>

<style>
.auth-card {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border-light);
    max-width: 450px;
    margin: 0 auto;
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

.auth-link {
    color: var(--brand-primary);
    font-size: 0.85rem;
    font-weight: 600;
    transition: var(--transition);
}

.auth-link:hover {
    color: var(--brand-accent);
    text-decoration: underline;
}
</style>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('contrasena');
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
