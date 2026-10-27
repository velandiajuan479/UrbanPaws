<?php require_once("controllers/ccofpag.php"); ?>

<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-file-lines"></i>
        Nueva Página
    </h4>
    <form action="home.php?pg=23&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idpag" name="idpag" value="<?= $dtOn ? $dtOn['idpag'] : '' ?>">

        <!-- Nombre de la página -->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label class="form-label">Nombre de la página</label>
            <input type="text" class="form-control" name="nompag" placeholder="Ej: Inicio" required
                   value="<?= $dtOn ? $dtOn['nompag'] : '' ?>">
        </div>

        <!-- Título de la página -->
        <div class="col-md-8">
            <i class="fa-solid fa-heading"></i>
            <label class="form-label">Título de la página</label>
            <input type="text" class="form-control" name="titpag" placeholder="Ej: Bienvenido a UrbanPaws"
                   value="<?= $dtOn ? $dtOn['titpag'] : '' ?>">
        </div>

        <!-- Mostrar Página (Si / No) -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Mostrar Página</label>
            <div class="w-100"></div>
            <?php if ($datMost) { foreach ($datMost AS $m) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mostpag"
                           id="most<?= $m['idval'] ?>" value="<?= $m['idval'] ?>" required
                           <?= ($dtOn && $dtOn['mostpag'] == $m['idval']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="most<?= $m['idval'] ?>"><?= htmlspecialchars((string) $m['codval'], ENT_QUOTES, 'UTF-8') ?></label>
                </div>
            <?php }} ?>
        </div>

        <!-- Icono -->
        <div class="col-md-4">
            <i class="fa-solid fa-shapes"></i>
            <label class="form-label" for="icopag">Icono</label>
            <div class="input-group">
                <select name="icopag" id="icopag" class="form-control form-select" required>
                    <option value="">Selecciona un icono...</option>
                    <?php if ($datIco) { foreach ($datIco AS $ico) { ?>
                        <option value="<?= $ico['codval'] ?>"
                            <?= ($dtOn && $dtOn['icopag'] == $ico['codval']) ? 'selected' : '' ?>>
                            <?= $ico['codval'] ?>
                        </option>
                    <?php }} ?>
                </select>
                <span class="input-group-text">
                    <i class="<?= $dtOn ? $dtOn['icopag'] : '' ?>"></i>
                </span>
            </div>
        </div>

        <!-- Ruta de la página -->
        <div class="col-md-4">
            <i class="fa-solid fa-route"></i>
            <label class="form-label">Ruta de la página</label>
            <input type="text" class="form-control" name="rutpag" placeholder="views/vcofpag.php"
                   value="<?= $dtOn ? $dtOn['rutpag'] : '' ?>">
        </div>

        <!-- Orden de carga -->
        <div class="col-md-4">
            <i class="fa-solid fa-sort"></i>
            <label class="form-label">Orden de carga</label>
            <input type="number" class="form-control" name="ordpag" placeholder="Ej: 10"
                   value="<?= $dtOn ? $dtOn['ordpag'] : '' ?>">
        </div>

        <!-- Descripción corta -->
        <div class="col-md-8">
            <i class="fa-solid fa-align-left"></i>
            <label class="form-label">Descripción corta</label>
            <textarea class="form-control" name="descpag" rows="2"
                      placeholder="Descripción breve de la página..."><?= $dtOn ? $dtOn['descpag'] : '' ?></textarea>
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
            <a href="home.php?pg=23" class="btn btn-accent" aria-label="Cancelar edición" title="Cancelar">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar página">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent" aria-label="Limpiar formulario">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>
</div>

