<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card card-form p-3 my-5" style="max-width:520px;margin:auto;font-size:1.25rem;">

                
                        <h2 class="text-center mb-4" style="font-size:1.8rem;">Inicio de sesión Urban Paws</h2>


                <div class="login-box w-100">
                    <form action="models/control.php" method="POST">

                        <div class="mb-2">
                            <label class="form-label mb-1" style="font-size:1.05rem;">Usuario o E-mail</label>
                            <input type="text" name="usuario" class="form-control" style="font-size:1.05rem; padding:.6rem;" placeholder="Ingresa tu Usuario o E-mail" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label mb-1" style="font-size:1.05rem;">Contraseña</label>
                            <input type="password" name="contrasena" class="form-control mb-2" style="font-size:1.05rem; padding:.6rem;" placeholder="Ingresa tu Contraseña" required>

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

                        <button type="submit" class="btn btn-institutional btn-sm mb-2 d-block mx-auto" style="background-color: #ff7f00; color: #ffffff; border-color: #ff7f00; padding: .5rem 1rem; font-size: 1.1rem;">
                            <i class="fa-solid fa-circle-user"></i> Ingresar
                        </button>

                        <!-- Enlace para Olvidó Contraseña (pg=31) -->
                        <div class="text-center mt-3">
                            <a href="index.php?pg=31" class="text-decoration-none d-block mb-2" style="color: #555;">
                                Olvidé mi contraseña
                            </a>
                            
                            <!-- Enlace para Registrarse (pg=28) -->
                            <a href="index.php?pg=28" class="text-decoration-none d-block" style="color: #555;">
                                Registrarse
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
</div>