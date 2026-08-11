<div class="card card-form p-4 mb-5 d-flex flex-column align-items-center justify-content-center"
     style="min-height: 80vh; width: 50%; margin: 0 auto;">

    <div class="d-flex align-items-center justify-content-center mb-4 gap-2">
        <i class="bi bi-shield-lock" style="font-size: 1.8rem;"></i>
        <h1 class="display-title mb-0">Recuperar contraseña</h1>
    </div>

    <div class="login-box w-100">
        <div class="row justify-content-center">
            <div class="col-md-8">                
                <div class="card card-form p-4">
                    <form>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark">*</span></label>
                            <input type="email" class="form-control" id="correo" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Nueva Contraseña<span class="required-mark">*</span></label>
                            <input type="password" class="form-control" id="clave" required placeholder="Mínimo 8 caracteres" minlength="8">
                            <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="showPassword">
                                    <label class="form-check-label small" for="showPassword">Mostrar contraseña</label>
                                </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark">*</span></label>
                            <input type="password" class="form-control" id="clave2" required placeholder="Repite tu contraseña">
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-institutional shadow">
                                <i class="bi bi-save me-2"></i>Guardar Contraseña
                            </button>
                        </div>
            

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-container mt-4">
        <h5 class="mb-3">Recuperaciones</h5>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th> Nueva Contraseña</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if($datAll){ foreach ($datAll as $dt) { ?>
                    <tr>
                        <td><?=$dt['emaper'];?></td>
                        <td><?=$dt['tipo'];?></td>
                    </tr>
                    <?php }}; ?>0
                </tbody>
            </table>
        </div>
    </div>