<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-8">                
            <div class="card card-form p-4">
                <h2 class="text-center mb-4">Recuperación de Contraseña</h2>
                
                <?php if(isset($mensaje) && $mensaje != ""): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark">*</span></label>
                        <input type="email" name="emailu" class="form-control" required placeholder="correo@ejemplo.com">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" name="nueva_pass" class="form-control" id="nueva_pass" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" name="confirm_pass" class="form-control" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword2"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                   <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                        <i class="fa-solid fa-envelope"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('nueva_pass');
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

document.getElementById('togglePassword2').addEventListener('click', function() {
    var passwordField = document.getElementById('confirm_pass');
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
