
    <div class="login-box w-100">

        <div class="row justify-content-center">
            <div class="col-md-8">                
                <h1 class="text-center mb-3">
                    <i class="fa-solid fa-circle-user"></i> Registro de Usuario
                </h1>
                <div class="card card-form p-4">
                    <form>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Nombre<span class="required-mark"></span></label>
                            <input type="text" class="form-control" id="nombre" required placeholder="Nombre">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Apellido<span class="required-mark"></span></label>
                            <input type="text" class="form-control" id="apellido" required placeholder="Apellido">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico<span class="required-mark"></span></label>
                            <input type="email" class="form-control" id="correo" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Nueva Contraseña<span class="required-mark"></span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="clave" required placeholder="Mínimo 8 caracteres" minlength="8">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Confirmar Contraseña<span class="required-mark"></span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="clave2" required placeholder="Repite tu contraseña">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                            <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="width: 200px; background-color: #ff7f00; color: #ffffff; border-color: #ff7f00;">
                                <i class="fa-solid fa-circle-user"></i> Registrarse
                            </button>
            

                    </form>
                </div>
            </div>
        </div>
    </div>
