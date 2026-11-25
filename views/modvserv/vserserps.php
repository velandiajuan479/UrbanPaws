<?php require_once __DIR__ . '/../../controllers/modcserv/cserserps.php'; ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-list-check fa-lg"></i>Solicitudes de paseo
        </div>

        <?= servRenderFlash($flash); ?>
        <?php if ($errorSolicitud) { ?>
            <div class="alert alert-danger"><?= servH($errorSolicitud) ?></div>
        <?php } ?>
    </section>

    <section>
        <div class="card col-12 p-3">
            <?php if (!empty($datAll)) { ?>
            <div class="table-responsive">
                <table id="mitabla" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Dirección</th>
                            <th>Cliente</th>
                            <th>Mascota</th>
                            <th>Fecha y hora</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datAll as $dt) { ?>
                        <tr>
                            <td>
                                <strong><?= servH($dt['nomrut']) ?></strong>
                                <?php if (!empty($dt['cancelacion_tardia'])) { ?>
                                    <div><span class="badge bg-warning text-dark">Cancelación tardía</span></div>
                                <?php } ?>
                            </td>
                            <td>
                                <?= servH($dt['direccion'] ?: 'Sin dirección') ?>
                                <?php if (!empty($dt['referencia'])) { ?>
                                    <div class="small text-muted"><?= servH($dt['referencia']) ?></div>
                                <?php } ?>
                            </td>
                            <td><?= servH(trim(($dt['prinom'] ?? '') . ' ' . ($dt['priapel'] ?? ''))) ?></td>
                            <td><?= servH($dt['nommasc'] ?: '—') ?></td>
                            <td>
                                <?= servH($dt['inicio_fmt'] ?: '—') ?>
                                <?php if (!empty($dt['fin_fmt'])) { ?>
                                    <div class="small text-muted">Hasta <?= servH($dt['fin_fmt']) ?></div>
                                <?php } ?>
                            </td>
                            <td><?= servPrice($dt['precio']) ?></td>
                            <td><?= servBadge($dt['estapas']) ?></td>
                            <td>
                                <?php if ($dt['estapas'] === 'Solicitado') { ?>
                                    <form action="home.php?pg=14&amp;ope=aceptar" method="POST" class="d-inline">
                                        <?= servCsrfField() ?>
                                        <input type="hidden" name="idpas" value="<?= (int) $dt['idpas'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                    </form>
                                    <form action="home.php?pg=14&amp;ope=rechazar" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Rechazar la solicitud?');">
                                        <?= servCsrfField() ?>
                                        <input type="hidden" name="idpas" value="<?= (int) $dt['idpas'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                                    </form>
                                <?php } else { ?>
                                    —
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="alert alert-info mb-0">No hay solicitudes de paseo registradas.</div>
            <?php } ?>
        </div>
    </section>
</section>
