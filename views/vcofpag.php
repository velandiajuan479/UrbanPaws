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
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent">
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
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Página</th>
                    <th>Descripción</th>
                    <th>Mostrar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                    <tr>
                        <td>
                            <strong>
                                <i class="<?= $dt['icopag'] ?>"></i>
                                <?= $dt["idpag"] ?> <?= $dt["nompag"] ?>
                                <br>
                            </strong>
                            <small>
                                Título: <?= $dt["titpag"] ?> &nbsp;|&nbsp;
                                Ruta: <?= $dt["rutpag"] ?> &nbsp;|&nbsp;
                                Orden: <?= $dt["ordpag"] ?>
                            </small>
                        </td>
                        <td><?= $dt["descpag"] ?></td>
                        <td>
                            <span class="badge <?= $dt['mostpag'] == '1' ? 'bg-success' : 'bg-danger' ?>">
                                <?= $dt['mostpag'] == '1' ? 'Sí' : 'No' ?>
                            </span>
                        </td>
                        <td>
                            <a href="home.php?pg=23&ope=edi&idpag=<?= $dt['idpag'] ?>" title="editar">
                                <i class="fa-solid fa-pencil fa-2x"></i>
                            </a>
                            <a href="home.php?pg=23&ope=eli&idpag=<?= $dt['idpag'] ?>" title="borrar"
                               onclick="return confirm('¿Eliminar la página?')">
                                <i class="fa-solid fa-trash-can fa-2x"></i>
                            </a>
                        </td>
                    </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Página</th>
                    <th>Descripción</th>
                    <th>Mostrar</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>