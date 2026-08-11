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
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php
    $pg = isset($_GET["pg"]) ? $_GET["pg"]:NULL;
    include'views/header.php';
  ?>

    <section class="menu">
            <?php include 
                'views/vmen.php'; 
            ?>
    </section>
  <?php
    if($pg==1) include 'vusucli.php';
    elseif ($pg==2) include 'vusuadmin.php';
    elseif ($pg==3) include 'vusupas.php';
    elseif ($pg==4) include 'vusupef.php';
    elseif ($pg==5) include 'vusulisusu.php';
    elseif ($pg==6) include 'vusuval.php';
    elseif ($pg==7) include 'vusudatper.php';
    elseif ($pg==8) include 'vusuubi.php';
    elseif ($pg==9) include 'vmasmas.php';
    elseif ($pg==10) include 'vmasdue.php';
    elseif ($pg==11) include 'vserrut.php';
    elseif ($pg==12) include 'vserlisrut.php';
    elseif ($pg==13) include 'vserpas.php';
    elseif ($pg==14) include 'vserser.php';
    elseif ($pg==15) include 'vserlisser.php';
    elseif ($pg==16) include 'vserrepser.php';
    elseif ($pg==17) include 'vfacfac.php';
    elseif ($pg==18) include 'vfatdatfac.php';
    elseif ($pg==19) include 'vfaclisfac.php';
    elseif ($pg==20) include 'vfacrepfac.php';
    elseif ($pg==21) include 'vreppqr.php|';
    elseif ($pg==22) include 'vreplispqr.php';
    elseif ($pg==23) include 'vcofpag.php';
    elseif ($pg==24) include 'vcofmod.php';
    elseif ($pg==25) include 'vcofcof.php';
    elseif ($pg==26) include 'vcofdom.php';
    elseif ($pg==27) include 'vcofval.php';
    elseif ($pg==28) include 'vextregis.php';
    elseif ($pg==29) include 'vextini.php';
    elseif ($pg==30) include 'vextreccon.php';
    elseif ($pg==31) include 'vextolv.php';
  ?>





  <?php include
    'views/footer.php';
  ?>