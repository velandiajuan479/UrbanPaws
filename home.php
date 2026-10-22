<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

$pg = isset($_GET['pg']) ? (int) $_GET['pg'] : 1;
$currentPg = $pg;
require_once __DIR__ . '/models/conexion.php';
$pageTitles = [
    1 => 'Inicio', 2 => 'Administradores', 3 => 'Paseador', 4 => 'Mi perfil',
    5 => 'Usuarios', 6 => 'Validación de paseadores', 7 => 'Datos personales',
    8 => 'Ubicaciones', 9 => 'Mascotas', 10 => 'Dueños de mascotas',
    11 => 'Rutas disponibles', 12 => 'Listado de rutas', 13 => 'Agendar paseo',
    14 => 'Solicitudes de paseo', 15 => 'Servicios', 16 => 'Reporte de servicios',
    17 => 'Nueva factura', 18 => 'Detalle de factura', 19 => 'Facturas',
    20 => 'Reporte de facturas', 21 => 'PQRSF', 22 => 'Solicitudes PQRSF',
    23 => 'Páginas', 24 => 'Módulos', 25 => 'Configuración del sistema',
    26 => 'Dominios', 27 => 'Valores', 28 => 'Registro', 29 => 'Acceso',
    30 => 'Actualizar contraseña', 31 => 'Recuperar contraseña',
];
$documentTitle = 'UrbanPaws — ' . ($pageTitles[$pg] ?? 'Panel');
$pageViews = [
    1 => 'vusucli.php', 2 => 'vusuadmin.php', 3 => 'vusupas.php', 4 => 'vusupef.php',
    5 => 'vusulisusu.php', 6 => 'vusuval.php', 7 => 'vusudatper.php', 8 => 'vusuubi.php',
    9 => 'vmasmas.php', 11 => 'vserrutcl.php', 13 => 'vserpas.php', 14 => 'vserserps.php',
    17 => 'vfacfac.php', 18 => 'vfatdatfac.php', 19 => 'vfaclisfac.php', 20 => 'vfacrepfac.php',
    23 => 'vcofpag.php', 24 => 'vcofmod.php', 25 => 'vcofcof.php',
    26 => 'vcofdom.php', 27 => 'vcofval.php',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#20372d">
    <meta name="description" content="Panel UrbanPaws: gestiona el cuidado, los paseos y los servicios para mascotas.">
    <title><?= htmlspecialchars($documentTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" type="image/png" sizes="64x64" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
    <?php include __DIR__ . '/views/header.php'; ?>

    <?php if (isset($pageViews[$pg]) && is_file(__DIR__ . '/views/' . $pageViews[$pg])): ?>
        <?php include __DIR__ . '/views/' . $pageViews[$pg]; ?>
    <?php else: ?>
        <section class="card" style="max-width: 700px; margin: 2rem auto; text-align: center;">
            <span class="icon-circle" style="margin: 0 auto 1rem;"><i class="fa-solid fa-leaf" aria-hidden="true"></i></span>
            <span class="eyebrow">En preparación</span>
            <h1><?= htmlspecialchars($pageTitles[$pg] ?? 'Página no encontrada', ENT_QUOTES, 'UTF-8') ?></h1>
            <p>Este espacio todavía no está disponible. Puedes volver al inicio y continuar desde allí.</p>
            <a class="btn btn-primary" href="home.php?pg=1">Volver al inicio</a>
        </section>
    <?php endif; ?>

    <?php include __DIR__ . '/views/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/mytable.js"></script>
    <script src="js/autocomplete.js"></script>
</body>
</html>
