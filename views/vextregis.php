<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-10">                
            <div class="card card-form p-4">
                <h2 class="text-center mb-4">Registro de Usuario</h2>
                
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
                            <label class="form-label fw-semibold">Nombre<span class="required-mark">*</span></label>
                            <input type="text" class="form-control" name="prinom" id="prinom" required placeholder="Primer nombre">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Segundo Nombre</label>
                            <input type="text" class="form-control" name="seconom" id="seconom" placeholder="Segundo nombre">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Apellido<span class="required-mark">*</span></label>
                            <input type="text" class="form-control" name="priapel" id="priapel" required placeholder="Primer apellido">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Segundo Apellido</label>
                            <input type="text" class="form-control" name="segapel" id="segapel" placeholder="Segundo apellido">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Documento<span class="required-mark">*</span></label>
                            <input type="number" class="form-control" name="docu" id="docu" required placeholder="Número de documento">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Teléfono<span class="required-mark">*</span></label>
                            <input type="tel" class="form-control" name="teleu" id="teleu" required placeholder="Número de teléfono">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark">*</span></label>
                        <input type="email" class="form-control" name="emailu" id="emailu" required placeholder="correo@ejemplo.com">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="passusu" id="passusu" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_pass" id="confirm_pass" required placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword2"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-institutional btn-sm d-block mx-auto" style="width: 200px; background-color: #ff7f00; color: #ffffff; border-color: #ff7f00;">
                            <i class="fa-solid fa-circle-user"></i> Registrarse
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

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
