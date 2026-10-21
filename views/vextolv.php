<div class="login-box w-100">
    <section class="card card-form p-4" aria-labelledby="forgot-title">
        <div class="mb-4">
            <span class="eyebrow">Recuperación de acceso</span>
            <h2 id="forgot-title">¿Olvidaste tu contraseña?</h2>
            <p class="mb-0">Indica el correo asociado a tu cuenta.</p>
        </div>

        <?php if (isset($mensaje) && $mensaje !== ''): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo_mensaje, ENT_QUOTES, 'UTF-8') ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="on">
            <input type="hidden" name="ope" value="request_temporary_password">
            <div class="mb-3">
                <label for="recover_emailu" class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                    <input type="email" name="emailu" id="recover_emailu" class="form-control" placeholder="correo@ejemplo.com" autocomplete="email" required>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i>Solicitar instrucciones</button>
        </form>
        <div class="auth-secondary-links">
            <a href="#login" data-auth-back>Volver a iniciar sesión</a>
            <span aria-hidden="true">·</span>
            <a href="#recuperar" data-auth-reset>Ya tengo mi clave temporal</a>
        </div>
    </section>
</div>
