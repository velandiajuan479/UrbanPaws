<?php require_once("controllers/ccofcof.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-gear"></i>
        Configuración del Sistema
    </h4>
    <form action="home.php?pg=25&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idconf" name="idconf" value="<?= $dtOn ? $dtOn['idconf'] : '' ?>">

        <!-- Nombre de la empresa -->
        <div class="col-md-4">
            <i class="fa-solid fa-building"></i>
            <label class="form-label">Nombre de la Empresa</label>
            <input type="text" class="form-control" name="nomcon" placeholder="Ej: UrbanPaws" required
                   value="<?= $dtOn ? $dtOn['nomcon'] : '' ?>">
        </div>

        <!-- Email -->
        <div class="col-md-4">
            <i class="fa-solid fa-envelope"></i>
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="emailcon" placeholder="correo@ejemplo.com" required
                   value="<?= $dtOn ? $dtOn['emailcon'] : '' ?>">
        </div>

        <!-- Teléfono -->
        <div class="col-md-4">
            <i class="fa-solid fa-phone"></i>
            <label class="form-label">Teléfono</label>
            <input type="tel" class="form-control" name="telecon" placeholder="3000000000"
                   value="<?= $dtOn ? $dtOn['telecon'] : '' ?>">
        </div>

        <!-- Logo (ruta o URL) con vista previa -->
        <div class="col-md-8">
            <i class="fa-solid fa-image"></i>
            <label class="form-label">Logo (ruta o URL)</label>
            <div class="input-group">
                <input type="text" class="form-control" name="logocon" placeholder="https://... o uploads/..."
                       value="<?= $dtOn ? $dtOn['logocon'] : '' ?>">
                <?php if ($dtOn && $dtOn['logocon']) { ?>
                <span class="input-group-text">
                    <img src="<?= $dtOn['logocon'] ?>" alt="logo" height="24">
                </span>
                <?php } ?>
            </div>
        </div>

        <!-- Estado: radios generados desde valor (dominio 1) -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Estado</label>
            <div class="w-100"></div>
            <?php if ($datEst) { foreach ($datEst AS $est) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estacon"
                       id="est<?= $est['idval'] ?>" value="<?= $est['idval'] ?>" required
                       <?= ($dtOn && $dtOn['estacon'] == $est['idval']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="est<?= $est['idval'] ?>"><?= $est['codval'] ?></label>
            </div>
            <?php }} ?>
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
            <a href="home.php?pg=25" class="btn btn-accent" aria-label="Cancelar edición" title="Cancelar">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar configuración">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent" aria-label="Limpiar formulario">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>
</div>

<div class="card card-form mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de configuraciones
    </h5>
    <div data-card-table data-card-sort-label="Configuración" data-card-filters
         data-card-filter-active-label="Activas" data-card-filter-inactive-label="Inactivas">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll AS $dt) {
                $nombreConfiguracion = htmlspecialchars((string) $dt['nomcon'], ENT_QUOTES, 'UTF-8');
                $estadoConfiguracion = $dt['estacon'] == 1;
            ?>
                <div class="col" data-card-item data-card-status="<?= $estadoConfiguracion ? 'active' : 'inactive' ?>" data-card-sort="<?= $nombreConfiguracion ?>">
                    <article class="card h-100 shadow-sm border-0">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <?php if ($dt['logocon']) { ?>
                                        <img src="<?= htmlspecialchars((string) $dt['logocon'], ENT_QUOTES, 'UTF-8') ?>" alt="Logo de <?= $nombreConfiguracion ?>" height="38" class="rounded flex-shrink-0">
                                    <?php } else { ?>
                                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 p-2">
                                            <i class="fa-solid fa-gear text-secondary" aria-hidden="true"></i>
                                        </div>
                                    <?php } ?>
                                    <h6 class="fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $dt['idconf'] ?> - <?= $nombreConfiguracion ?>">
                                        #<?= (int) $dt['idconf'] ?> - <?= $nombreConfiguracion ?>
                                    </h6>
                                    <span class="badge <?= $estadoConfiguracion ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                        <?= $estadoConfiguracion ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </div>
                                <div class="p-2 mb-2 rounded-3 border small">
                                    <span class="text-muted d-block">Email</span>
                                    <span class="fw-bold text-break"><i class="fa-solid fa-envelope me-1" aria-hidden="true"></i><?= htmlspecialchars((string) $dt['emailcon'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <div class="p-2 rounded-3 border small">
                                    <span class="text-muted d-block">Teléfono</span>
                                    <span class="fw-bold text-break"><i class="fa-solid fa-phone me-1" aria-hidden="true"></i><?= htmlspecialchars((string) $dt['telecon'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3 bg-white">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=25&ope=edi&idconf=<?= (int) $dt['idconf'] ?>" class="btn btn-accent shadow-sm flex-fill" title="Editar configuración" aria-label="Editar <?= $nombreConfiguracion ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=25&ope=toggle" method="POST" class="m-0 d-flex flex-fill">
                                    <input type="hidden" name="idconf" value="<?= (int) $dt['idconf'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfTokenCofcof, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="<?= $estadoConfiguracion ? 'Desactivar' : 'Activar' ?> configuración" aria-label="<?= $estadoConfiguracion ? 'Desactivar' : 'Activar' ?> <?= $nombreConfiguracion ?>">
                                        <i class="fa-solid <?= $estadoConfiguracion ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <a href="home.php?pg=25&ope=eli&idconf=<?= (int) $dt['idconf'] ?>" class="btn btn-outline-secondary shadow-sm flex-fill" title="Eliminar configuración" aria-label="Eliminar <?= $nombreConfiguracion ?>" onclick="return confirm('¿Eliminar la configuración?')">
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay configuraciones registradas.</div>
            <?php } ?>
        </div>
    </div>
</div>
