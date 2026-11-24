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
    9 => 'vmasmas.php',
    11 => 'modvserv/vserrutcl.php', 12 => 'modvserv/vserrutps.php',
    13 => 'modvserv/vserpas.php', 14 => 'modvserv/vserserps.php',
    15 => 'modvserv/vsersercl.php',
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

  <?php
    $pg = isset($_GET["pg"]) ? $_GET["pg"] : 1;
    
    //Modulo Usuario
    if($pg==1) include 'views/vusucli.php';
    elseif ($pg==2) include 'views/vusuadmin.php';
    elseif ($pg==3) include 'views/vusupas.php';
    elseif ($pg==4) include 'views/vusupef.php';
    elseif ($pg==5) include 'views/vusulisusu.php';
    elseif ($pg==6) include 'views/vusuval.php';
    elseif ($pg==7) include 'views/vusudatper.php';
    elseif ($pg==8) include 'views/vusuubi.php';
    //Modulo Mascotas
    elseif ($pg==9) include 'views/vmasmas.php';
    //Modulo servicios
    elseif ($pg==11) include './views/modvserv/vserrutcl.php'; // V-rut cliente 
    elseif ($pg==12) include './views/modvserv/vserrutps.php'; // V-rut paseador
    elseif ($pg==13) include './views/modvserv/vserpas.php'; // V-paseo
    elseif ($pg==14) include './views/modvserv/vserserps.php'; // serv paseador 
    elseif ($pg==15) include './views/modvserv/vsersercl.php'; // serv cliente 
    elseif ($pg==01) include './views/modvserv//vserrepser.php'; // ?
    //Modulo factura
    elseif ($pg==17) include 'views/vfacfac.php';
    elseif ($pg==18) include 'views/vfatdatfac.php';
    elseif ($pg==19) include 'views/vfaclisfac.php';
    elseif ($pg==20) include 'views/vfacrepfac.php';
    //Modulo PQRS
    elseif ($pg==21) include 'views/vreppqr.php';
    elseif ($pg==22) include 'views/vreplispqr.php';
    //Modulo Configuracion
    elseif ($pg==23) include 'views/vcofpag.php';
    elseif ($pg==24) include 'views/vcofmod.php';
    elseif ($pg==25) include 'views/vcofcof.php';
    elseif ($pg==26) include 'views/vcofdom.php';
    elseif ($pg==27) include 'views/vcofval.php';
    //Modulo externo
    elseif ($pg==28) include 'views/vextregis.php';
    elseif ($pg==29) include 'views/vextini.php';
    elseif ($pg==30) include 'views/vextreccon.php';
    elseif ($pg==31) include 'views/vextolv.php';
  ?>

  <?php include 'views/footer.php'; ?>
  <script src="js/auth-toggle.js"></script>
  <script src="js/mytable.js"></script>
</body>
</html>
