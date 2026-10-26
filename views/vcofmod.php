<?php require_once("controllers/ccofmod.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Módulo
    </h4>
    <form action="home.php?pg=24&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idmod" name="idmod" value="<?= $dtOn ? $dtOn['idmod'] : '' ?>">

        <!-- Nombre del módulo -->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label class="form-label">Nombre del módulo</label>
            <input type="text" class="form-control" name="nommod" placeholder="Usuarios" required
                   value="<?= $dtOn ? $dtOn['nommod'] : '' ?>">
        </div>

        <!-- Estado -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Estado</label>
            <div class="w-100"></div>
            <?php if ($datEst) { foreach ($datEst AS $est) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estamod"
                       id="est<?= $est['idval'] ?>" value="<?= $est['idval'] ?>" required
                       <?= ($dtOn && $dtOn['estamod'] == $est['idval']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="est<?= $est['idval'] ?>"><?= $est['codval'] ?></label>
            </div>
            <?php }} ?>
        </div>

        <!-- Iconos-->
        <div class="col-md-4">
            <i class="fa-solid fa-shapes"></i>
            <label class="form-label" for="icomod">Icono</label>
            <div class="input-group">
                <select name="icomod" id="icomod" class="form-control form-select" required>
                    <option value="">Selecciona un icono...</option>
                    <?php if ($datIco) { foreach ($datIco AS $ico) { ?>
                    <option value="<?= $ico['codval'] ?>"
                        <?= ($dtOn && $dtOn['icomod'] == $ico['codval']) ? 'selected' : '' ?>>
                        <?= $ico['codval'] ?>
                    </option>
                    <?php }} ?>
                </select>
                <span class="input-group-text">
                    <i class="<?= $dtOn ? $dtOn['icomod'] : '' ?>"></i>
                </span>
            </div>
        </div>

        <!-- Usuarios con acceso-->
        <div class="col-md-4">
            <i class="fa-solid fa-users"></i>
            <label class="form-label" for="idperf">Usuarios con acceso</label>
            <select name="idperf" id="idperf" class="form-control form-select">
                <option value="">Sin usuarios</option>
                <?php if ($datPer) { foreach ($datPer AS $per) { ?>
                <option value="<?= $per['idperf'] ?>"
                    <?= ($dtOn && $dtOn['idperf'] == $per['idperf']) ? 'selected' : '' ?>>
                    <?= $per['nomperf'] ?>
                </option>
                <?php }} ?>
            </select>
        </div>

        <!-- Orden de carga -->
        <div class="col-md-4">
            <i class="fa-solid fa-sort"></i>
            <label class="form-label">Orden de carga</label>
            <input type="number" class="form-control" name="ordmod" placeholder="Ej:10"
                value="<?= $dtOn ? $dtOn['ordmod'] : '' ?>">
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
            <a href="home.php?pg=24" class="btn btn-accent" aria-label="Cancelar edición" title="Cancelar">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar módulo">
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
        Lista de módulos
    </h5>
    <div data-card-table data-card-sort-label="Módulo" data-card-filters
         data-card-filter-active-label="Activos" data-card-filter-inactive-label="Inactivos">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll AS $dt) {
                $nombreModulo = htmlspecialchars((string) $dt['nommod'], ENT_QUOTES, 'UTF-8');
                $moduloActivo = $dt['estamod'] == 1;
            ?>
                <div class="col" data-card-item data-card-status="<?= $moduloActivo ? 'active' : 'inactive' ?>" data-card-sort="<?= $nombreModulo ?>">
                    <article class="card h-100 shadow-sm border-0">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 p-2">
                                        <i class="<?= htmlspecialchars((string) $dt['icomod'], ENT_QUOTES, 'UTF-8') ?> <?= $moduloActivo ? 'text-success' : 'text-secondary' ?>" aria-hidden="true"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $dt['idmod'] ?> - <?= $nombreModulo ?>">
                                        <span class="text-primary">#<?= (int) $dt['idmod'] ?></span> - <?= $nombreModulo ?>
                                    </h6>
                                    <span class="badge <?= $moduloActivo ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                        <?= $moduloActivo ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </div>
                                <div class="p-2 mb-2 rounded-3 border small">
                                    <span class="text-muted d-block">Acceso</span>
                                    <span class="fw-bold text-break"><i class="fa-solid fa-users me-1" aria-hidden="true"></i><?= htmlspecialchars((string) ($dt['nomperf'] ?: 'Sin usuarios'), ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <div class="text-muted small"><i class="fa-solid fa-arrow-down-1-9 me-1" aria-hidden="true"></i><strong>Orden:</strong> <?= htmlspecialchars((string) $dt['ordmod'], ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3 bg-white">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=24&ope=edi&idmod=<?= (int) $dt['idmod'] ?>" class="btn btn-accent shadow-sm flex-fill" title="Editar módulo" aria-label="Editar <?= $nombreModulo ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=24&ope=toggle" method="POST" class="m-0 d-flex flex-fill">
                                    <input type="hidden" name="idmod" value="<?= (int) $dt['idmod'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfTokenCofmod, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="<?= $moduloActivo ? 'Desactivar' : 'Activar' ?> módulo" aria-label="<?= $moduloActivo ? 'Desactivar' : 'Activar' ?> <?= $nombreModulo ?>">
                                        <i class="fa-solid <?= $moduloActivo ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <a href="home.php?pg=24&ope=eli&idmod=<?= (int) $dt['idmod'] ?>" class="btn btn-outline-secondary shadow-sm flex-fill" title="Eliminar módulo" aria-label="Eliminar <?= $nombreModulo ?>" onclick="return confirm('¿Eliminar el módulo?')">
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay módulos registrados.</div>
            <?php } ?>
        </div>
    </div>
</div>
