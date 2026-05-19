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


  <?php
    if($pg==1) include 'views/mascotas.php';
    elseif ($pg==2) include 'views/configuracion.php';
    elseif ($pg==3) include 'views/modulo.php';
    elseif ($pg==4) include 'views/pagina.php';
  ?>





  <?php include
    'views/footer.php';
  ?>