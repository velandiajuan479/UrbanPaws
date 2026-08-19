<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-8">                
            <div class="card card-form p-4 auth-card">
                <div class="text-center mb-4">
                    <h2 class="auth-title">Recuperación de Contraseña</h2>
                    <p class="auth-subtitle">Actualiza tu contraseña de forma segura</p>
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
                        <label class="form-label-custom">Correo Electrónico<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" name="emailu" class="form-control-custom" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Nueva Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="nueva_pass" class="form-control-custom" id="nueva_pass" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn-toggle-password" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="confirm_pass" class="form-control-custom" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn-toggle-password" type="button" id="togglePassword2"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                   <button type="submit" class="btn btn-brand-primary mt-4">
                        <i class="fa-solid fa-envelope"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>

</style>

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
