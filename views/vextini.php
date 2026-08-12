<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

            <div class="card card-form p-3 my-5" style="max-width:520px;margin:auto;font-size:1.05rem;">
                <div class="login-box w-100">
                    <form action="models/control.php" method="POST">

                        <div class="mb-2">
                            <label class="form-label mb-1">Usuario o E-mail</label>
                            <input type="text" name="user" class="form-control" placeholder="Ingresa tu Usuario o E-mail" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label mb-1">Contraseña</label>
                            <input type="password" name="pass" class="form-control mb-2" placeholder="Ingresa tu Contraseña" required>

                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="showPassword">
                                    <label class="form-check-label small" for="showPassword">Mostrar contraseña</label>
                                </div>
                            </div>

                            <?php
                                $error = isset($_GET["error"]) ? $_GET["error"]:NULL;
                                if($error=="ok"){
                            ?>
                                <div class="err">Datos incorrectos</div>
                            <?php
                                }
                            ?>
                        </div>

                        <button type="submit" class="form-control btn btn-institutional mb-2">
                            <i class="fa-solid fa-circle-user"></i> Iniciar Sesión</button>
                    </form>
                    <div class="text-center">
                        <a href="#" class="text-decoration-none small">Olvidé mi contraseña</a><br>
                        <a href="#" class="text-decoration-none small">Registrarse</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>