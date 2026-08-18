<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Urban Paws</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<main class="container">
    <section style="padding: 3rem 0;">
        <div class="section-title">
            <div class="icon-circle">P</div>
            Perfil
        </div>

        <div class="card">
            <div class="f
            
            orm-grid">
                <div>
                    <span class="form-label">Nombre completo</span>
                    <p>Nombre del usuario</p>
                </div>

                <div>
                    <span class="form-label">Correo electrónico</span>
                    <p>correo@ejemplo.com</p>
                </div>

                <div>
                    <span class="form-label">Documento</span>
                    <p>Documento del usuario</p>
                </div>

                <div>
                    <span class="form-label">Teléfono</span>
                    <p>Teléfono del usuario</p>
                </div>

                <div>
                    <span class="form-label">Perfil de usuario</span>
                    <p>Cliente / Paseador / Administrador</p>
                </div>

                <div>
                    <span class="form-label">Estado de cuenta</span>
                    <span class="badge badge-active">Activo</span>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="#datos-personales" class="btn btn-primary">Datos personales</a>
                <a href="#configuracion" class="btn btn-outline">Configuración</a>
            </div>
        </div>
    </section>

    <section id="datos-personales" style="padding-bottom: 2rem;">
        <div class="card">
            <h2>Datos personales</h2>
            <p>Actualiza la información personal asociada a tu cuenta.</p>

            <form action="#" method="post" style="margin-top: 1.5rem;">
                <div class="form-grid">
                    <div>
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="input-control" placeholder="Nombre">
                    </div>

                    <div>
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="input-control" placeholder="Apellido">
                    </div>

                    <div>
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" id="correo" name="correo" class="input-control" placeholder="Correo electrónico">
                    </div>

                    <div>
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" class="input-control" placeholder="Teléfono">
                    </div>

                    <div>
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="input-control" placeholder="Dirección">
                    </div>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-accent">Guardar cambios</button>
                </div>
            </form>
        </div>
    </section>

    <section id="configuracion" style="padding-bottom: 3rem;">
        <div class="card">
            <h2>Configuración y seguridad</h2>
            <p>Administra las opciones relacionadas con tu cuenta.</p>

            <div class="form-grid" style="margin-top: 1.5rem;">
                <div>
                    <h3>Contraseña</h3>
                    <p>Actualiza la contraseña de acceso a tu cuenta.</p>
                    <a href="#" class="btn btn-outline">Cambiar contraseña</a>
                </div>

                <div>
                    <h3>Estado de cuenta</h3>
                    <p>Consulta el estado actual de tu cuenta y sus permisos.</p>
                    <a href="#" class="btn btn-outline">Consultar estado</a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-bottom">
            <span>Urban Paws</span>
            <span>Mi espacio personal</span>
        </div>
    </div>
</footer>

</body>
</html>
