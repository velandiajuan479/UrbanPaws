<?php require_once("controllers/csersercl.php"); ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Mis Servicios
        </div>

        <?php if (!$iduser) { ?>
            <div class="alert alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                No hay cliente seleccionado. Entra con: <code>index.php?pg=14&iduser=X</code>
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
                                <th>Mascota</th>
                                <th>Paseador</th>
                                <th>Hora inicio</th>
                                <th>Hora fin</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                            <tr>
                                <td><strong><?= $dt['nomrut'] ?></strong></td>
                                <td><?= $dt['nommasc'] ? $dt['nommasc'] : '—' ?></td>
                                <td><?= $dt['prinom'] . ' ' . $dt['priapel'] ?></td>
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
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </section>
</section>