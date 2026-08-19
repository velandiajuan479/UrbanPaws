<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-6">                
            <div class="card card-form p-4 auth-card">
                <div class="text-center mb-4">
                    <h2 class="auth-title">¿Olvidó su contraseña?</h2>
                    <p class="auth-subtitle">Te enviaremos una clave temporal</p>
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
                        <label class="form-label-custom">Ingrese su correo electrónico vinculado</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" name="emailu" class="form-control-custom" placeholder="ejemplo@ejem.com" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-brand-primary mt-4">
                        <i class="fa-solid fa-envelope"></i> Enviar Clave Temporal
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#" onclick="document.getElementById('login-tab').click(); return false;" class="auth-link">Volver a Iniciar Sesión</a><br>
                    <a href="#" onclick="document.getElementById('recuperar-tab').click(); return false;" class="auth-link">Recuperar Contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>

