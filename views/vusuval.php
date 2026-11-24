<?php
require_once 'models/helpers.php';
require_once 'models/musuval.php';

$val    = new mUsuVal();
$datAll = $val->getPendientes();

$okMsgs  = ['aprobado' => 'Paseador aprobado. Ya puede iniciar sesión.', 'rechazado' => 'Paseador rechazado.'];
$errMsgs = ['nopendiente' => 'Ese paseador ya no está pendiente de validación.'];
$ok  = $okMsgs[$_GET['ok'] ?? ''] ?? null;
$err = $errMsgs[$_GET['err'] ?? ''] ?? null;
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Administración</span>
        <h1>Validación de paseadores</h1>
        <p>Revisa los datos y antecedentes de cada solicitud antes de darle acceso a la plataforma.</p>
    </div>
</div>

<?php if ($ok) { ?><div class="alert alert-success" role="status"><?= up_e($ok) ?></div><?php } ?>
<?php if ($err) { ?><div class="alert alert-warning" role="alert"><?= up_e($err) ?></div><?php } ?>

<div class="card card-form">
    <h5 class="mb-3">
        <i class="fa-solid fa-user-check" aria-hidden="true"></i>
        Solicitudes pendientes
    </h5>

    <div data-card-table data-card-sort-label="Paseador">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll as $dt) {
                $nombre = trim($dt['prinom'] . ' ' . $dt['seconom'] . ' ' . $dt['priapel']);
                $id     = (int) $dt['iduser'];
            ?>
                <div class="col" data-card-item data-card-sort="<?= up_e($nombre) ?>">
                    <article class="card h-100">
                        <div class="card-body p-2 p-sm-3">
                            <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                <h6 class="card-title mb-0"><?= up_e($nombre) ?></h6>
                                <span class="badge bg-warning text-nowrap">Pendiente</span>
                            </div>
                            <dl class="row mb-0 small">
                                <dt class="col-4">Documento</dt>
                                <dd class="col-8"><?= up_e($dt['docu']) ?></dd>
                                <dt class="col-4">Correo</dt>
                                <dd class="col-8 text-break"><?= up_e($dt['emailu']) ?></dd>
                                <dt class="col-4">Teléfono</dt>
                                <dd class="col-8"><?= up_e($dt['teleu'] ?: '—') ?></dd>
                                <dt class="col-4">Antecedentes</dt>
                                <dd class="col-8">
                                    <?php if (!empty($dt['antecedentes'])) {
                                        foreach (explode(', ', $dt['antecedentes']) as $ant) { ?>
                                            <span class="badge bg-warning"><?= up_e($ant) ?></span>
                                    <?php } } else { ?>
                                        <span class="badge bg-success">Sin antecedentes</span>
                                    <?php } ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <form action="controllers/cusuval.php" method="post" class="m-0 d-grid flex-fill"
                                      onsubmit="return confirm('¿Aprobar a este paseador?');">
                                    <?= up_csrf_field() ?>
                                    <input type="hidden" name="ope" value="aprobar">
                                    <input type="hidden" name="iduser" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-accent shadow-sm w-100" title="Aprobar paseador"
                                            aria-label="Aprobar a <?= up_e($nombre) ?>">
                                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i> Aprobar
                                    </button>
                                </form>
                                <form action="controllers/cusuval.php" method="post" class="m-0 d-grid flex-fill"
                                      onsubmit="return confirm('¿Rechazar a este paseador?');">
                                    <?= up_csrf_field() ?>
                                    <input type="hidden" name="ope" value="rechazar">
                                    <input type="hidden" name="iduser" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="Rechazar paseador"
                                            aria-label="Rechazar a <?= up_e($nombre) ?>">
                                        <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay paseadores esperando validación.</div>
            <?php } ?>
        </div>
    </div>
</div>
