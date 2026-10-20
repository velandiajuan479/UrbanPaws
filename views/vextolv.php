<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-6">                
            <div class="card card-form p-4 shadow-sm">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold text-dark">¿Olvidó su contraseña?</h2>
                    <p class="text-muted">Te enviaremos una clave temporal</p>
                </div>
                
                <?php if(isset($mensaje) && $mensaje != ""): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">
                    
                    <div class="mb-3">
                        <label for="emailu" class="form-label fw-semibold text-uppercase small">Ingrese su correo electrónico vinculado</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="emailu" id="emailu" class="form-control" placeholder="ejemplo@ejem.com" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 mt-4">
                        <i class="fa-solid fa-envelope"></i> Enviar Clave Temporal
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#" onclick="document.getElementById('login-tab').click(); return false;" class="text-decoration-none fw-semibold">Volver a Iniciar Sesión</a><br>
                    <a href="#" onclick="document.getElementById('recuperar-tab').click(); return false;" class="text-decoration-none fw-semibold">Recuperar Contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>