<!-- ============== LISTADO ============== -->
<div class="card card-form mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de páginas
    </h5>
    <div data-card-table data-card-sort-label="Página" data-card-filters
         data-card-filter-active-label="Visibles" data-card-filter-inactive-label="Ocultas">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll AS $dt) {
                $nombrePagina = htmlspecialchars((string) $dt['nompag'], ENT_QUOTES, 'UTF-8');
                $tituloPagina = htmlspecialchars((string) $dt['titpag'], ENT_QUOTES, 'UTF-8');
                $rutaPagina = htmlspecialchars((string) $dt['rutpag'], ENT_QUOTES, 'UTF-8');
                $descripcionPagina = htmlspecialchars((string) $dt['descpag'], ENT_QUOTES, 'UTF-8');
                $paginaVisible = $dt['mostpag'] == '1';
            ?>
                <div class="col" data-card-item data-card-status="<?= $paginaVisible ? 'active' : 'inactive' ?>" data-card-sort="<?= $nombrePagina ?>">
                    <article class="card h-100 shadow-sm border-0 vid-card">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:38px;height:38px;background:var(--bg-soft-blue);">
                                        <i class="<?= htmlspecialchars((string) $dt['icopag'], ENT_QUOTES, 'UTF-8') ?> <?= $paginaVisible ? 'text-success' : 'text-secondary' ?>"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $dt['idpag'] ?> - <?= $nombrePagina ?>" style="font-size:1.05rem;min-width:0;color:var(--brand-dark);">
                                        <span style="color:var(--brand-primary);">#<?= (int) $dt['idpag'] ?></span> - <?= $nombrePagina ?>
                                    </h6>
                                    <span class="badge <?= $paginaVisible ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                        <?= $paginaVisible ? 'Sí' : 'No' ?>
                                    </span>
                                </div>

                                <div class="p-2 mb-2 rounded-3 border" style="font-size:0.8rem;background:var(--bg-soft-blue);border-color:var(--border-light)!important;">
                                    <span class="text-muted d-block" style="font-size:0.72rem;">Título</span>
                                    <span class="fw-bold text-break d-block" style="color:var(--brand-primary);"><i class="fa-solid fa-heading me-1"></i><?= $tituloPagina ?></span>
                                </div>

                                <div class="p-2 mb-2 rounded-3 border" style="font-size:0.8rem;background:var(--bg-soft-blue);border-color:var(--border-light)!important;">
                                    <span class="text-muted d-block" style="font-size:0.72rem;">Ruta de la página</span>
                                    <span class="fw-bold text-success text-break d-block"><i class="fa-solid fa-route me-1"></i><?= $rutaPagina ?></span>
                                </div>

                                <div class="d-flex justify-content-between gap-1 text-muted mb-2" style="font-size:0.78rem;">
                                    <span><i class="fa-solid fa-arrow-down-1-9 me-1" style="color:var(--brand-primary);"></i><strong>Orden:</strong> <?= htmlspecialchars((string) $dt['ordpag'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>

                                <div class="text-muted mt-2 p-2 rounded border d-flex flex-column gap-1" style="font-size:0.78rem;background:var(--bg-card);border-color:var(--border-light)!important;">
                                    <span class="text-break"><i class="fa-solid fa-align-left me-1" style="color:var(--brand-accent);"></i><strong>Descripción:</strong> <?= nl2br($descripcionPagina) ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3" style="background:var(--bg-card);">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="vid-actions-bar" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:.5rem;">
                                <a href="home.php?pg=23&ope=edi&idpag=<?= (int) $dt['idpag'] ?>" class="btn btn-accent shadow-sm w-100" title="Editar página" aria-label="Editar página <?= $nombrePagina ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> <span class="d-none d-sm-inline d-md-none">Editar</span>
                                </a>
                                <form action="home.php?pg=23&ope=toggle" method="POST" class="m-0 d-grid">
                                    <input type="hidden" name="idpag" value="<?= (int) $dt['idpag'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfTokenPag, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary w-100 shadow-sm" title="<?= $paginaVisible ? 'Desactivar' : 'Activar' ?> página" aria-label="<?= $paginaVisible ? 'Desactivar' : 'Activar' ?> <?= $nombrePagina ?>">
                                        <i class="fa-solid <?= $paginaVisible ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i> <span class="d-none d-sm-inline d-md-none"><?= $paginaVisible ? 'Desactivar' : 'Activar' ?></span>
                                    </button>
                                </form>
                                <a href="home.php?pg=23&ope=eli&idpag=<?= (int) $dt['idpag'] ?>" class="btn btn-outline-secondary shadow-sm w-100" title="Eliminar página" aria-label="Eliminar página <?= $nombrePagina ?>" onclick="return confirm('¿Eliminar la página?')">
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i> <span class="d-none d-sm-inline d-md-none">Eliminar</span>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay páginas registradas.</div>
            <?php } ?>
        </div>
    </div>
</div>
