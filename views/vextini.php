<div class="login-box w-100">
    <section class="card card-form p-4" aria-labelledby="login-title">
        <div class="mb-4">
            <span class="eyebrow">Nos alegra tenerte aquí</span>
            <h2 id="login-title">Iniciar sesión</h2>
            <p class="mb-0">Ingresa a tu espacio de cuidado.</p>
        </div>

        <?php if (isset($error_login) && $error_login !== ''): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error_login, ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="on">
            <input type="hidden" name="ope" value="login">

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario, correo o teléfono</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ej. correo@ejemplo.com" autocomplete="username" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Tu contraseña" autocomplete="current-password" required>
                    <button class="btn btn-outline-secondary btn-toggle-password" type="button" aria-label="Mostrar contraseña"><i class="fa-solid fa-eye" aria-hidden="true"></i></button>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="#recuperar" data-auth-recovery="request" class="btn-link">¿Olvidaste tu contraseña?</a>
            </div>
            <button type="submit" class="btn btn-dark w-100">
                Ingresar <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>
        <p class="text-center mt-4 mb-0 small">¿Todavía no tienes cuenta? <a href="#registro" data-auth-tab="registro" class="btn-link">Regístrate</a></p>
    </section>
</div>
