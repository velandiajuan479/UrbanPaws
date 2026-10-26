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
                    <label class="form-check-label" for="most<?= $m['idval'] ?>"><?= $m['codval'] ?></label>
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
    <div data-card-table data-card-sort-label="Página">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                <div class="col" data-card-item data-card-sort="<?= htmlspecialchars((string) $dt['nompag'], ENT_QUOTES, 'UTF-8') ?>">
                    <article class="card h-100">
                        <div class="card-body p-2 p-sm-3">
                            <h6 class="card-title">
                                <i class="<?= $dt['icopag'] ?>"></i>
                                #<?= $dt['idpag'] ?> <?= $dt['nompag'] ?>
                            </h6>
                            <dl class="row mb-0 small">
                                <dt class="col-4">Título</dt>
                                <dd class="col-8 text-break"><?= $dt['titpag'] ?></dd>
                                <dt class="col-4">Ruta</dt>
                                <dd class="col-8 text-break"><?= $dt['rutpag'] ?></dd>
                                <dt class="col-4">Orden</dt>
                                <dd class="col-8"><?= $dt['ordpag'] ?></dd>
                                <dt class="col-4">Mostrar</dt>
                                <dd class="col-8">
                                    <span class="badge <?= $dt['mostpag'] == '1' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $dt['mostpag'] == '1' ? 'Sí' : 'No' ?>
                                    </span>
                                </dd>
                                <dt class="col-12 mb-0">Descripción</dt>
                                <dd class="col-12 text-break"><?= $dt['descpag'] ?></dd>
                            </dl>
                        </div>
                        <div class="card-footer py-2 text-end">
                            <a href="home.php?pg=23&ope=edi&idpag=<?= $dt['idpag'] ?>" class="btn btn-link p-0" title="Editar" aria-label="Editar <?= htmlspecialchars((string) $dt['nompag'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a href="home.php?pg=23&ope=eli&idpag=<?= $dt['idpag'] ?>" class="btn btn-link p-0 ms-2" title="Borrar" aria-label="Eliminar <?= htmlspecialchars((string) $dt['nompag'], ENT_QUOTES, 'UTF-8') ?>"
                               onclick="return confirm('¿Eliminar la página?')">
                                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay páginas registradas.</div>
            <?php } ?>
        </div>
    </div>
</div>
