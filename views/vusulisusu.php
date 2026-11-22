<?php
require_once 'models/helpers.php';
require_once 'models/musulisusu.php';

$lis    = new mUsuLisUsu();
$datAll = $lis->getAll();
$miId   = (int) ($_SESSION['iduser'] ?? 0);

$okMsgs  = ['activado' => 'Usuario activado.', 'desactivado' => 'Usuario desactivado.', 'borrado' => 'Usuario eliminado.'];
$errMsgs = [
    'fk'      => 'No se puede eliminar: el usuario tiene mascotas, rutas, paseos u otros registros asociados. Desactívalo para quitarle el acceso.',
    'propio'  => 'No puedes desactivar ni eliminar tu propia cuenta.',
    'general' => 'No se pudo completar la acción. Inténtalo de nuevo.',
];
$ok  = $okMsgs[$_GET['ok'] ?? ''] ?? null;
$err = $errMsgs[$_GET['err'] ?? ''] ?? null;
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Administración</span>
        <h1>Usuarios</h1>
        <p>Consulta quién tiene cuenta en UrbanPaws y activa o desactiva su acceso.</p>
    </div>
</div>

<?php if ($ok) { ?><div class="alert alert-success" role="status"><?= up_e($ok) ?></div><?php } ?>
<?php if ($err) { ?><div class="alert alert-danger" role="alert"><?= up_e($err) ?></div><?php } ?>

<div class="card card-form">
    <h5 class="mb-3">
        <i class="fa-solid fa-users" aria-hidden="true"></i>
        Listado de usuarios
    </h5>

    <div data-card-table data-card-sort-label="Usuario" data-card-filters
         data-card-filter-all-label="Todos" data-card-filter-active-label="Activos" data-card-filter-inactive-label="Inactivos">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll as $dt) {
                $nombre = trim($dt['prinom'] . ' ' . $dt['seconom'] . ' ' . $dt['priapel']);
                $estado = (int) $dt['estusr'];
                $esYo   = ((int) $dt['iduser'] === $miId);
                $id     = (int) $dt['iduser'];
            ?>
                <div class="col" data-card-item data-card-status="<?= $estado === 1 ? 'active' : 'inactive' ?>" data-card-sort="<?= up_e($nombre) ?>">
                    <article class="card h-100">
                        <div class="card-body p-2 p-sm-3">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <h6 class="card-title mb-0"><?= up_e($nombre) ?><?= $esYo ? ' <span class="badge bg-primary">Tú</span>' : '' ?></h6>
                                <?php if ($estado === 1) { ?>
                                    <span class="badge bg-success text-nowrap">Activo</span>
                                <?php } elseif ($estado === 2) { ?>
                                    <span class="badge bg-danger text-nowrap">Rechazado</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary text-nowrap">Inactivo</span>
                                <?php } ?>
                            </div>
                            <dl class="row mb-0 small">
                                <dt class="col-4">Documento</dt>
                                <dd class="col-8"><?= up_e($dt['docu']) ?></dd>
                                <dt class="col-4">Correo</dt>
                                <dd class="col-8 text-break"><?= up_e($dt['emailu']) ?></dd>
                                <dt class="col-4">Teléfono</dt>
                                <dd class="col-8"><?= up_e($dt['teleu'] ?: '—') ?></dd>
                                <dt class="col-4">Ubicación</dt>
                                <dd class="col-8"><?= up_e($dt['nomubi'] ?: 'Sin ubicación') ?></dd>
                                <dt class="col-4">Perfil</dt>
                                <dd class="col-8">
                                    <?php if (!empty($dt['perfiles'])) {
                                        foreach (explode(', ', $dt['perfiles']) as $perfil) { ?>
                                            <span class="badge bg-primary"><?= up_e($perfil) ?></span>
                                    <?php } } else { ?>
                                        <span class="badge bg-secondary">Sin perfil</span>
                                    <?php } ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=2&amp;ope=edi&amp;iduser=<?= $id ?>" class="btn btn-accent shadow-sm flex-fill"
                                   title="Editar usuario" aria-label="Editar <?= up_e($nombre) ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>

                                <?php if ($estado === 2 || $esYo) { ?>
                                    <button type="button" class="btn btn-outline-secondary shadow-sm flex-fill" disabled
                                            title="<?= $esYo ? 'No puedes desactivar tu propia cuenta' : 'Se gestiona en Validación de paseadores' ?>">
                                        <i class="fa-solid <?= $estado === 1 ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                <?php } else { ?>
                                    <form action="controllers/cusulisusu.php" method="post" class="m-0 d-grid flex-fill"
                                          onsubmit="return confirm('<?= $estado === 1 ? '¿Desactivar' : '¿Activar' ?> a este usuario?');">
                                        <?= up_csrf_field() ?>
                                        <input type="hidden" name="ope" value="<?= $estado === 1 ? 'desactivar' : 'activar' ?>">
                                        <input type="hidden" name="iduser" value="<?= $id ?>">
                                        <button type="submit" class="btn btn-outline-secondary shadow-sm w-100"
                                                title="<?= $estado === 1 ? 'Desactivar' : 'Activar' ?> usuario"
                                                aria-label="<?= $estado === 1 ? 'Desactivar' : 'Activar' ?> a <?= up_e($nombre) ?>">
                                            <i class="fa-solid <?= $estado === 1 ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                <?php } ?>

                                <?php if ($esYo) { ?>
                                    <button type="button" class="btn btn-outline-secondary shadow-sm flex-fill" disabled
                                            title="No puedes eliminar tu propia cuenta">
                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                <?php } else { ?>
                                    <form action="controllers/cusulisusu.php" method="post" class="m-0 d-grid flex-fill"
                                          onsubmit="return confirm('¿Eliminar este usuario? Esta acción no se puede deshacer.');">
                                        <?= up_csrf_field() ?>
                                        <input type="hidden" name="ope" value="borrar">
                                        <input type="hidden" name="iduser" value="<?= $id ?>">
                                        <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="Eliminar usuario"
                                                aria-label="Eliminar a <?= up_e($nombre) ?>">
                                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay usuarios registrados.</div>
            <?php } ?>
        </div>
    </div>
</div>
