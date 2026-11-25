<?php require_once __DIR__ . '/../controllers/ccofraz.php'; ?>
<section class="card card-form p-4" aria-labelledby="razas-title">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <span class="eyebrow">Configuración</span>
            <h1 class="section-title mb-1" id="razas-title"><i class="fa-solid fa-paw" aria-hidden="true"></i> Razas de mascotas</h1>
            <p class="text-muted mb-0">Administra las razas disponibles al registrar una mascota.</p>
        </div>
    </div>

    <?php if (isset($_GET['resultado']) && is_string($_GET['resultado'])) {
        $mensajesRaza = [
            'guardada' => 'La raza se registró correctamente.',
            'actualizada' => 'La raza se actualizó correctamente.',
            'estado' => 'El estado de la raza se actualizó.',
            'eliminada' => 'La raza se eliminó correctamente.',
        ];
        if (isset($mensajesRaza[$_GET['resultado']])) { ?>
            <div class="alert alert-success" role="status"><?= htmlspecialchars($mensajesRaza[$_GET['resultado']], ENT_QUOTES, 'UTF-8') ?></div>
        <?php }
    } ?>
    <?php if ($errorRaza) { ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errorRaza, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>

    <form action="home.php?pg=25&amp;seccion=razas" method="POST" class="row g-3 align-items-end">
        <input type="hidden" name="ope" value="save">
        <input type="hidden" name="idraz" value="<?= (int) $idrazEditar ?>">
        <div class="col-md-8">
            <label for="nomraz" class="form-label"><?= $idrazEditar ? 'Editar raza' : 'Nombre de la raza' ?></label>
            <input type="text" class="form-control" id="nomraz" name="nomraz" maxlength="255" required
                   placeholder="Ej.: Beagle" value="<?= htmlspecialchars($nombreRaza, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <fieldset class="col-md-4">
            <legend class="form-label fs-6">Estado</legend>
            <?php foreach ($datEst as $estado) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="actraz" id="actraz<?= (int) $estado['idval'] ?>"
                           value="<?= (int) $estado['idval'] ?>" <?= (int) $estado['idval'] === (int) $estadoFormulario ? 'checked' : '' ?> required>
                    <label class="form-check-label" for="actraz<?= (int) $estado['idval'] ?>"><?= htmlspecialchars((string) $estado['codval'], ENT_QUOTES, 'UTF-8') ?></label>
                </div>
            <?php } ?>
        </fieldset>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['token_cofraz'], ENT_QUOTES, 'UTF-8') ?>">
        <div class="col-12">
            <?php if ($idrazEditar) { ?><a href="home.php?pg=25&amp;seccion=razas" class="btn btn-accent me-2">Cancelar</a><?php } ?>
            <button type="submit" class="btn btn-primary"><i class="fa-solid <?= $idrazEditar ? 'fa-floppy-disk' : 'fa-plus' ?> me-2" aria-hidden="true"></i><?= $idrazEditar ? 'Guardar cambios' : 'Crear raza' ?></button>
        </div>
    </form>
</section>

<section class="card card-form mt-4" aria-labelledby="razas-list-title">
    <h2 class="h5 mb-3" id="razas-list-title"><i class="fa-solid fa-list me-2" aria-hidden="true"></i>Razas registradas <span class="badge text-bg-secondary"><?= count($razasMascotas) ?></span></h2>
    <div data-card-table data-card-sort-label="Raza" data-card-filters
         data-card-filter-active-label="Activas" data-card-filter-inactive-label="Inactivas">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($razasMascotas) { foreach ($razasMascotas as $raza) {
                $nombreRazaTarjeta = htmlspecialchars((string) $raza['nomraz'], ENT_QUOTES, 'UTF-8');
                $razaActiva = (int) $raza['actraz'] === 1;
            ?>
                <div class="col" data-card-item data-card-status="<?= $razaActiva ? 'active' : 'inactive' ?>" data-card-sort="<?= $nombreRazaTarjeta ?>">
                    <article class="card h-100 shadow-sm border-0">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 p-2">
                                    <i class="fa-solid fa-paw <?= $razaActiva ? 'text-success' : 'text-secondary' ?>" aria-hidden="true"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $raza['idraz'] ?> - <?= $nombreRazaTarjeta ?>">
                                    <span class="text-primary">#<?= (int) $raza['idraz'] ?></span> - <?= $nombreRazaTarjeta ?>
                                </h3>
                                <span class="badge <?= $razaActiva ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                    <?= htmlspecialchars((string) ($raza['estado'] ?? 'Sin estado'), ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3 bg-white">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=25&amp;seccion=razas&amp;ope=edi&amp;idraz=<?= (int) $raza['idraz'] ?>" class="btn btn-accent shadow-sm flex-fill" title="Editar raza" aria-label="Editar <?= $nombreRazaTarjeta ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=25&amp;seccion=razas" method="POST" class="m-0 d-flex flex-fill">
                                    <input type="hidden" name="ope" value="toggle">
                                    <input type="hidden" name="idraz" value="<?= (int) $raza['idraz'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['token_cofraz'], ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="<?= $razaActiva ? 'Desactivar' : 'Activar' ?> raza" aria-label="<?= $razaActiva ? 'Desactivar' : 'Activar' ?> <?= $nombreRazaTarjeta ?>">
                                        <i class="fa-solid <?= $razaActiva ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <form action="home.php?pg=25&amp;seccion=razas" method="POST" class="m-0 d-flex flex-fill" onsubmit="return confirm('¿Eliminar esta raza?');">
                                    <input type="hidden" name="ope" value="eli">
                                    <input type="hidden" name="idraz" value="<?= (int) $raza['idraz'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['token_cofraz'], ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="Eliminar raza" aria-label="Eliminar <?= $nombreRazaTarjeta ?>">
                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">Todavía no hay razas registradas.</div>
            <?php } ?>
        </div>
    </div>
</section>
