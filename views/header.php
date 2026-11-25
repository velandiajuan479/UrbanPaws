<?php
$currentPg = isset($currentPg) ? (int) $currentPg : (isset($_GET['pg']) ? (int) $_GET['pg'] : 1);
$displayName = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? ''));
$displayName = $displayName !== '' ? $displayName : 'Mi cuenta';
$displayRole = trim((string) ($_SESSION['nomperf'] ?? ''));
if ($displayRole === '' && function_exists('up_permisos')) {
    $displayRole = up_permisos()->getNombreRol();
}
$tieneAcceso = static function ($pg) {
    return function_exists('up_puede_ver') && up_puede_ver($pg);
};
$navEnlaces = $navEnlaces ?? [];
$navGrupos = $navGrupos ?? [];
$initial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($displayName, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($displayName, 0, 1));
$puedeGestionarRutas = $displayRole !== ''
    && (stripos($displayRole, 'Paseador') !== false || stripos($displayRole, 'Admin') !== false);
$puedeVerSolicitudes = $puedeGestionarRutas;
$navGroups = [
    'servicios' => [11, 12, 13, 14, 15],
    'facturacion' => [17, 18, 19, 20],
    'gestion' => [2, 3, 4, 5, 6, 7, 8, 23, 24, 25, 26, 27],
    'pqrs' => [21, 22],
];
$serviceActive = in_array($currentPg, $navGroups['servicios'], true);
$billingActive = in_array($currentPg, $navGroups['facturacion'], true);
$managementActive = in_array($currentPg, $navGroups['gestion'], true);
$pqrsActive = in_array($currentPg, $navGroups['pqrs'], true);
$nomPerfHeader = strtolower($displayRole);
$esAdminHeader = strpos($nomPerfHeader, 'admin') !== false;
$puedeRadicarHeader = strpos($nomPerfHeader, 'cliente') !== false || strpos($nomPerfHeader, 'paseador') !== false;
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
                <li class="nav-item">
                    <a class="nav-link <?= $currentPg === 1 ? 'is-active' : '' ?>" href="home.php?pg=1" <?= $currentPg === 1 ? 'aria-current="page"' : '' ?>>
                        <i class="fa-solid fa-house" aria-hidden="true"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPg === 9 ? 'is-active' : '' ?>" href="home.php?pg=9" <?= $currentPg === 9 ? 'aria-current="page"' : '' ?>>
                        <i class="fa-solid fa-paw" aria-hidden="true"></i>Mascotas
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $serviceActive ? 'is-active' : '' ?>" href="#servicios-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-route" aria-hidden="true"></i>Servicios
                    </a>
                    <ul class="dropdown-menu" id="servicios-menu">
                        <li><span class="dropdown-header">Paseos y cuidado</span></li>
                        <li><a class="dropdown-item" href="home.php?pg=11"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>Rutas disponibles</a></li>
                        <?php if ($puedeGestionarRutas) { ?>
                            <li><a class="dropdown-item" href="home.php?pg=12"><i class="fa-solid fa-list" aria-hidden="true"></i>Listado de rutas</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="home.php?pg=13"><i class="fa-solid fa-person-walking" aria-hidden="true"></i>Agendar paseo</a></li>
                        <?php if ($puedeVerSolicitudes) { ?>
                            <li><a class="dropdown-item" href="home.php?pg=14"><i class="fa-solid fa-list-check" aria-hidden="true"></i>Solicitudes de paseo</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="home.php?pg=15"><i class="fa-solid fa-concierge-bell" aria-hidden="true"></i>Servicios</a></li>
                    </ul>
                </li>
                <?php if ($puedeRadicarHeader || $esAdminHeader) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $pqrsActive ? 'is-active' : '' ?>" href="#pqrs-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-comments" aria-hidden="true"></i>PQRS
                    </a>
                    <ul class="dropdown-menu" id="pqrs-menu">
                        <li><span class="dropdown-header">Radicación y seguimiento</span></li>
                        <?php if ($puedeRadicarHeader) { ?>
                            <li><a class="dropdown-item" href="home.php?pg=21"><i class="fa-solid fa-message" aria-hidden="true"></i>Radicar PQRSF</a></li>
                        <?php } ?>
                        <?php if ($esAdminHeader) { ?>
                            <li><a class="dropdown-item" href="home.php?pg=22"><i class="fa-solid fa-inbox" aria-hidden="true"></i>PQRFS</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $billingActive ? 'is-active' : '' ?>" href="#facturacion-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-receipt" aria-hidden="true"></i>Facturación
                    </a>
                    <ul class="dropdown-menu" id="facturacion-menu">
                        <li><span class="dropdown-header">Documentos y pagos</span></li>
                        <li><a class="dropdown-item" href="home.php?pg=17"><i class="fa-solid fa-file-circle-plus" aria-hidden="true"></i>Nueva factura</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=19"><i class="fa-solid fa-file-invoice" aria-hidden="true"></i>Listado de facturas</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=18"><i class="fa-solid fa-list" aria-hidden="true"></i>Detalle de factura</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=20"><i class="fa-solid fa-chart-column" aria-hidden="true"></i>Reporte de facturas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $managementActive ? 'is-active' : '' ?>" href="#gestion-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-sliders" aria-hidden="true"></i>Gestión
                    </a>
                    <ul class="dropdown-menu" id="gestion-menu">
                        <li><span class="dropdown-header">Personas y cuentas</span></li>
                        <li><a class="dropdown-item" href="home.php?pg=2"><i class="fa-solid fa-user-shield" aria-hidden="true"></i>Administradores</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=5"><i class="fa-solid fa-users" aria-hidden="true"></i>Usuarios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=6"><i class="fa-solid fa-user-check" aria-hidden="true"></i>Validar paseadores</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=7"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=8"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ubicaciones</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><span class="dropdown-header">Sistema</span></li>
                        <li><a class="dropdown-item" href="home.php?pg=23"><i class="fa-solid fa-window-maximize" aria-hidden="true"></i>Páginas</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=24"><i class="fa-solid fa-cubes" aria-hidden="true"></i>Módulos</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=25"><i class="fa-solid fa-gear" aria-hidden="true"></i>Configuración</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=25&amp;seccion=razas"><i class="fa-solid fa-paw" aria-hidden="true"></i>Razas de mascotas</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=26"><i class="fa-solid fa-tags" aria-hidden="true"></i>Dominios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=27"><i class="fa-solid fa-list-ol" aria-hidden="true"></i>Valores</a></li>
                    </ul>
                </li>
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
                <li><a class="nav-link <?= $currentPg === 1 ? 'is-active' : '' ?>" href="home.php?pg=1"><i class="fa-solid fa-house" aria-hidden="true"></i>Inicio</a></li>
                <li><a class="nav-link <?= $currentPg === 9 ? 'is-active' : '' ?>" href="home.php?pg=9"><i class="fa-solid fa-paw" aria-hidden="true"></i>Mascotas</a></li>
                <li>
                    <details <?= ($serviceActive || $billingActive) ? 'open' : '' ?>>
                        <summary class="mobile-caption">Servicios y facturación</summary>
                        <a class="nav-link <?= $currentPg === 11 ? 'is-active' : '' ?>" href="home.php?pg=11"><i class="fa-solid fa-route" aria-hidden="true"></i>Rutas disponibles</a>
                        <?php if ($puedeGestionarRutas) { ?>
                            <a class="nav-link <?= $currentPg === 12 ? 'is-active' : '' ?>" href="home.php?pg=12"><i class="fa-solid fa-list" aria-hidden="true"></i>Listado de rutas</a>
                        <?php } ?>
                        <a class="nav-link <?= $currentPg === 13 ? 'is-active' : '' ?>" href="home.php?pg=13"><i class="fa-solid fa-person-walking" aria-hidden="true"></i>Agendar paseo</a>
                        <?php if ($puedeVerSolicitudes) { ?>
                            <a class="nav-link <?= $currentPg === 14 ? 'is-active' : '' ?>" href="home.php?pg=14"><i class="fa-solid fa-list-check" aria-hidden="true"></i>Solicitudes de paseo</a>
                        <?php } ?>
                        <a class="nav-link <?= $currentPg === 15 ? 'is-active' : '' ?>" href="home.php?pg=15"><i class="fa-solid fa-concierge-bell" aria-hidden="true"></i>Servicios</a>
                        <a class="nav-link <?= $billingActive ? 'is-active' : '' ?>" href="home.php?pg=19"><i class="fa-solid fa-file-invoice" aria-hidden="true"></i>Facturación</a>
                    </details>
                </li>
                <?php if ($puedeRadicarHeader || $esAdminHeader) { ?>
                <li>
                    <details <?= $pqrsActive ? 'open' : '' ?>>
                        <summary class="mobile-caption">PQRS</summary>
                        <?php if ($puedeRadicarHeader) { ?>
                            <a class="nav-link <?= $currentPg === 21 ? 'is-active' : '' ?>" href="home.php?pg=21"><i class="fa-solid fa-message" aria-hidden="true"></i>Radicar PQRSF</a>
                        <?php } ?>
                        <?php if ($esAdminHeader) { ?>
                            <a class="nav-link <?= $currentPg === 22 ? 'is-active' : '' ?>" href="home.php?pg=22"><i class="fa-solid fa-inbox" aria-hidden="true"></i>PQRFS</a>
                        <?php } ?>
                    </details>
                </li>
                <?php } ?>
                <li>
                    <details <?= $managementActive ? 'open' : '' ?>>
                        <summary class="mobile-caption">Gestión</summary>
                        <a class="nav-link <?= $currentPg === 2 ? 'is-active' : '' ?>" href="home.php?pg=2"><i class="fa-solid fa-user-shield" aria-hidden="true"></i>Administradores</a>
                        <a class="nav-link <?= $currentPg === 5 ? 'is-active' : '' ?>" href="home.php?pg=5"><i class="fa-solid fa-users" aria-hidden="true"></i>Usuarios</a>
                        <a class="nav-link <?= $currentPg === 6 ? 'is-active' : '' ?>" href="home.php?pg=6"><i class="fa-solid fa-user-check" aria-hidden="true"></i>Validar paseadores</a>
                        <a class="nav-link <?= $currentPg === 7 ? 'is-active' : '' ?>" href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a>
                        <a class="nav-link <?= $currentPg === 8 ? 'is-active' : '' ?>" href="home.php?pg=8"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ubicaciones</a>
                        <a class="nav-link <?= $currentPg === 23 ? 'is-active' : '' ?>" href="home.php?pg=23"><i class="fa-solid fa-window-maximize" aria-hidden="true"></i>Páginas</a>
                        <a class="nav-link <?= $currentPg === 24 ? 'is-active' : '' ?>" href="home.php?pg=24"><i class="fa-solid fa-cubes" aria-hidden="true"></i>Módulos</a>
                        <a class="nav-link <?= $currentPg === 25 ? 'is-active' : '' ?>" href="home.php?pg=25"><i class="fa-solid fa-gear" aria-hidden="true"></i>Configuración</a>
                        <a class="nav-link <?= $currentPg === 25 && $seccionConfig ? 'is-active' : '' ?>" href="home.php?pg=25&amp;seccion=razas"><i class="fa-solid fa-paw" aria-hidden="true"></i>Razas de mascotas</a>
                        <a class="nav-link <?= $currentPg === 26 ? 'is-active' : '' ?>" href="home.php?pg=26"><i class="fa-solid fa-tags" aria-hidden="true"></i>Dominios</a>
                        <a class="nav-link <?= $currentPg === 27 ? 'is-active' : '' ?>" href="home.php?pg=27"><i class="fa-solid fa-list-ol" aria-hidden="true"></i>Valores</a>
                    </details>
                </li>
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
