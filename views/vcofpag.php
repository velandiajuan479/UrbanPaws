<?php require_once("controllers/ccofpag.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nueva Página
    </h4>
    <form action="index.php?pg=23&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idpag" name="idpag" value="<?= $dtOn ? $dtOn['idpag'] : '' ?>">

        <!-- Nombre de la página -->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label class="form-label">Nombre de la página</label>
            <input type="text" class="form-control" name="nompag" placeholder="Servicio" required
                value="<?= $dtOn ? $dtOn['nompag'] : '' ?>">
        </div>

        <!-- Título de la página -->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label class="form-label">Titulo de la página</label>
            <input type="text" class="form-control" name="titpag" placeholder="Reporte de PQRS" required
                value="<?= $dtOn ? $dtOn['titpag'] : '' ?>">
        </div>

        <!-- Mostrar Página: radios generados desde valor (dominio 1) -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Mostrar Página</label>
            <div class="w-100"></div>
            <?php if ($datEst) { foreach ($datEst AS $est) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="mostpag"
                    id="est<?= $est['idval'] ?>" value="<?= $est['idval'] ?>" required
                    <?= ($dtOn && $dtOn['mostpag'] == $est['idval']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="est<?= $est['idval'] ?>"><?= $est['codval'] ?></label>
            </div>
            <?php }} ?>
        </div>

        <!-- Icono: select generado desde valor (dominio 2) -->
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
            <i class="fa-solid fa-folder"></i>
            <label class="form-label">Ruta de la página</label>
            <input class="form-control" type="text" name="rutpag" placeholder="views/vcofcof.php"
                    value="<?= $dtOn ? $dtOn['rutpag'] : '' ?>">
        </div>

        <!-- Orden de carga (se agregó name="ordpag" que faltaba) -->
        <div class="col-md-4">
            <i class="fa-solid fa-sort"></i>
            <label class="form-label">Orden de carga</label>
            <input type="number" class="form-control" name="ordpag" id="ordpag" placeholder="Ej:10"
                    value="<?= $dtOn ? $dtOn['ordpag'] : '' ?>">
        </div>

        <!-- Descripción corta -->
        <div class="col-md-4">
            <i class="fa-solid fa-clipboard"></i>
            <label class="form-label">Descripción corta</label>
            <input class="form-control" type="text" name="descpag" placeholder="descripción"
                    value="<?= $dtOn ? $dtOn['descpag'] : '' ?>">
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
                    <th>Descripcion</th>
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
                            Titulo: <?= $dt["titpag"] ?> Ruta: <?= $dt["rutpag"] ?>
                            <br>
                            Orden: <?= $dt["ordpag"] ?>
                        </small>
                    </td>
                    <td><small><?= $dt["descpag"] ?></small></td>
                    <td><?= $dt["nommost"] ?></td>
                    <td>
                        <a href="index.php?pg=23&ope=edi&idpag=<?= $dt['idpag'] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="index.php?pg=23&ope=eli&idpag=<?= $dt['idpag'] ?>" title="borrar"
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
                    <th>Mostrar</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>