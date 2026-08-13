<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Urban Paws</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="hero-section">
    <div class="container">
        <a href="vusuadmin.php" class="logo-container">
            <div class="logo-text">
                <span class="brand">Urban<span>Paws</span></span>
                <span class="tagline">Panel administrativo</span>
            </div>
        </a>

        <nav>
            <ul class="nav-links">
                <li><a href="vusuadmin.php" class="nav-link active">Inicio</a></li>
                <li><a href="vmen.php" class="nav-link">Usuarios</a></li>
                <li><a href="vusupas.php" class="nav-link">Paseadores</a></li>
                <li><a href="vruta.html" class="nav-link">Rutas</a></li>
                <li><a href="vservicios.html" class="nav-link">Servicios</a></li>
                <li><a href="vcofpag.php" class="nav-link">Facturas</a></li>
                <li><a href="vpqrs.html" class="nav-link">PQRSF</a></li>
                <li><a href="vcofmod.php" class="nav-link">Configuración</a></li>
                <li><a href="vusupef.php" class="nav-link">Perfil</a></li>
            </ul>
        </nav>
    </div>
</header>

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
        <a href="vmen.php" class="card">
            <div class="icon-circle">U</div>
            <h3>Usuarios</h3>
            <p>Consulta y administra los usuarios registrados en el sistema.</p>
            <span class="btn btn-primary">Gestionar usuarios</span>
        </a>

        <a href="vusupas.php" class="card">
            <div class="icon-circle">P</div>
            <h3>Paseadores</h3>
            <p>Consulta la información de los paseadores y sus procesos de validación.</p>
            <span class="btn btn-primary">Gestionar paseadores</span>
        </a>

        <a href="vruta.html" class="card">
            <div class="icon-circle">R</div>
            <h3>Rutas</h3>
            <p>Administra las rutas creadas y sus estados dentro del sistema.</p>
            <span class="btn btn-primary">Gestionar rutas</span>
        </a>

        <a href="vservicios.html" class="card">
            <div class="icon-circle">S</div>
            <h3>Servicios</h3>
            <p>Configura y administra los tipos de servicios ofrecidos.</p>
            <span class="btn btn-accent">Gestionar servicios</span>
        </a>

        <a href="vcofpag.php" class="card">
            <div class="icon-circle">F</div>
            <h3>Facturación</h3>
            <p>Consulta la información de facturas y sus detalles.</p>
            <span class="btn btn-primary">Ver facturación</span>
        </a>

        <a href="vpqrs.html" class="card">
            <div class="icon-circle">Q</div>
            <h3>PQRSF</h3>
            <p>Gestiona las peticiones, quejas, reclamos, sugerencias y felicitaciones.</p>
            <span class="btn btn-accent">Gestionar PQRSF</span>
        </a>

        <a href="vcofmod.php" class="card">
            <div class="icon-circle">C</div>
            <h3>Configuración</h3>
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
