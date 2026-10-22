<?php
$currentPg = isset($currentPg) ? (int) $currentPg : (isset($_GET['pg']) ? (int) $_GET['pg'] : 1);
$displayName = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? ''));
$displayName = $displayName !== '' ? $displayName : 'Mi cuenta';
$displayRole = trim((string) ($_SESSION['nomperf'] ?? ''));
$initial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($displayName, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($displayName, 0, 1));
$navGroups = [
    'servicios' => [11, 13, 14],
    'facturacion' => [17, 18, 19, 20],
    'gestion' => [2, 3, 4, 5, 6, 7, 8, 23, 24, 25, 26, 27],
];
$serviceActive = in_array($currentPg, $navGroups['servicios'], true);
$billingActive = in_array($currentPg, $navGroups['facturacion'], true);
$managementActive = in_array($currentPg, $navGroups['gestion'], true);
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
                        <li><a class="dropdown-item" href="home.php?pg=13"><i class="fa-solid fa-person-walking" aria-hidden="true"></i>Agendar paseo</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=14"><i class="fa-solid fa-list-check" aria-hidden="true"></i>Solicitudes de paseo</a></li>
                    </ul>
                </li>
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
                        <li><a class="dropdown-item" href="home.php?pg=26"><i class="fa-solid fa-tags" aria-hidden="true"></i>Dominios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=27"><i class="fa-solid fa-list-ol" aria-hidden="true"></i>Valores</a></li>
                    </ul>
                </li>
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
                    <li><a class="dropdown-item" href="home.php?pg=4"><i class="fa-solid fa-id-card" aria-hidden="true"></i>Mi perfil</a></li>
                    <li><a class="dropdown-item" href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a></li>
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
                <li class="mobile-caption">Servicios y facturación</li>
                <li><a class="nav-link <?= $serviceActive ? 'is-active' : '' ?>" href="home.php?pg=11"><i class="fa-solid fa-route" aria-hidden="true"></i>Rutas disponibles</a></li>
                <li><a class="nav-link <?= $currentPg === 13 ? 'is-active' : '' ?>" href="home.php?pg=13"><i class="fa-solid fa-person-walking" aria-hidden="true"></i>Agendar paseo</a></li>
                <li><a class="nav-link <?= $currentPg === 14 ? 'is-active' : '' ?>" href="home.php?pg=14"><i class="fa-solid fa-list-check" aria-hidden="true"></i>Solicitudes de paseo</a></li>
                <li><a class="nav-link <?= $billingActive ? 'is-active' : '' ?>" href="home.php?pg=19"><i class="fa-solid fa-file-invoice" aria-hidden="true"></i>Facturación</a></li>
                <li class="mobile-caption">Gestión · personas y cuentas</li>
                <li><a class="nav-link <?= $currentPg === 2 ? 'is-active' : '' ?>" href="home.php?pg=2"><i class="fa-solid fa-user-shield" aria-hidden="true"></i>Administradores</a></li>
                <li><a class="nav-link <?= $currentPg === 5 ? 'is-active' : '' ?>" href="home.php?pg=5"><i class="fa-solid fa-users" aria-hidden="true"></i>Usuarios</a></li>
                <li><a class="nav-link <?= $currentPg === 6 ? 'is-active' : '' ?>" href="home.php?pg=6"><i class="fa-solid fa-user-check" aria-hidden="true"></i>Validar paseadores</a></li>
                <li><a class="nav-link <?= $currentPg === 7 ? 'is-active' : '' ?>" href="home.php?pg=7&amp;iduser=<?= (int) ($_SESSION['iduser'] ?? 0) ?>"><i class="fa-solid fa-address-card" aria-hidden="true"></i>Datos personales</a></li>
                <li><a class="nav-link <?= $currentPg === 8 ? 'is-active' : '' ?>" href="home.php?pg=8"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ubicaciones</a></li>
                <li class="mobile-caption">Gestión · sistema</li>
                <li><a class="nav-link <?= $currentPg === 23 ? 'is-active' : '' ?>" href="home.php?pg=23"><i class="fa-solid fa-window-maximize" aria-hidden="true"></i>Páginas</a></li>
                <li><a class="nav-link <?= $currentPg === 24 ? 'is-active' : '' ?>" href="home.php?pg=24"><i class="fa-solid fa-cubes" aria-hidden="true"></i>Módulos</a></li>
                <li><a class="nav-link <?= $currentPg === 25 ? 'is-active' : '' ?>" href="home.php?pg=25"><i class="fa-solid fa-gear" aria-hidden="true"></i>Configuración</a></li>
                <li><a class="nav-link <?= $currentPg === 26 ? 'is-active' : '' ?>" href="home.php?pg=26"><i class="fa-solid fa-tags" aria-hidden="true"></i>Dominios</a></li>
                <li><a class="nav-link <?= $currentPg === 27 ? 'is-active' : '' ?>" href="home.php?pg=27"><i class="fa-solid fa-list-ol" aria-hidden="true"></i>Valores</a></li>
                <li class="mobile-caption">Tu cuenta</li>
                <li><a class="nav-link <?= $currentPg === 4 ? 'is-active' : '' ?>" href="home.php?pg=4"><i class="fa-solid fa-id-card" aria-hidden="true"></i>Mi perfil</a></li>
                <li><a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>Cerrar sesión</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="app-main" id="main-content" tabindex="-1">
    <div class="page-shell">
