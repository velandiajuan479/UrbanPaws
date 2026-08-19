<header class="py-0 barsup" style="background: linear-gradient(135deg, var(--brand-dark), var(--brand-primary));">
    <div class="container d-flex justify-content-between align-items-center">
        <?php $ins = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : NULL; ?>
        
        <!-- Logo -->
        <div class="logo-container py-2">
            <div class="logo-icon">
                <img class="logo-img" src="img/logo.png">
            </div>
            <div>
                <a href="home.php?pg=1"><h5 class="mb-0 fw-bold text-white">UrbanPaws</h5></a>
                <small class="opacity-75 d-none d-md-block text-white">
                    <?php if($ins){
                        echo isset($_SESSION["nomusr"]) ? $_SESSION["nomusr"] : "";
                    }else{ ?>
                        Tu espacio personal para mascotas
                    <?php } ?>
                </small>
            </div>
        </div>

        <!-- Navegación -->
        <nav class="d-none d-lg-block">
            <ul class="nav nav-pills">
                <!-- Módulo Usuarios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-users me-1"></i> Usuarios
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=2"><i class="fa-solid fa-user-shield me-2"></i>Administrador</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=3"><i class="fa-solid fa-user-lock me-2"></i>Contraseña</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=4"><i class="fa-solid fa-id-card me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=5"><i class="fa-solid fa-list me-2"></i>Listar Usuarios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=6"><i class="fa-solid fa-circle-check me-2"></i>Validar Usuario</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=7"><i class="fa-solid fa-address-card me-2"></i>Datos Personales</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=8"><i class="fa-solid fa-location-dot me-2"></i>Ubicación</a></li>
                    </ul>
                </li>

                <!-- Módulo Mascotas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-dog me-1"></i> Mascotas
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=9"><i class="fa-solid fa-paw me-2"></i>Mascota</a></li>
                    </ul>
                </li>

                <!-- Módulo Servicios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-briefcase me-1"></i> Servicios
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=11"><i class="fa-solid fa-route me-2"></i>Ruta</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=12"><i class="fa-solid fa-list-check me-2"></i>Listar Rutas</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=13"><i class="fa-solid fa-walkie-talkie me-2"></i>Paseo</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=14"><i class="fa-solid fa-concierge-bell me-2"></i>Servicio</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=15"><i class="fa-solid fa-clipboard-list me-2"></i>Listar Servicios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=16"><i class="fa-solid fa-file-invoice me-2"></i>Reporte Servicios</a></li>
                    </ul>
                </li>

                <!-- Módulo Factura -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-file-invoice-dollar me-1"></i> Facturas
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=17"><i class="fa-solid fa-cash-register me-2"></i>Factura</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=18"><i class="fa-solid fa-receipt me-2"></i>Datos Factura</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=19"><i class="fa-solid fa-file-lines me-2"></i>Listar Facturas</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=20"><i class="fa-solid fa-print me-2"></i>Reporte Factura</a></li>
                    </ul>
                </li>

                <!-- Módulo PQRS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-comments me-1"></i> PQRS
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=21"><i class="fa-solid fa-pen-to-square me-2"></i>Reportar PQR</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=22"><i class="fa-solid fa-folder-open me-2"></i>Listar PQR</a></li>
                    </ul>
                </li>

                <!-- Módulo Configuración -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="fa-solid fa-gear me-1"></i> Configuración
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="home.php?pg=23"><i class="fa-solid fa-credit-card me-2"></i>Página</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=24"><i class="fa-solid fa-sliders me-2"></i>Módulo</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=25"><i class="fa-solid fa-copy me-2"></i>Configuracion del sistema</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=26"><i class="fa-solid fa-map-location-dot me-2"></i>Dominios</a></li>
                        <li><a class="dropdown-item" href="home.php?pg=27"><i class="fa-solid fa-scale-balanced me-2"></i>Valores</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Cerrar Sesión -->
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-sm-block text-end">
                <?php if($ins){ ?>
                    <a href="logout.php" title="Cerrar Sesión" class="text-white hover-accent">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-lg" style="font-size: 1.2rem;"></i>
                    </a>
                <?php } ?>
            </div>
            
            <!-- Menú móvil -->
            <button class="navbar-toggler d-lg-none border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>
        </div>
    </div>

    <!-- Menú Móvil -->
    <div class="collapse navbar-collapse bg-light" id="mobileMenu">
        <div class="container py-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=1"><i class="fa-solid fa-user me-2"></i>Cliente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=2"><i class="fa-solid fa-user-shield me-2"></i>Administrador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=9"><i class="fa-solid fa-dog me-2"></i>Mascotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=11"><i class="fa-solid fa-route me-2"></i>Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=17"><i class="fa-solid fa-file-invoice-dollar me-2"></i>Facturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=21"><i class="fa-solid fa-comments me-2"></i>PQRS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=23"><i class="fa-solid fa-gear me-2"></i>Configuración</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?pg=28"><i class="fa-solid fa-cloud me-2"></i>Externo</a>
                </li>
                <?php if($ins){ ?>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Cerrar Sesión</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</header>