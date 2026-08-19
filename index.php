<?php 
ob_start();
session_start();

// Si el usuario ya está logueado, redirigir a home.php
if (isset($_SESSION['iduser'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UrbanPaws — Inicio de Sesión y Registro</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwFLq61r9Xa9NmgBI0swA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
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
  $pg = isset($_GET["pg"]) ? $_GET["pg"] : NULL;
  ?>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="text-center mb-4">
          <h1>Bienvenido a UrbanPaws</h1>
          <p class="lead">Tu espacio personal para el cuidado de mascotas</p>
        </div>
        
        <!-- Pestañas para cambiar entre Login y Registro -->
        <ul class="nav nav-tabs mb-4" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
              <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="registro-tab" data-bs-toggle="tab" data-bs-target="#registro" type="button" role="tab">
              <i class="fa-solid fa-user-plus"></i> Registrarse
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="recuperar-tab" data-bs-toggle="tab" data-bs-target="#recuperar" type="button" role="tab">
              <i class="fa-solid fa-key"></i> Recuperar Contraseña
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="olvido-tab" data-bs-toggle="tab" data-bs-target="#olvido" type="button" role="tab">
              <i class="fa-solid fa-envelope"></i> ¿Olvidó su contraseña?
            </button>
          </li>
        </ul>
        
        <div class="tab-content" id="authTabsContent">
          <!-- Panel de Inicio de Sesión -->
          <div class="tab-pane fade show active" id="login" role="tabpanel">
            <?php include 'controllers/cextini.php'; ?>
          </div>
          
          <!-- Panel de Registro -->
          <div class="tab-pane fade" id="registro" role="tabpanel">
            <?php include 'controllers/cextregis.php'; ?>
          </div>
          
          <!-- Panel de Recuperar Contraseña -->
          <div class="tab-pane fade" id="recuperar" role="tabpanel">
            <?php include 'controllers/cextreccon.php'; ?>
          </div>
          
          <!-- Panel de Olvidó Contraseña -->
          <div class="tab-pane fade" id="olvido" role="tabpanel">
            <?php include 'controllers/cextolv.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
  // Activar la pestaña correcta según el parámetro pg
  document.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var pg = urlParams.get('pg');
    
    if (pg == '29') {
      var loginTab = new bootstrap.Tab(document.querySelector('#login-tab'));
      loginTab.show();
    } else if (pg == '28') {
      var registroTab = new bootstrap.Tab(document.querySelector('#registro-tab'));
      registroTab.show();
    } else if (pg == '30') {
      var recuperarTab = new bootstrap.Tab(document.querySelector('#recuperar-tab'));
      recuperarTab.show();
    } else if (pg == '31') {
      var olvidoTab = new bootstrap.Tab(document.querySelector('#olvido-tab'));
      olvidoTab.show();
    }
  });
  </script>
</body>
</html>
