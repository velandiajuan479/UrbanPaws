<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-6">                
            <div class="card card-form p-4">
                <h2 class="text-center mb-4">¿Olvidó su contraseña?</h2>
                
                <?php if(isset($mensaje) && $mensaje != ""): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">
                    
                    <div class="mb-3">
                        <label for="emailu" class="form-label fw-semibold">Ingrese su correo electrónico vinculado</label>
                        <input type="email" name="emailu" class="form-control" placeholder="ejemplo@ejem.com" required>
                    </div>
                    
                    <button type="submit" class="btn btn-institutional btn-sm d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                        <i class="fa-solid fa-envelope"></i> Enviar Clave Temporal
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#" onclick="document.getElementById('login-tab').click(); return false;" class="text-decoration-none small">Volver a Iniciar Sesión</a><br>
                    <a href="#" onclick="document.getElementById('recuperar-tab').click(); return false;" class="text-decoration-none small">Recuperar Contraseña</a>
                </div>
            </div>
        </div>
    </div>
</div>
