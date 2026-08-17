<?php require_once("controllers/cserserps.php"); ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Solicitudes de Paseo
        </div>

        <?php if (!$iduser) { ?>
            <div class="alert alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                No hay paseador seleccionado. Entra con: <code>index.php?pg=15&iduser=X</code>
            </div>
        <?php } ?>
    </section>

    <section class="form-grid">
        <section>
            <div class="card col-12 p-3">
                <div class="table-responsive">
                    <table id="mitabla" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Cliente</th>
                                <th>Mascota</th>
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
                                <td><?= $dt['prinom'] . ' ' . $dt['priapel'] ?></td>
                                <td><?= $dt['nommasc'] ? $dt['nommasc'] : '—' ?></td>
                                <td><?= substr($dt['horaini'], 11, 5) ?></td>
                                <td><?= substr($dt['horafin'], 11, 5) ?></td>
                                <td>$<?= number_format($dt['precioini'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($dt['estapas'] == 'Aceptado') { ?>
                                        <span class="badge bg-success">Aceptado</span>
                                    <?php } elseif ($dt['estapas'] == 'Rechazado') { ?>
                                        <span class="badge bg-danger">Rechazado</span>
                                    <?php } else { ?>
                                        <span class="badge bg-warning text-dark"><?= $dt['estapas'] ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($dt['estapas'] == 'Solicitado') { ?>
                                        <a href="index.php?pg=15&ope=aceptar&idpas=<?= $dt['idpas'] ?>&iduser=<?= $iduser ?>"
                                           class="btn btn-success btn-sm">Aceptar</a>
                                        <a href="index.php?pg=15&ope=rechazar&idpas=<?= $dt['idpas'] ?>&iduser=<?= $iduser ?>"
                                           class="btn btn-danger btn-sm" onclick="return confirm('¿Rechazar la solicitud?')">Rechazar</a>
                                    <?php } else { echo '—'; } ?>
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