<?php
$currentPg = isset($currentPg) ? (int) $currentPg : (isset($_GET['pg']) ? (int) $_GET['pg'] : 1);
$displayName = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? ''));
$displayName = $displayName !== '' ? $displayName : 'Mi cuenta';
$displayRole = trim((string) ($_SESSION['nomperf'] ?? ''));
if ($displayRole === '' && function_exists('up_permisos')) {
    $displayRole = up_permisos()->getNombreRol();
}
$initial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($displayName, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($displayName, 0, 1));

// El menú se construye con la misma matriz que usa el enrutador.
$tieneAcceso = function ($pagina) {
    return function_exists('up_puede_ver') ? up_puede_ver((int) $pagina) : true;
};
$esActivo = function ($pagina) use ($currentPg) {
    return (int) $pagina === $currentPg;
};

$navEnlaces = array();
$navEnlaces[] = array('pg' => 1, 'icono' => 'fa-solid fa-house', 'etiqueta' => 'Inicio', 'href' => 'home.php?pg=1');
if ($tieneAcceso(9)) {
    $navEnlaces[] = array('pg' => 9, 'icono' => 'fa-solid fa-paw', 'etiqueta' => 'Mascotas', 'href' => 'home.php?pg=9');
}

$navGrupos = array();
// Los enlaces de servicios se muestran según el permiso del perfil. El paseador
// los conserva porque son parte de su flujo de trabajo; cuando se corrija el
// módulo de servicios volverán a funcionar sin cambiar este menú.
$mostrarServiciosPaseador = function_exists('up_permisos') && up_permisos()->esPaseador();
$gruposDefinidos = array(
    array(
        'id' => 'servicios-menu',
        'icono' => 'fa-solid fa-route',
        'etiqueta' => 'Servicios',
        'cabecera' => 'Paseos y cuidado',
        'paginas' => array(
            11 => array('icono' => 'fa-solid fa-map-location-dot', 'etiqueta' => 'Rutas disponibles'),
            13 => array('icono' => 'fa-solid fa-person-walking', 'etiqueta' => 'Agendar paseo'),
            14 => array('icono' => 'fa-solid fa-list-check', 'etiqueta' => 'Solicitudes de paseo'),
        ),
        'visible' => $mostrarServiciosPaseador,
    ),
    array(
        'id' => 'facturacion-menu',
        'icono' => 'fa-solid fa-receipt',
        'etiqueta' => 'Facturación',
        'cabecera' => 'Documentos y pagos',
        'paginas' => array(
            17 => array('icono' => 'fa-solid fa-file-circle-plus', 'etiqueta' => 'Nueva factura'),
            19 => array('icono' => 'fa-solid fa-file-invoice', 'etiqueta' => 'Listado de facturas'),
            18 => array('icono' => 'fa-solid fa-list', 'etiqueta' => 'Detalle de factura'),
            20 => array('icono' => 'fa-solid fa-chart-column', 'etiqueta' => 'Reporte de facturas'),
        ),
    ),
    array(
        'id' => 'gestion-menu',
        'icono' => 'fa-solid fa-sliders',
        'etiqueta' => 'Gestión',
        'cabecera' => 'Personas y sistema',
        'paginas' => array(
            2 => array('icono' => 'fa-solid fa-user-shield', 'etiqueta' => 'Administradores'),
            5 => array('icono' => 'fa-solid fa-users', 'etiqueta' => 'Usuarios'),
            6 => array('icono' => 'fa-solid fa-user-check', 'etiqueta' => 'Validar paseadores'),
            8 => array('icono' => 'fa-solid fa-location-dot', 'etiqueta' => 'Ubicaciones'),
            23 => array('icono' => 'fa-solid fa-window-maximize', 'etiqueta' => 'Páginas'),
            24 => array('icono' => 'fa-solid fa-cubes', 'etiqueta' => 'Módulos'),
            25 => array('icono' => 'fa-solid fa-gear', 'etiqueta' => 'Configuración'),
            26 => array('icono' => 'fa-solid fa-tags', 'etiqueta' => 'Dominios'),
            27 => array('icono' => 'fa-solid fa-list-ol', 'etiqueta' => 'Valores'),
        ),
    ),
);

