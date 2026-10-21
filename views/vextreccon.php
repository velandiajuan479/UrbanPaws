<div class="login-box w-100">
    <section class="card card-form p-4" aria-labelledby="reset-title">
        <div class="mb-4">
            <span class="eyebrow">Último paso</span>
            <h2 id="reset-title">Actualizar contraseña</h2>
            <p class="mb-0">Confirma tu correo y establece una nueva contraseña.</p>
        </div>

        <?php if (isset($mensaje) && $mensaje !== ''): ?>
            <div class="alert alert-<?= htmlspecialchars($tipo_mensaje, ENT_QUOTES, 'UTF-8') ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="on">
            <input type="hidden" name="ope" value="reset_password">
            <div class="mb-3">
                <label for="reset_emailu" class="form-label">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                    <input type="email" name="emailu" id="reset_emailu" class="form-control" placeholder="correo@ejemplo.com" autocomplete="email" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="reset_new_pass" class="form-label">Nueva contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                    <input type="password" name="nueva_pass" id="reset_new_pass" class="form-control" placeholder="Mínimo 8 caracteres" minlength="8" autocomplete="new-password" required>
                    <button class="btn btn-outline-secondary btn-toggle-password" type="button" aria-label="Mostrar contraseña"><i class="fa-solid fa-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="mb-3">
                <label for="confirm_reset_pass" class="form-label">Confirmar contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                    <input type="password" name="confirm_pass" id="confirm_reset_pass" class="form-control" placeholder="Vuelve a escribirla" minlength="8" autocomplete="new-password" required>
                    <button class="btn btn-outline-secondary btn-toggle-password" type="button" aria-label="Mostrar contraseña"><i class="fa-solid fa-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 mt-2"><i class="fa-solid fa-key" aria-hidden="true"></i>Actualizar contraseña</button>
        </form>
        <div class="auth-secondary-links">
            <a href="#login" data-auth-back>Volver a iniciar sesión</a>
            <span aria-hidden="true">·</span>
            <a href="#recuperar" data-auth-recovery="request">Solicitar una clave temporal</a>
        </div>
    </section>
</div>
