<?php
require_once("controllers/cextregis.php");
?>
<div class="login-box w-100">
    <div class="row justify-content-center">
        <div class="col-md-8">                
            <div class="card card-form p-4">
                <h2 class="text-center mb-4">Registro de Usuario</h2>

                
                <!-- Formulario corregido: method="POST", inputs con name= -->
                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">

                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Nombre<span class="required-mark">*</span></label>
                        <input type="text" name="prinom" class="form-control" required placeholder="Tu nombre">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Apellido<span class="required-mark">*</span></label>
                        <input type="text" name="priapel" class="form-control" required placeholder="Tu apellido">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark">*</span></label>
                        <input type="email" name="emailu" class="form-control" required placeholder="correo@ejemplo.com">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Teléfono</label>
                        <input type="text" name="teleu" class="form-control" placeholder="3101234567">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" name="passusu" class="form-control" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Mostrar contraseña"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark">*</span></label>
                        <div class="input-group">
                            <input type="password" name="confirm_pass" class="form-control" required placeholder="Repite tu contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword2" aria-label="Mostrar confirmar contraseña"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                        <i class="fa-solid fa-circle-user"></i> Registrarse
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de usuarios registrados -->
<div class="table-container mt-4">
    <h5 class="mb-3">Usuarios Registrados</h5>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if($datAll){ foreach ($datAll as $dt) { ?>
                <tr>
                    <td><?= htmlspecialchars($dt['prinom'] . ' ' . $dt['priapel']) ?></td>
                    <td><?= htmlspecialchars($dt['emailu']) ?></td>
                    <td><?= $dt['estusr'] == 1 ? '<span class="text-success">Activo</span>' : '<span class="text-danger">Inactivo</span>' ?></td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseña -->
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    var input = document.querySelector('input[name="passusu"]');
    var icon = this.querySelector('i');
    if(input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
document.getElementById('togglePassword2').addEventListener('click', function() {
    var input = document.querySelector('input[name="confirm_pass"]');
    var icon = this.querySelector('i');
    if(input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>