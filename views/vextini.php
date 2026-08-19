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
            <a href="index.php?pg=31" onclick="document.getElementById('olvido-tab').click(); return false;" class="auth-link">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>



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
