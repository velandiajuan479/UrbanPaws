<?php
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paseador | Urban Paws</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<main class="container">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <div class="icon-circle">P</div>
            Paseador
        </div>

        <div class="card">
            <h1><i class="fa-solid fa-person-walking fa-lg"></i> Panel del paseador</h1>
            <p>Consulta tu información, disponibilidad y las actividades relacionadas con los servicios de paseo.</p>
        </div>
    </section>

    <section class="form-grid">
        <article class="card">
            <h3><i class="fa-solid fa-toggle-on fa-lg"></i> Estado de validación</h3>
            <p>Consulta el estado de validación de tu perfil como paseador.</p>
            <span class="badge badge-active">Estado pendiente de consulta</span>
        </article>

        <a href="vserpas.php" class="card">
            <h3><i class="fa-solid fa-location-dot fa-lg"></i> Mis paseos</h3>
            <p>Consulta los paseos asignados y el seguimiento de los servicios.</p>
            <span class="btn btn-primary">Ver paseos</span>
        </a>

        <a href="vserrutcl.php" class="card">
            <h3><i class="fa-solid fa-route fa-lg"></i> Rutas</h3>
            <p>Consulta las rutas disponibles y la información necesaria para realizar los servicios.</p>
            <span class="btn btn-primary">Ver rutas</span>
        </a>

        <a href="vserser.php" class="card">
            <h3><i class="fa-solid fa-concierge-bell fa-lg"></i> Servicios</h3>
            <p>Consulta los servicios relacionados con tu actividad como paseador.</p>
            <span class="btn btn-accent">Ver servicios</span>
        </a>

        <a href="vusupef.php" class="card">
            <h3><i class="fa-solid fa-image-portrait fa-lg"></i> Mi perfil</h3>
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
