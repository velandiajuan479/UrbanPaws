<?php require_once("controllers/cserrutcl.php"); ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Rutas
        </div>

        <div class="card p-3">
            <h1>Información Cliente</h1>
            <p>
                Estas son las rutas disponibles
                <?php if ($dtCli && $dtCli['nomubi']) { ?>
                    para tu ubicación: <strong><?= $dtCli['nomubi'] ?></strong>.
                <?php } else { ?>
                    para tu ubicación.
                <?php } ?>
                Elige una y pulsa <strong>Agendar Ruta</strong>.
            </p>
        </div>
    </section>

    <section class="form-grid">
        <section>
            <span>Ubicación de Ruta</span>
            <div class="card col-10 p-3">
                Api ..... mapa de la ruta
            </div>
        </section>

        <section>
            <span>Rutas Disponibles</span>
            <div class="card col-12 p-3">
                <?php if (!$iduser) { ?>
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        No hay cliente seleccionado. Entra con: <code>index.php?pg=11&iduser=X</code>
                    </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="mitabla" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Paseador</th>
                                <th>Hora inicio</th>
                                <th>Hora fin</th>
                                <th>Precio</th>
                                <th>Agendar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                            <tr>
                                <td><strong><?= $dt['nomrut'] ?></strong></td>
                                <td>
                                    <?php if ($dt['foto']) { ?>
                                        <img src="<?= $dt['foto'] ?>" height="30" class="rounded-circle me-1">
                                    <?php } else { ?>
                                        <i class="fa-solid fa-user"></i>
                                    <?php } ?>
                                    <?= $dt['prinom'] . ' ' . $dt['priapel'] ?>
                                </td>
                                <td><?= substr($dt['horaini'], 11, 5) ?></td>
                                <td><?= substr($dt['horafin'], 11, 5) ?></td>
                                <td>$<?= number_format($dt['precioini'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="index.php?pg=13&iduser=<?= $iduser ?>&idrut=<?= $dt['idrut'] ?>"
                                       class="btn btn-primary btn-sm">
                                        <strong>Agendar Ruta</strong>
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