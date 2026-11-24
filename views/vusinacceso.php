<?php
$paginaSolicitada = isset($pg) ? (int) $pg : 0;
$tituloSolicitado = isset($pageTitles[$paginaSolicitada]) ? $pageTitles[$paginaSolicitada] : 'esta página';
$rolActual = function_exists('up_permisos') ? up_permisos()->getNombreRol() : '';
$rolActual = $rolActual !== '' ? $rolActual : 'tu perfil';
$destinoInicio = function_exists('up_dashboard') ? (int) up_dashboard() : 1;
?>
<section class="card acceso-denegado" aria-labelledby="acceso-denegado">
    <span class="icon-circle" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
    <span class="eyebrow">Acceso restringido</span>
    <h1 id="acceso-denegado">No tienes acceso a <?= htmlspecialchars($tituloSolicitado, ENT_QUOTES, 'UTF-8') ?></h1>
    <p>
        Tu perfil (<?= htmlspecialchars($rolActual, ENT_QUOTES, 'UTF-8') ?>) no tiene habilitada esta página.
        Si crees que se trata de un error, solicita al administrador que revise la matriz de páginas por perfil.
    </p>
    <a class="btn btn-primary" href="home.php?pg=<?= $destinoInicio ?>">Ir a mi inicio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
</section>
