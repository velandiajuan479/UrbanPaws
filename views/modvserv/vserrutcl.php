<?php require_once __DIR__ . '/../../controllers/modcserv/cserrutcl.php'; ?>

<?php
$mapTitulo = 'Ubicación de la ruta';
$mapDireccion = !empty($datAll) ? ($datAll[0]['direccion_rut'] ?? '') : '';
$mapReferencia = !empty($datAll) ? ($datAll[0]['referencia_rut'] ?? '') : '';
?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Rutas disponibles
        </div>

        <?= servRenderFlash($flash); ?>

        <div class="card p-3">
            <h1 class="h4">Información del cliente</h1>
            <p class="mb-0">
                Estas son las rutas activas
                <?php if (!empty($dtCli['nomubi'])) { ?>
                    para tu ubicación: <strong><?= servH($dtCli['nomubi']) ?></strong>.
                <?php } else { ?>
                    disponibles para agendar.
                <?php } ?>
                Elige una y pulsa <strong>Agendar paseo</strong>.
            </p>
        </div>
    </section>

    <section class="form-grid">
        <section>
            <span>Mapa de la ruta</span>
            <?php include __DIR__ . '/vserpmap.php'; ?>
        </section>

        <section>
            <span>Rutas disponibles</span>
            <div class="card col-12 p-3">
                <?php if (!empty($datAll)) { ?>
                <div class="table-responsive">
                    <table id="mitabla" class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Paseador</th>
                                <th>Dirección</th>
                                <th>Horario</th>
                                <th>Precio</th>
                                <th>Agendar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datAll as $dt) { ?>
                            <tr>
                                <td>
                                    <strong><?= servH($dt['nomrut']) ?></strong>
                                    <div class="small text-muted"><?= servH($dt['nomubi'] ?: 'Sin zona') ?></div>
                                </td>
                                <td>
                                    <?php if (!empty($dt['foto'])) { ?>
                                        <img src="<?= servH($dt['foto']) ?>" height="30" class="rounded-circle me-1" alt="">
                                    <?php } else { ?>
                                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                                    <?php } ?>
                                    <?= servH(trim(($dt['prinom'] ?? '') . ' ' . ($dt['priapel'] ?? ''))) ?>
                                </td>
                                <td>
                                    <?= servH($dt['direccion_rut'] ?: 'Sin dirección') ?>
                                    <?php if (!empty($dt['referencia_rut'])) { ?>
                                        <div class="small text-muted"><?= servH($dt['referencia_rut']) ?></div>
                                    <?php } ?>
                                </td>
                                <td><?= servH($dt['horaini_fmt']) ?> - <?= servH($dt['horafin_fmt']) ?></td>
                                <td><?= servPrice($dt['precioini']) ?></td>
                                <td>
                                    <a href="home.php?pg=13&amp;idrut=<?= (int) $dt['idrut'] ?>"
                                       class="btn btn-primary btn-sm">
                                        Agendar paseo
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    <div class="alert alert-info mb-0">No hay rutas activas disponibles por el momento.</div>
                <?php } ?>
            </div>
        </section>
    </section>
</section>
