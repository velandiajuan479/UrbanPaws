<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Urban Paws</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<main class="container">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <div class="icon-circle">A</div>
            Administrador
        </div>

        <div class="card">
            <h1>Panel de administración</h1>
            <p>Gestiona los módulos y procesos generales de Urban Paws según los permisos del administrador.</p>
        </div>
    </section>

    <section class="form-grid">
        <a href="home.php?pg=1" class="card">
            <h3><i class="fa-solid fa-circle-user fa-lg"></i> Usuarios</h3>
            <p>Consulta y administra los usuarios registrados en el sistema.</p>
            <span class="btn btn-primary">Gestionar usuarios</span>
        </a>

        <a href="home.php?pg=3" class="card">
            <h3><i class="fa-solid fa-person-walking fa-lg"></i> Paseadores</h3>
            <p>Consulta la información de los paseadores y sus procesos de validación.</p>
            <span class="btn btn-primary">Gestionar paseadores</span>
        </a>

        <a href="home.php?pg=5" class="card">
            <h3><i class="fa-solid fa-route fa-lg"></i> Rutas</h3>
            <p>Administra las rutas creadas y sus estados dentro del sistema.</p>
            <span class="btn btn-primary">Gestionar rutas</span>
        </a>

        <a href="home.php?pg=6" class="card">
            <h3><i class="fa-solid fa-concierge-bell fa-lg"></i> Servicios</h3>
            <p>Configura y administra los tipos de servicios ofrecidos.</p>
            <span class="btn btn-accent">Gestionar servicios</span>
        </a>

        <a href="home.php?pg=17" class="card">
            <h3><i class="fa-solid fa-file-invoice fa-lg"></i> Facturación</h3>
            <p>Consulta la información de facturas y sus detalles.</p>
            <span class="btn btn-primary">Ver facturación</span>
        </a>

        <a href="#" class="card">
            <h3><i class="fa-brands fa-teamspeak fa-lg"></i> PQRSF</h3>
            <p>Gestiona las peticiones, quejas, reclamos, sugerencias y felicitaciones.</p>
            <span class="btn btn-accent">Gestionar PQRSF</span>
        </a>

        <a href="home.php?pg=25" class="card">
            <h3><i class="fa-solid fa-users-gear fa-lg"></i> Configuración</h3>
            <p>Administra la configuración general y los módulos del sistema.</p>
            <span class="btn btn-outline">Configurar</span>
        </a>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-bottom">
            <span>Urban Paws</span>
            <span>Panel administrativo</span>
        </div>
    </div>
</footer>

</body>
</html>
