<?php require_once("controllers/ccofval.php");?>
<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Valor
    </h4> 
    
    <form action="index.php?pg=27&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idval" name="idval" value="<?= $dtOn ? $dtOn['idval'] : '' ?>">
    <!--Selección de dominio-->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label" for="">Dominio</label>
            <div class="input-group">
                <select name="iddom" id="" class="form-control form-select">
                    <option value="0">Selecciona Dominio</option>
                    <?php if($dtdom) { foreach($dtdom AS $dd){?>
                    <option value="<?= $dd["iddom"];?>" <?= ($dtOn && $dtOn["iddom"] == $dd["iddom"]) ? 'selected' : '' ?>>
                        <?= $dd["nomdom"]; ?>
                    </option>
                    <?php }}?>
                </select>
            </div>
        </div>
    <!--Nombre del módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre de valor</label>
            <input type="text" class="form-control" name="codval" placeholder="C.C" required value="<?= $dtOn ? $dtOn['codval'] : '' ?>">
        </div>
    <!--Parametros del valor-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Parametros</label>
            <input type="text" class="form-control" name="PARAVAL" value="<?= $dtOn ? $dtOn['PARAVAL'] : ''?>">
        </div>
    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Estado</label>
            <div class="w-100"></div>
            <?php foreach ($datEst as $estado) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estaval" id="estaval<?= (int) $estado['idval'] ?>" value="<?= (int) $estado['idval'] ?>" <?= ($dtOn && $dtOn['estaval'] == $estado['idval']) ? 'checked' : '' ?> required>
                <label class="form-check-label" for="estaval<?= (int) $estado['idval'] ?>"><?= htmlspecialchars((string) $estado['codval'], ENT_QUOTES, 'UTF-8') ?></label>
            </div>
            <?php } ?>
        </div>
    <!--Botones-->
        <div class="col-md-12 mt-4 text-end">
            <?php if ($dtOn) { ?>
            <a href="home.php?pg=27" class="btn btn-accent" aria-label="Cancelar edición" title="Cancelar">
                <i class="fa-solid fa-xmark"></i>
            </a>
            <?php } ?>
            <button type="submit" class="btn btn-primary" aria-label="Guardar valor">
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
        Lista de valores
    </h5>
    <div data-card-table data-card-sort-label="Valor" data-card-filters
         data-card-filter-active-label="Activos" data-card-filter-inactive-label="Inactivos">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xxl-4 g-3" data-card-list>
            <?php if ($datAll) { foreach ($datAll as $dt) {
                $codigoValor = htmlspecialchars((string) $dt['codval'], ENT_QUOTES, 'UTF-8');
                $valorActivo = $dt['estaval'] == 1;
            ?>
                <div class="col" data-card-item data-card-status="<?= $valorActivo ? 'active' : 'inactive' ?>" data-card-sort="<?= $codigoValor ?>">
                    <article class="card h-100 shadow-sm border-0">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 p-2">
                                        <i class="fa-solid fa-hashtag <?= $valorActivo ? 'text-success' : 'text-secondary' ?>" aria-hidden="true"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-truncate flex-grow-1" title="#<?= (int) $dt['idval'] ?> - <?= $codigoValor ?>">
                                        <span class="text-primary">#<?= (int) $dt['idval'] ?></span> - <?= $codigoValor ?>
                                    </h6>
                                    <span class="badge <?= $valorActivo ? 'bg-success' : 'bg-danger' ?> text-nowrap flex-shrink-0">
                                        <?= $valorActivo ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </div>
                                <div class="p-2 mb-2 rounded-3 border small">
                                    <span class="text-muted d-block">Dominio</span>
                                    <span class="fw-bold text-break"><i class="fa-solid fa-box me-1" aria-hidden="true"></i><?= htmlspecialchars((string) $dt['nomdom'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <div class="p-2 rounded-3 border small">
                                    <span class="text-muted d-block">Parámetros</span>
                                    <span class="text-break"><?= htmlspecialchars((string) $dt['PARAVAL'], ENT_QUOTES, 'UTF-8') ?: '—' ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 pt-0 pb-3 px-3 bg-white">
                            <hr class="mt-0 mb-3 text-muted opacity-25">
                            <div class="d-flex gap-2">
                                <a href="index.php?pg=27&ope=edi&idval=<?= (int) $dt['idval'] ?>" class="btn btn-accent shadow-sm flex-fill" title="Editar valor" aria-label="Editar <?= $codigoValor ?>">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=27&ope=toggle" method="POST" class="m-0 d-flex flex-fill">
                                    <input type="hidden" name="idval" value="<?= (int) $dt['idval'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfTokenCofval, ENT_QUOTES, 'UTF-8') ?>">
                                    <button type="submit" class="btn btn-outline-secondary shadow-sm w-100" title="<?= $valorActivo ? 'Desactivar' : 'Activar' ?> valor" aria-label="<?= $valorActivo ? 'Desactivar' : 'Activar' ?> <?= $codigoValor ?>">
                                        <i class="fa-solid <?= $valorActivo ? 'fa-toggle-on' : 'fa-toggle-off' ?>" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <a href="index.php?pg=27&ope=eli&idval=<?= (int) $dt['idval'] ?>" class="btn btn-outline-secondary shadow-sm flex-fill" title="Eliminar valor" aria-label="Eliminar <?= $codigoValor ?>" onclick="return confirm('¿Estás seguro de borrar?');">
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php }} else { ?>
                <div class="col-12 text-muted">No hay valores registrados.</div>
            <?php } ?>
        </div>
    </div>
</div>
