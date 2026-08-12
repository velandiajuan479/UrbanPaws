<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paseador | Urban Paws</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="hero-section">
    <div class="container">
        <a href="vusupas.php" class="logo-container">
            <img src="../img/logo.png" alt="Urban Paws" class="logo-img">
            <div class="logo-text">
                <span class="brand">Urban<span>Paws</span></span>
                <span class="tagline">Espacio del paseador</span>
            </div>
        </a>

        <nav>
            <ul class="nav-links">
                <li><a href="vusupas.php" class="nav-link active">Inicio</a></li>
                <li><a href="vpaseo.html" class="nav-link">Paseos</a></li>
                <li><a href="vruta.html" class="nav-link">Rutas</a></li>
                <li><a href="vservicios.html" class="nav-link">Servicios</a></li>
                <li><a href="vusupef.php" class="nav-link">Perfil</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <div class="icon-circle">P</div>
            Paseador
        </div>

        <div class="card">
            <h1>Panel del paseador</h1>
            <p>Consulta tu información, disponibilidad y las actividades relacionadas con los servicios de paseo.</p>
        </div>
    </section>

    <section class="form-grid">
        <article class="card">
            <div class="icon-circle">V</div>
            <h3>Estado de validación</h3>
            <p>Consulta el estado de validación de tu perfil como paseador.</p>
            <span class="badge badge-active">Estado pendiente de consulta</span>
        </article>

        <a href="vpaseo.html" class="card">
            <div class="icon-circle">P</div>
            <h3>Mis paseos</h3>
            <p>Consulta los paseos asignados y el seguimiento de los servicios.</p>
            <span class="btn btn-primary">Ver paseos</span>
        </a>

        <a href="vruta.html" class="card">
            <div class="icon-circle">R</div>
            <h3>Rutas</h3>
            <p>Consulta las rutas disponibles y la información necesaria para realizar los servicios.</p>
            <span class="btn btn-primary">Ver rutas</span>
        </a>

        <a href="vservicios.html" class="card">
            <div class="icon-circle">S</div>
            <h3>Servicios</h3>
            <p>Consulta los servicios relacionados con tu actividad como paseador.</p>
            <span class="btn btn-accent">Ver servicios</span>
        </a>

        <a href="vusupef.php" class="card">
            <div class="icon-circle">P</div>
            <h3>Mi perfil</h3>
            <p>Consulta y actualiza la información general asociada a tu cuenta.</p>
            <span class="btn btn-outline">Ver perfil</span>
        </a>
    </section>

    <section style="padding: 2rem 0 3rem;">
        <div class="card">
            <h3>Información del paseador</h3>
            <div class="form-grid" style="margin-top: 1.25rem;">
                <div>
                    <span class="form-label">Disponibilidad</span>
                    <p>Información gestionada por el sistema.</p>
                </div>
                <div>
                    <span class="form-label">Experiencia</span>
                    <p>Información registrada en el perfil.</p>
                </div>
                <div>
                    <span class="form-label">Zona de cobertura</span>
                    <p>Información asociada a las rutas asignables.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-bottom">
            <span>Urban Paws</span>
            <span>Espacio del paseador</span>
        </div>
    </div>
</footer>

</body>
</html>
