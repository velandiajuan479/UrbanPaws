<section class="welcome-panel" aria-labelledby="client-welcome">
    <div>
        <span class="eyebrow">Tu espacio UrbanPaws</span>
        <h1 id="client-welcome">Todo su cuidado, en un solo lugar.</h1>
        <p>Organiza sus paseos, mantén su información al día y encuentra los servicios que mejor acompañan su rutina.</p>
    </div>
    <div class="welcome-art" aria-hidden="true"><i class="fa-solid fa-paw"></i></div>
</section>

<section class="dashboard-grid" aria-label="Accesos principales">
    <a href="home.php?pg=9&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-paw" aria-hidden="true"></i></span>
        <h2>Mis mascotas</h2>
        <p>Consulta y actualiza sus datos, notas y documentos de cuidado.</p>
        <span class="tile-action">Ver mascotas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=11" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-route" aria-hidden="true"></i></span>
        <h2>Rutas</h2>
        <p>Explora las rutas y horarios disponibles para compartir un paseo.</p>
        <span class="tile-action">Explorar rutas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=14" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-person-walking" aria-hidden="true"></i></span>
        <h2>Mis paseos</h2>
        <p>Revisa las solicitudes y el estado de los paseos agendados.</p>
        <span class="tile-action">Ver paseos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=19" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-file-invoice" aria-hidden="true"></i></span>
        <h2>Facturación</h2>
        <p>Encuentra el historial de facturas relacionadas con tus servicios.</p>
        <span class="tile-action">Consultar facturas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-id-card" aria-hidden="true"></i></span>
        <h2>Mis datos</h2>
        <p>Mantén tus datos de contacto y ubicación al día.</p>
        <span class="tile-action">Editar información <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=4" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
        <h2>Mi perfil</h2>
        <p>Consulta la información básica de tu cuenta UrbanPaws.</p>
        <span class="tile-action">Abrir perfil <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
</section>
