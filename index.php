<?php 
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UrbanPaws — Mi Espacio Personal</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">
  
</head>
<body>
  <?php
  require_once('models/conexion.php');
    $pg = isset($_GET["pg"]) ? $_GET["pg"]:NULL;
    include'views/header.php';

  ?>

    <section class="menu">
            <?php include 
                'views/vmen.php'; 
            ?>
    </section>
  <?php
    if($pg==1) include 'views/vusucli.php';
    elseif ($pg==2) include 'views/vusuadmin.php';
    elseif ($pg==3) include 'views/vusupas.php';
    elseif ($pg==4) include 'views/vusupef.php';
    elseif ($pg==5) include 'views/vusulisusu.php';
    elseif ($pg==6) include 'views/vusuval.php';
    elseif ($pg==7) include 'views/vusudatper.php';
    elseif ($pg==8) include 'views/vusuubi.php';
    elseif ($pg==9) include 'views/vmasmas.php';
    elseif ($pg==10) include 'views/vmasdue.php';
    elseif ($pg==11) include 'views/vserrutcl.php'; // vista ruta cliente 
    elseif ($pg==32) include 'views/vserrutps.php'; // nueva vista / vista ruta paceador

    elseif ($pg==13) include 'views/vserpas.php'; // vista paseo
    elseif ($pg==14) include 'views/vsersercl.php'; // vista servicio cliente
    elseif ($pg==15) include 'views/vserserps.php'; // vista servicio paseador

    elseif ($pg==17) include 'views/vfacfac.php';
    elseif ($pg==18) include 'views/vfatdatfac.php';
    elseif ($pg==19) include 'views/vfaclisfac.php';
    elseif ($pg==20) include 'views/vfacrepfac.php';
    elseif ($pg==21) include 'views/vreppqr.php|';
    elseif ($pg==22) include 'views/vreplispqr.php';
    elseif ($pg==23) include 'views/vcofpag.php';
    elseif ($pg==24) include 'views/vcofmod.php';
    elseif ($pg==25) include 'views/vcofcof.php';
    elseif ($pg==26) include 'views/vcofdom.php';
    elseif ($pg==27) include 'views/vcofval.php';
    elseif ($pg==28) include 'views/vextregis.php';
    elseif ($pg==29) include 'views/vextini.php';
    elseif ($pg==30) include 'views/vextreccon.php';
    elseif ($pg==31) include 'views/vextolv.php';
  ?>

  <?php include
    'views/footer.php';
  ?>
<script src="js/mytable.js"></script>
</body>
</html>