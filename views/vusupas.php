<section class="welcome-panel" aria-labelledby="walker-welcome">
    <div>
        <span class="eyebrow">Tu espacio de paseador</span>
        <h1 id="walker-welcome">Cada paseo empieza con un buen cuidado.</h1>
        <p>Consulta la operación del día y mantén a mano la información de tus servicios.</p>
    </div>
    <div class="welcome-art" aria-hidden="true"><i class="fa-solid fa-person-walking"></i></div>
</section>

<section class="dashboard-grid" aria-label="Accesos del paseador">
    <a href="home.php?pg=14" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i></span>
        <h2>Solicitudes</h2>
        <p>Consulta y revisa las solicitudes de paseo recibidas.</p>
        <span class="tile-action">Ver solicitudes <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=11" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-route" aria-hidden="true"></i></span>
        <h2>Rutas</h2>
        <p>Consulta rutas, distancias, horarios y ubicaciones disponibles.</p>
        <span class="tile-action">Explorar rutas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-address-card" aria-hidden="true"></i></span>
        <h2>Mis datos</h2>
        <p>Actualiza la información de contacto asociada a tu cuenta.</p>
        <span class="tile-action">Editar información <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <a href="home.php?pg=19" class="card dashboard-card">
        <span class="tile-icon"><i class="fa-solid fa-receipt" aria-hidden="true"></i></span>
        <h2>Facturación</h2>
        <p>Consulta los documentos y movimientos registrados en el sistema.</p>
        <span class="tile-action">Ver facturación <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
    </a>
</section>
