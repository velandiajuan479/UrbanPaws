<?php
require_once("controllers/ccofdom.php");
?>
<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Dominio
    </h4> 
    
    <form action="home.php?pg=26&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="iddom" name="iddom" value="<?= $dtOn ? $dtOn['iddom'] : '' ?>">


    <!--Nombre del módulo-->

        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre del dominio</label>
            <input type="text" name="nomdom" class="form-control" placeholder="Tipo de documento" required value="<?= $dtOn ? $dtOn["nomdom"] : '' ?>">
        </div>

    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Estado</label>
            <div class="w-100"></div>
            <?php foreach ($datEst as $estado) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="actdom" id="actdom<?= (int) $estado['idval'] ?>" value="<?= (int) $estado['idval'] ?>" <?= ($dtOn && $dtOn['actdom'] == $estado['idval']) ? 'checked' : '' ?> required>
                <label class="form-check-label" for="actdom<?= (int) $estado['idval'] ?>"><?= htmlspecialchars((string) $estado['codval'], ENT_QUOTES, 'UTF-8') ?></label>
            </div>
            <?php } ?>
        </div>
    <!--Botones-->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
            <a href="home.php?pg=26" class="btn btn-accent" aria-label="Cancelar edición" title="Cancelar">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar dominio">
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
        Lista de dominios
    </h5>
    <div data-card-table data-card-sort-label="Dominio" data-card-filters
         data-card-filter-active-label="Activos" data-card-filter-inactive-label="Inactivos">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll as $dt) {
                $nombreDominio = htmlspecialchars((string) $dt['nomdom'], ENT_QUOTES, 'UTF-8');
                $dominioActivo = $dt['actdom'] == 1;
            ?>
                <div class="col" data-card-item data-card-status="<?= $dominioActivo ? 'active' : 'inactive' ?>" data-card-sort="<?= $nombreDominio ?>">
                    <article class="card h-100 shadow-sm border-0">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 p-2">
                                    <i class="fa-solid fa-box <?= $dominioActivo ? 'text-success' : 'text-secondary' ?>" aria-hidden="true"></i>
                                </div>
                                <h6 class="fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $dt['iddom'] ?> - <?= $nombreDominio ?>">
                                    <span class="text-primary">#<?= (int) $dt['iddom'] ?></span> - <?= $nombreDominio ?>
                                </h6>
                                <span class="badge <?= $dominioActivo ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                    <?= $dominioActivo ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3 bg-white">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="home.php?pg=26&ope=edi&iddom=<?= (int) $dt['iddom'] ?>" class="btn btn-accent shadow-sm flex-fill" title="Editar dominio" aria-label="Editar <?= $nombreDominio ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=26&ope=toggle" method="POST" class="m-0 d-flex flex-fill">
                                    <input type="hidden" name="iddom" value="<?= (int) $dt['iddom'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfTokenCofdom, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="<?= $dominioActivo ? 'Desactivar' : 'Activar' ?> dominio" aria-label="<?= $dominioActivo ? 'Desactivar' : 'Activar' ?> <?= $nombreDominio ?>">
                                        <i class="fa-solid <?= $dominioActivo ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <a href="home.php?pg=26&ope=eli&iddom=<?= (int) $dt['iddom'] ?>" class="btn btn-outline-secondary shadow-sm flex-fill" title="Eliminar dominio" aria-label="Eliminar <?= $nombreDominio ?>" onclick="return confirm('¿Estás seguro de borrar?');">
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay dominios registrados.</div>
            <?php } ?>
        </div>
    </div>
</div>
