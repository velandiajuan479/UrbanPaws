<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-10">                
            <div class="card card-form p-4 auth-card">
                <div class="text-center mb-4">
                    <h2 class="auth-title">Registro de Usuario</h2>
                    <p class="auth-subtitle">Únete a la familia Urban Paws</p>
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
                            <label class="form-label-custom">Nombre<span class="required-mark">*</span></label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>
                                <input type="text" class="form-control-custom" name="prinom" id="prinom" required placeholder="Primer nombre">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Segundo Nombre</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>
                                <input type="text" class="form-control-custom" name="seconom" id="seconom" placeholder="Segundo nombre">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Apellido<span class="required-mark">*</span></label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>
                                <input type="text" class="form-control-custom" name="priapel" id="priapel" required placeholder="Primer apellido">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Segundo Apellido</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>
                                <input type="text" class="form-control-custom" name="segapel" id="segapel" placeholder="Segundo apellido">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Documento<span class="required-mark">*</span></label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-id-card input-icon"></i>
                                <input type="number" class="form-control-custom" name="docu" id="docu" required placeholder="Número de documento">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Teléfono<span class="required-mark">*</span></label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-phone input-icon"></i>
                                <input type="tel" class="form-control-custom" name="teleu" id="teleu" required placeholder="Número de teléfono">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Correo Electrónico<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" class="form-control-custom" name="emailu" id="emailu" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Nueva Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" class="form-control-custom" name="passusu" id="passusu" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn-toggle-password" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label-custom">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" class="form-control-custom" name="confirm_pass" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn-toggle-password" type="button" id="togglePassword2"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-brand-primary">
                            <i class="fa-solid fa-circle-user"></i> Registrarse
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>

</style>

<script>
// Toggle mostrar/ocultar contraseña
document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('passusu');
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

// Validar que las contraseñas coincidan antes de enviar
document.getElementById('formRegistro').addEventListener('submit', function(e) {
    var pass = document.getElementById('passusu').value;
    var confirm = document.getElementById('confirm_pass').value;
    
    if (pass !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden. Por favor verifique.');
        return false;
    }
});
</script>
