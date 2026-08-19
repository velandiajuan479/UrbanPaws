<div class="login-box w-100">
    <div class="card card-form p-4">
        <h2 class="text-center mb-4">Inicio de Sesión</h2>
        
        <?php if(isset($error_login) && $error_login != ""): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_login; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="ope" value="login">
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Usuario, Correo o Teléfono</label>
                <input type="text" name="usuario" class="form-control" placeholder="Ingresa tu usuario, correo o teléfono" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="contrasena" class="form-control" id="contrasena" placeholder="Ingresa tu contraseña" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-institutional btn-sm d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                    <i class="fa-solid fa-circle-user"></i> Ingresar
                </button>
            </div>

        </form>
        <div class="text-center mt-3">
            <a href="#" onclick="document.getElementById('olvido-tab').click(); return false;" class="text-decoration-none small">¿Olvidaste tu contraseña?</a>
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
