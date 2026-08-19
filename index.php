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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/3.0.1/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">
  
  <style>
    /* Estilos específicos para index.php usando variables del design system */
    body {
      background-color: var(--bg-light);
      font-family: 'Nunito', sans-serif;
    }
    
    .welcome-title {
      color: var(--brand-dark);
      font-family: 'Poppins', sans-serif;
      font-weight: 700;
    }
    
    .welcome-lead {
      color: var(--text-muted);
      font-size: 1.1rem;
    }
    
    /* Pestañas con colores corporativos */
    .nav-tabs .nav-link {
      color: var(--brand-dark);
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link:hover {
      color: var(--brand-primary);
      background-color: rgba(44, 95, 138, 0.05);
    }
    
    .nav-tabs .nav-link.active {
      color: var(--brand-primary);
      background-color: #fff;
      border-bottom: 3px solid var(--brand-accent);
    }
    
    .nav-tabs .nav-link i {
      color: var(--brand-accent);
      margin-right: 8px;
    }
    
    .nav-tabs {
      border-bottom: 2px solid var(--border-light);
    }
    
    /* Contenedor principal */
    .container.py-5 {
      background: linear-gradient(135deg, rgba(26, 58, 92, 0.03) 0%, rgba(44, 95, 138, 0.05) 100%);
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
  </style>
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
          <h1 class="welcome-title">Bienvenido a UrbanPaws</h1>
          <p class="lead welcome-lead">Tu espacio personal para el cuidado de mascotas</p>
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
