<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-10">                
            <div class="card card-form p-4 shadow-sm">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold text-dark">Registro de Usuario</h2>
                    <p class="text-muted">Únete a la familia Urban Paws</p>
                </div>
                
                <?php if(isset($mensaje) && $mensaje != ""): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form id="formRegistro" method="POST" action="">
                    <input type="hidden" name="ope" value="save">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prinom" class="form-label fw-semibold text-uppercase small">Nombre<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="prinom" id="prinom" required placeholder="Primer nombre">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="seconom" class="form-label fw-semibold text-uppercase small">Segundo Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="seconom" id="seconom" placeholder="Segundo nombre">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priapel" class="form-label fw-semibold text-uppercase small">Apellido<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="priapel" id="priapel" required placeholder="Primer apellido">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="segapel" class="form-label fw-semibold text-uppercase small">Segundo Apellido</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="segapel" id="segapel" placeholder="Segundo apellido">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="docu" class="form-label fw-semibold text-uppercase small">Documento<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                <input type="tel" inputmode="numeric" pattern="[0-9]+" class="form-control" name="docu" id="docu" required placeholder="Número de documento">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="teleu" class="form-label fw-semibold text-uppercase small">Teléfono<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" class="form-control" name="teleu" id="teleu" required placeholder="Número de teléfono">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="emailu" class="form-label fw-semibold text-uppercase small">Correo Electrónico<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="emailu" id="emailu" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="passusu" class="form-label fw-semibold text-uppercase small">Nueva Contraseña<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="passusu" id="passusu" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn btn-outline-secondary btn-toggle-password px-2 justify-content-center" type="button"><i class="fa-solid fa-eye fa-sm"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="confirm_pass" class="form-label fw-semibold text-uppercase small">Confirmar Contraseña<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="confirm_pass" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary btn-toggle-password px-2 justify-content-center" type="button"><i class="fa-solid fa-eye fa-sm"></i></button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-dark justify-content-center">
                            <i class="fa-solid fa-circle-user"></i> Registrarse
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
