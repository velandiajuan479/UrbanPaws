<?php require_once("controllers/cserrutps.php"); ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Tus Rutas
        </div>
    </section>

    <section class="form-grid">
        <section>
            <span>Crea tu Ruta</span>
            <form class="card form-grid" id="formrutps" action="index.php?pg=32&iduser=<?= $iduser ?>&ope=save" method="POST">
                <input type="hidden" name="idrut" value="<?= $dtOn ? $dtOn['idrut'] : '' ?>">

                <div class="form-group col-md-11">
                    <label for="nomrut">Nombre Ruta: </label>
                    <input type="text" name="nomrut" id="nomrut" class="form-control" required
                        value="<?= $dtOn ? $dtOn['nomrut'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="distrut">Distancia (km): </label>
                    <input type="number" step="0.01" name="distrut" id="distrut" class="form-control"
                        value="<?= $dtOn ? $dtOn['distrut'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="precioini">Precio: </label>
                    <input type="number" name="precioini" id="precioini" class="form-control" required
                        value="<?= $dtOn ? $dtOn['precioini'] : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="horaini">Hora inicio: </label>
                    <input type="time" name="horaini" id="horaini" class="form-control" required
                        value="<?= $dtOn ? substr($dtOn['horaini'], 11, 5) : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="horafin">Hora fin: </label>
                    <input type="time" name="horafin" id="horafin" class="form-control" required
                        value="<?= $dtOn ? substr($dtOn['horafin'], 11, 5) : '' ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="idubi">Ubicación de la ruta: </label>
                    <select name="idubi" id="idubi" class="form-control form-select" required>
                        <option value="">Seleccionar ubicación...</option>
                        <?php if ($datUbi) { foreach ($datUbi AS $ubi) { ?>
                        <option value="<?= $ubi['idubi'] ?>"
                            <?= ($dtOn && $dtOn['idubi'] == $ubi['idubi']) ? 'selected' : '' ?>>
                            <?= $ubi['nomubi'] ?> — <?= $ubi['depaubi'] ?>
                        </option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="form-group col-md-11">
                    <label for="estarut">Estado: </label>
                    <select name="estarut" id="estarut" class="form-control form-select">
                        <option value="1" <?= ($dtOn && $dtOn['estarut'] == 1) ? 'selected' : '' ?>>Activa</option>
                        <option value="0" <?= ($dtOn && $dtOn['estarut'] == 0) ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Crear Ruta">
                </div>
            </form>
        </section>

        <section>
            <span>Tus Rutas</span>
            <div class="card p-3">
                <div class="table-responsive">
                    <table id="mitabla" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Distancia</th>
                                <th>Ubicación</th>
                                <th>Hora inicio</th>
                                <th>Hora fin</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                            <tr>
                                <td><strong><?= $dt['nomrut'] ?></strong></td>
                                <td><?= $dt['distrut'] ?> km</td>
                                <td><?= $dt['nomubi'] ? $dt['nomubi'] : '—' ?></td>
                                <td><?= substr($dt['horaini'], 11, 5) ?></td>
                                <td><?= substr($dt['horafin'], 11, 5) ?></td>
                                <td>$<?= number_format($dt['precioini'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($dt['estarut'] == 1) { ?>
                                        <span class="badge bg-success">Activa</span>
                                    <?php } else { ?>
                                        <span class="badge bg-secondary">Inactiva</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="index.php?pg=32&ope=edi&idrut=<?= $dt['idrut'] ?>&iduser=<?= $iduser ?>" title="editar">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="index.php?pg=32&ope=eli&idrut=<?= $dt['idrut'] ?>&iduser=<?= $iduser ?>" title="borrar"
                                       onclick="return confirm('¿Eliminar la ruta?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>