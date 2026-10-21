<div class="login-box w-100">
    <div class="card card-form p-4 shadow-sm" style="max-width: 450px; margin: 0 auto;">
        <div class="text-center mb-4">
            <h2 class="h3 fw-bold text-dark">Inicio de Sesión</h2>
            <p class="text-muted">Bienvenido de nuevo a Urban Paws</p>
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
                <label for="usuario" class="form-label fw-semibold text-uppercase small">Usuario, Correo o Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingresa tu usuario, correo o teléfono" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label fw-semibold text-uppercase small">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
                    <button class="btn btn-outline-secondary btn-toggle-password px-2 justify-content-center" type="button"><i class="fa-solid fa-eye fa-sm"></i></button>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-dark justify-content-center">
                    <i class="fa-solid fa-circle-user"></i> Ingresar
                </button>
            </div>

        </form>
        <div class="text-center mt-3">
            <a href="#" onclick="document.getElementById('olvido-tab').click(); return false;" class="text-decoration-none fw-semibold">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>