foreach ($gruposDefinidos as $grupo) {
    $items = array();
    foreach ($grupo['paginas'] as $pagina => $item) {
        // El paseador ve el grupo completo de servicios aunque el enrutador
        // bloquee temporalmente las páginas con SQL pendiente de corregir.
        if (!$tieneAcceso($pagina) && !($mostrarServiciosPaseador && $grupo['id'] === 'servicios-menu')) {
            continue;
        }
        $items[] = array(
            'pg' => (int) $pagina,
            'icono' => $item['icono'],
            'etiqueta' => $item['etiqueta'],
            'href' => 'home.php?pg=' . (int) $pagina,
        );
    }
    if (count($items) === 0) {
        continue;
    }
    if (count($items) === 1) {
        $navEnlaces[] = $items[0];
        continue;
    }
    $grupo['items'] = $items;
    $grupo['pages'] = array_column($items, 'pg');
    $navGrupos[] = $grupo;
}
?>
<a class="skip-link" href="#main-content">Saltar al contenido</a>
<header class="barsup">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="logo-container" href="home.php?pg=1" aria-label="UrbanPaws, inicio">
            <span class="logo-icon"><img class="logo-img" src="img/logo-web.png" alt=""></span>
            <span>
                <h5 class="mb-0 fw-bold">UrbanPaws</h5>
                <small class="d-none d-md-block">Cuidado en cada paso</small>
            </span>
        </a>

        <nav aria-label="Navegación principal">
            <ul class="nav">
                <?php foreach ($navEnlaces as $item) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $esActivo($item['pg']) ? 'is-active' : '' ?>" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>" <?= $esActivo($item['pg']) ? 'aria-current="page"' : '' ?>>
                            <i class="<?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i><?= htmlspecialchars($item['etiqueta'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php } ?>
                <?php foreach ($navGrupos as $grupo) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= in_array($currentPg, $grupo['pages'], true) ? 'is-active' : '' ?>" href="#<?= htmlspecialchars($grupo['id'], ENT_QUOTES, 'UTF-8') ?>" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="<?= htmlspecialchars($grupo['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i><?= htmlspecialchars($grupo['etiqueta'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <ul class="dropdown-menu" id="<?= htmlspecialchars($grupo['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <li><span class="dropdown-header"><?= htmlspecialchars($grupo['cabecera'], ENT_QUOTES, 'UTF-8') ?></span></li>
                            <?php foreach ($grupo['items'] as $item) { ?>
                                <li><a class="dropdown-item" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"><i class="<?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i><?= htmlspecialchars($item['etiqueta'], ENT_QUOTES, 'UTF-8') ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="user-menu" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menú de <?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?>">
                    <span class="user-avatar" aria-hidden="true"><?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="user-meta">
                        <strong><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></strong>
                        <small><?= htmlspecialchars($displayRole !== '' ? $displayRole : 'Cuenta UrbanPaws', ENT_QUOTES, 'UTF-8') ?></small>
                    </span>
                    <i class="fa-solid fa-chevron-down d-none d-sm-inline" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-header">Tu espacio</span></li>
                    <?php if ($tieneAcceso(4)) { ?>
                        <li><a class="dropdown-item" href="home.php?pg=4"><i class="fa-solid fa-id-card" aria-hidden="true"></i>Mi perfil</a></li>
                    <?php } ?>
                    <?php if ($tieneAcceso(7)) { ?>
                        <li><a class="dropdown-item" href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a></li>
                    <?php } ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>Cerrar sesión</a></li>
                </ul>
            </div>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Abrir navegación">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="collapse mobile-menu" id="mobileMenu">
        <nav class="container py-3" aria-label="Navegación móvil">
            <ul class="nav flex-column">
                <?php foreach ($navEnlaces as $item) { ?>
                    <li><a class="nav-link <?= $esActivo($item['pg']) ? 'is-active' : '' ?>" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"><i class="<?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i><?= htmlspecialchars($item['etiqueta'], ENT_QUOTES, 'UTF-8') ?></a></li>
                <?php } ?>
                <?php foreach ($navGrupos as $grupo) { ?>
                    <li>
                        <details <?= in_array($currentPg, $grupo['pages'], true) ? 'open' : '' ?>>
                            <summary class="mobile-caption"><?= htmlspecialchars($grupo['etiqueta'], ENT_QUOTES, 'UTF-8') ?></summary>
                            <?php foreach ($grupo['items'] as $item) { ?>
                                <a class="nav-link <?= $esActivo($item['pg']) ? 'is-active' : '' ?>" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"><i class="<?= htmlspecialchars($item['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i><?= htmlspecialchars($item['etiqueta'], ENT_QUOTES, 'UTF-8') ?></a>
                            <?php } ?>
                        </details>
                    </li>
                <?php } ?>
                <li>
                    <details <?= ($currentPg === 4 || $currentPg === 7) ? 'open' : '' ?>>
                        <summary class="mobile-caption">Tu cuenta</summary>
                        <?php if ($tieneAcceso(4)) { ?>
                            <a class="nav-link <?= $currentPg === 4 ? 'is-active' : '' ?>" href="home.php?pg=4"><i class="fa-solid fa-id-card" aria-hidden="true"></i>Mi perfil</a>
                        <?php } ?>
                        <?php if ($tieneAcceso(7)) { ?>
                            <a class="nav-link <?= $currentPg === 7 ? 'is-active' : '' ?>" href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a>
                        <?php } ?>
                        <a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>Cerrar sesión</a>
                    </details>
                </li>
            </ul>
        </nav>
    </div>
</header>
<main class="app-main" id="main-content" tabindex="-1">
    <div class="page-shell">
