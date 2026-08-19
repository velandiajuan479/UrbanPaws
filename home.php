<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['iduser'])) {
    header("Location: index.php");
    exit;
}

require_once('models/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UrbanPaws — Panel Principal</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">
  
</head>
<body>
  <?php include'views/header.php'; ?>

  <section class="menu">
    <?php include 'views/vmen.php'; ?>
  </section>

  <div class="container mt-4">
    <div class="row">
      <div class="col-12">
        <h2 class="mb-4">Bienvenido al Panel Principal</h2>
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card text-center p-3">
              <i class="bi bi-person-circle fa-3x text-primary mb-2"></i>
              <h5>Clientes</h5>
              <a href="home.php?pg=1" class="btn btn-sm btn-primary">Ir</a>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-center p-3">
              <i class="bi bi-shield-lock fa-3x text-success mb-2"></i>
              <h5>Administrador</h5>
              <a href="home.php?pg=2" class="btn btn-sm btn-success">Ir</a>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-center p-3">
              <i class="bi bi-heart fa-3x text-danger mb-2"></i>
              <h5>Paseadores</h5>
              <a href="home.php?pg=3" class="btn btn-sm btn-danger">Ir</a>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card text-center p-3">
              <i class="bi bi-gear fa-3x text-warning mb-2"></i>
              <h5>Configuración</h5>
              <a href="home.php?pg=25" class="btn btn-sm btn-warning">Ir</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    $pg = isset($_GET["pg"]) ? $_GET["pg"] : NULL;
    
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
    elseif ($pg==11) include 'views/vserrut.php';
    elseif ($pg==12) include 'views/vserlisrut.php';
    elseif ($pg==13) include 'views/vserpas.php';
    elseif ($pg==14) include 'views/vserser.php';
    elseif ($pg==15) include 'views/vserlisser.php';
    elseif ($pg==16) include 'views/vserrepser.php';
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

  <?php include 'views/footer.php'; ?>
  <script src="js/mytable.js"></script>
</body>
</html>
