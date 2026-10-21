<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-8">                
            <div class="card card-form p-4 shadow-sm">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold text-dark">Recuperación de Contraseña</h2>
                    <p class="text-muted">Actualiza tu contraseña de forma segura</p>
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
                        <label for="emailu" class="form-label fw-semibold text-uppercase small">Correo Electrónico<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="emailu" id="emailu" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="nueva_pass" class="form-label fw-semibold text-uppercase small">Nueva Contraseña<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="nueva_pass" id="nueva_pass" class="form-control" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn btn-outline-secondary btn-toggle-password px-2 justify-content-center" type="button"><i class="fa-solid fa-eye fa-sm"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="confirm_pass" class="form-label fw-semibold text-uppercase small">Confirmar Contraseña<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" required placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary btn-toggle-password px-2 justify-content-center" type="button"><i class="fa-solid fa-eye fa-sm"></i></button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 mt-4 justify-content-center">
                        <i class="fa-solid fa-envelope"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
