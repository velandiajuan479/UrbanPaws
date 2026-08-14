<?php require_once("controllers/ccofmod.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Módulo
    </h4>
    <form action="index.php?pg=24&ope=save" method="POST" class="row g-3">
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
        Lista de módulos
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Acceso</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                <tr>
                    <td>
                        <strong>
                            <i class="<?= $dt['icomod'] ?>"></i>
                            <?= $dt["idmod"] ?> <?= $dt["nommod"] ?>
                            <br>
                        </strong>
                        <small>Orden: <?= $dt["ordmod"] ?></small>
                    </td>
                    <td><?= $dt["nomperf"] ? $dt["nomperf"] : 'Sin usuarios' ?></td>
                    <!-- Traducido por el LEFT JOIN con valor -->
                    <td>
                        <span class="badge <?= $dt['estamod'] == '1' ? 'bg-success' : 'bg-danger' ?>">
                            <?= $dt['estamod'] == 1 ? 'Activo' : 'Inactivo' ?>
                        </span> 
                    </td>
                    <td>
                        <a href="index.php?pg=24&ope=edi&idmod=<?= $dt['idmod'] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="index.php?pg=24&ope=eli&idmod=<?= $dt['idmod'] ?>" title="borrar"
                           onclick="return confirm('¿Eliminar el módulo?')">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Módulo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>