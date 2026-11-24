<?php require_once("controllers/cusupas.php"); ?>

<section class="welcome-panel" aria-labelledby="walker-welcome">
    <div>
        <span class="eyebrow">Tu espacio de paseador</span>
        <h1 id="walker-welcome">Hola, <?= htmlspecialchars($pasNombre, ENT_QUOTES, 'UTF-8') ?>. Cada paseo empieza con un buen cuidado.</h1>
        <p>Consulta la operación de tus rutas, revisa las solicitudes pendientes y mantén tu información al día. <?= htmlspecialchars($pasRol, ENT_QUOTES, 'UTF-8') ?> · <?= date('d/m/Y') ?></p>
    </div>
    <div class="welcome-art" aria-hidden="true"><i class="fa-solid fa-person-walking"></i></div>
</section>

<?php if (!empty($errorPas)) { ?>
    <div class="alert alert-warning" role="alert"><?= htmlspecialchars($errorPas, ENT_QUOTES, 'UTF-8') ?></div>
<?php } ?>

<section class="pas-resumen" aria-label="Resumen de tu operación">
    <article class="card pas-stat">
        <span class="tile-icon"><i class="fa-solid fa-route" aria-hidden="true"></i></span>
        <span class="eyebrow">Tus rutas</span>
        <strong class="pas-stat-val"><?= (int) ($resumenPas['rutas'] ?? 0) ?></strong>
        <span class="pas-stat-nota">Rutas registradas a tu nombre</span>
    </article>
    <article class="card pas-stat">
        <span class="tile-icon"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i></span>
        <span class="eyebrow">Por revisar</span>
        <strong class="pas-stat-val"><?= (int) ($resumenPas['pendientes'] ?? 0) ?></strong>
        <span class="pas-stat-nota">Solicitudes pendientes de respuesta</span>
    </article>
    <article class="card pas-stat">
        <span class="tile-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>
        <span class="eyebrow">Paseos</span>
        <strong class="pas-stat-val"><?= (int) ($resumenPas['aceptados'] ?? 0) ?></strong>
        <span class="pas-stat-nota">
            <?= (int) ($resumenPas['terminados'] ?? 0) ?> terminados ·
            <?= (int) ($resumenPas['proximos'] ?? 0) ?> próximos
        </span>
    </article>
    <article class="card pas-stat">
        <span class="tile-icon"><i class="fa-solid fa-star" aria-hidden="true"></i></span>
        <span class="eyebrow">Calificación</span>
        <strong class="pas-stat-val"><?= $resumenPas['promedio'] !== NULL ? htmlspecialchars((string) $resumenPas['promedio'], ENT_QUOTES, 'UTF-8') : '—' ?></strong>
        <span class="pas-stat-nota"><?= (int) ($resumenPas['calificaciones'] ?? 0) ?> evaluaciones recibidas</span>
    </article>
</section>

<div class="row g-4 mt-1">
    <div class="col-lg-7">
        <section class="card card-form h-100" aria-labelledby="pas-solicitudes">
            <h5 class="section-title" id="pas-solicitudes">
                <i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>
                Solicitudes recientes
            </h5>
            <?php if ($solicitudesPas && count($solicitudesPas) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Cliente</th>
                                <th>Mascota</th>
                                <th>Inicio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($solicitudesPas as $solicitud) { ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars((string) ($solicitud['nomrut'] ?? 'Ruta sin nombre'), ENT_QUOTES, 'UTF-8') ?></strong></td>
                                    <td><?= htmlspecialchars(trim((string) ($solicitud['prinom'] ?? '') . ' ' . (string) ($solicitud['priapel'] ?? '')), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars((string) ($solicitud['nommasc'] ?? '—'), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars(pas_fecha($solicitud['inicio_programado'] ?? NULL), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><span class="badge <?= pas_clase_estado($solicitud['estapas'] ?? '') ?>"><?= htmlspecialchars(pas_texto_estado($solicitud['estapas'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="pas-empty"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i> Todavía no hay solicitudes en tus rutas. Cuando un cliente agende un paseo, aparecerá aquí.</p>
            <?php } ?>
        </section>
    </div>
    <div class="col-lg-5">
        <section class="card card-form h-100" aria-labelledby="pas-rutas">
            <h5 class="section-title" id="pas-rutas">
                <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                Mis rutas
            </h5>
            <?php if ($rutasPas && count($rutasPas) > 0) { ?>
                <ul class="pas-lista">
                    <?php foreach ($rutasPas as $ruta) { ?>
                        <li class="pas-lista-item">
                            <span class="pas-lista-icono"><i class="fa-solid fa-route" aria-hidden="true"></i></span>
                            <span class="pas-lista-texto">
                                <strong><?= htmlspecialchars((string) ($ruta['nomrut'] ?? 'Ruta sin nombre'), ENT_QUOTES, 'UTF-8') ?></strong>
                                <small>
                                    <?= $ruta['distrut'] !== NULL ? htmlspecialchars(number_format((float) $ruta['distrut'], 1) . ' km', ENT_QUOTES, 'UTF-8') : 'Distancia sin registrar' ?>
                                    · <?= (int) ($ruta['total_paseos'] ?? 0) ?> paseos
                                    <?php if ((int) ($ruta['pendientes'] ?? 0) > 0) { ?>
                                        · <span class="text-warning"><?= (int) $ruta['pendientes'] ?> pendientes</span>
                                    <?php } ?>
                                </small>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p class="pas-empty"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Aún no tienes rutas registradas a tu nombre.</p>
            <?php } ?>
        </section>
    </div>
</div>

<section class="mt-4" aria-labelledby="pas-accesos">
    <h5 class="section-title" id="pas-accesos">
        <i class="fa-solid fa-bolt" aria-hidden="true"></i>
        Accesos rápidos
    </h5>
    <div class="dashboard-grid">
        <?php if (function_exists('up_puede_ver') && up_puede_ver(4)) { ?>
            <a href="home.php?pg=4" class="card dashboard-card">
                <span class="tile-icon"><i class="fa-solid fa-id-card" aria-hidden="true"></i></span>
                <h2>Mi perfil</h2>
                <p>Consulta la información básica de tu cuenta UrbanPaws.</p>
                <span class="tile-action">Abrir perfil <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
            </a>
        <?php } ?>
        <?php if (function_exists('up_puede_ver') && up_puede_ver(7)) { ?>
            <a href="home.php?pg=7&amp;iduser=<?= $pasId ?>" class="card dashboard-card">
                <span class="tile-icon"><i class="fa-solid fa-address-card" aria-hidden="true"></i></span>
                <h2>Mis datos</h2>
                <p>Actualiza tu información de contacto y mantén tus datos al día.</p>
                <span class="tile-action">Editar información <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
            </a>
        <?php } ?>
        <?php if (function_exists('up_puede_ver') && up_puede_ver(19)) { ?>
            <a href="home.php?pg=19" class="card dashboard-card">
                <span class="tile-icon"><i class="fa-solid fa-receipt" aria-hidden="true"></i></span>
                <h2>Facturación</h2>
                <p>Consulta los documentos registrados en el sistema.</p>
                <span class="tile-action">Ver facturación <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
            </a>
        <?php } ?>
    </div>
</section>
