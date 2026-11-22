<?php
require_once 'models/helpers.php';
require_once 'models/musuubi.php';

$ubi    = new mUsuUbi();
$datAll = $ubi->getAll();

$editando = null;
if (isset($_GET['edi'])) {
    foreach ($datAll as $dt) {
        if ((int) $dt['idubi'] === (int) $_GET['edi']) { $editando = $dt; break; }
    }
}

$okMsgs  = ['guardada' => 'Ubicación guardada.', 'actualizada' => 'Ubicación actualizada.', 'borrada' => 'Ubicación eliminada.'];
$errMsgs = [
    'campos'    => 'Completa la ciudad (máx. 35 caracteres) y el departamento (máx. 20 caracteres).',
    'duplicada' => 'Esa ciudad ya está registrada en ese departamento.',
    'enuso'     => 'No se puede eliminar: hay usuarios que viven en esa ubicación.',
    'general'   => 'No se pudo completar la acción. Inténtalo de nuevo.',
];
$ok  = $okMsgs[$_GET['ok'] ?? ''] ?? null;
$err = $errMsgs[$_GET['err'] ?? ''] ?? null;
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Administración</span>
        <h1>Ubicaciones</h1>
        <p>Gestiona las ciudades y departamentos que las personas pueden elegir en su perfil.</p>
    </div>
</div>

<?php if ($ok) { ?><div class="alert alert-success" role="status"><?= up_e($ok) ?></div><?php } ?>
<?php if ($err) { ?><div class="alert alert-danger" role="alert"><?= up_e($err) ?></div><?php } ?>

<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
        <?= $editando ? 'Editar ubicación' : 'Nueva ubicación' ?>
    </h4>

    <form action="controllers/cusuubi.php" method="post" class="row g-3">
        <?= up_csrf_field() ?>
        <input type="hidden" name="ope" value="<?= $editando ? 'editar' : 'guardar' ?>">
        <?php if ($editando) { ?><input type="hidden" name="idubi" value="<?= (int) $editando['idubi'] ?>"><?php } ?>

        <div class="col-md-6">
            <label for="nomubi" class="form-label"><i class="fa-solid fa-city" aria-hidden="true"></i>Ciudad o municipio</label>
            <input type="text" class="form-control" name="nomubi" id="nomubi" maxlength="35" placeholder="Ej: Cajicá"
                   value="<?= up_e($editando['nomubi'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label for="depaubi" class="form-label"><i class="fa-solid fa-map" aria-hidden="true"></i>Departamento</label>
            <input type="text" class="form-control" name="depaubi" id="depaubi" maxlength="20" placeholder="Ej: Cundinamarca"
                   value="<?= up_e($editando['depaubi'] ?? '') ?>" required>
        </div>

        <div class="col-md-12 mt-4 text-end">
            <?php if ($editando) { ?>
                <a href="home.php?pg=8" class="btn btn-secondary" aria-label="Cancelar edición">
                    <i class="fa-solid fa-xmark fa-xl" aria-hidden="true"></i>
                </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar ubicación">
                <i class="fa-solid fa-floppy-disk fa-xl" aria-hidden="true"></i>
            </button>
            <?php if (!$editando) { ?>
                <button type="reset" class="btn btn-accent" aria-label="Limpiar formulario">
                    <i class="fa-solid fa-trash fa-xl" aria-hidden="true"></i>
                </button>
            <?php } ?>
        </div>
    </form>
</div>

<div class="card card-form mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list" aria-hidden="true"></i>
        Lista de ubicaciones
    </h5>

    <div data-card-table data-card-sort-label="Ciudad">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll as $dt) { $id = (int) $dt['idubi']; ?>
                <div class="col" data-card-item data-card-sort="<?= up_e($dt['nomubi']) ?>">
                    <article class="card h-100">
                        <div class="card-body p-2 p-sm-3">
                            <h6 class="card-title mb-2"><?= up_e($dt['nomubi']) ?></h6>
                            <dl class="row mb-0 small">
                                <dt class="col-5">Departamento</dt>
                                <dd class="col-7"><?= up_e($dt['depaubi']) ?></dd>
                            </dl>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=8&amp;edi=<?= $id ?>" class="btn btn-accent shadow-sm flex-fill"
                                   title="Editar ubicación" aria-label="Editar <?= up_e($dt['nomubi']) ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="controllers/cusuubi.php" method="post" class="m-0 d-grid flex-fill"
                                      onsubmit="return confirm('¿Eliminar esta ubicación?');">
                                    <?= up_csrf_field() ?>
                                    <input type="hidden" name="ope" value="borrar">
                                    <input type="hidden" name="idubi" value="<?= $id ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="Eliminar ubicación"
                                            aria-label="Eliminar <?= up_e($dt['nomubi']) ?>">
                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay ubicaciones registradas.</div>
            <?php } ?>
        </div>
    </div>
</div>
