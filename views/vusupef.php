<?php
$profileName = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? 'Usuario UrbanPaws'));
$profileEmail = (string) ($_SESSION['emailu'] ?? '');
$profileRole = trim((string) ($_SESSION['nomperf'] ?? ''));
$profileId = (int) ($_SESSION['iduser'] ?? 0);
$profileInitial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($profileName, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($profileName, 0, 1));
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Tu espacio personal</span>
        <h1>Mi perfil</h1>
        <p>Consulta la información básica vinculada a tu cuenta UrbanPaws.</p>
    </div>
</div>

<section class="profile-layout">
    <article class="card profile-card">
        <div class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($profileInitial, ENT_QUOTES, 'UTF-8') ?></div>
        <span class="badge badge-active"><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Sesión activa</span>
        <h2><?= htmlspecialchars($profileName, ENT_QUOTES, 'UTF-8') ?></h2>
        <p><?= htmlspecialchars($profileRole !== '' ? $profileRole : 'Cuenta UrbanPaws', ENT_QUOTES, 'UTF-8') ?></p>
        <div class="profile-divider"></div>
        <dl class="profile-details">
            <div><dt><i class="fa-solid fa-envelope" aria-hidden="true"></i>Correo</dt><dd><?= htmlspecialchars($profileEmail !== '' ? $profileEmail : 'Sin correo registrado', ENT_QUOTES, 'UTF-8') ?></dd></div>
            <div><dt><i class="fa-solid fa-fingerprint" aria-hidden="true"></i>Número de cuenta</dt><dd>#<?= $profileId ?></dd></div>
        </dl>
        <a href="home.php?pg=7&amp;iduser=<?= $profileId ?>" class="btn btn-primary w-100">Actualizar mis datos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    </article>

    <div class="profile-side">
        <section class="card profile-note">
            <span class="tile-icon"><i class="fa-solid fa-leaf" aria-hidden="true"></i></span>
            <span class="eyebrow">Cuidado a tu manera</span>
            <h2>La información al día hace más fácil cada visita.</h2>
            <p>Mantén actualizados tus datos de contacto para estar cerca de las novedades de tus servicios.</p>
        </section>
        <a href="home.php?pg=9&amp;iduser=<?= $profileId ?>" class="card profile-link-card">
            <span class="tile-icon"><i class="fa-solid fa-paw" aria-hidden="true"></i></span>
            <span><strong>Mis mascotas</strong><small>Ve a sus perfiles y detalles de cuidado.</small></span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
        <a href="home.php?pg=7&amp;iduser=<?= $profileId ?>" class="card profile-link-card">
            <span class="tile-icon"><i class="fa-solid fa-address-card" aria-hidden="true"></i></span>
            <span><strong>Datos personales</strong><small>Revisa tu información de contacto.</small></span>
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>
