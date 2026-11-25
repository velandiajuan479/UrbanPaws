<?php require_once __DIR__ . '/../../controllers/modcserv/csersercl.php'; ?>

<?php
$esVistaPaseador = $esPaseador && !$esAdmin;
$colPersona = $esVistaPaseador ? 'Cliente' : 'Paseador';
$tituloPagina = $esAdmin ? 'Servicios y multas' : ($esVistaPaseador ? 'Paseos asignados' : 'Mis servicios');
$tituloTabla = $esAdmin ? 'Todos los servicios' : ($esVistaPaseador ? 'Paseos como paseador' : 'Historial de servicios');
?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i><?= servH($tituloPagina) ?>
        </div>

        <?= servRenderFlash($flash); ?>
        <?php if ($errorServicio) { ?>
            <div class="alert alert-danger"><?= servH($errorServicio) ?></div>
        <?php } ?>
    </section>

    <section>
        <span><?= servH($tituloTabla) ?></span>
        <div class="card col-12 p-3">
            <?php if (!empty($datAll)) { ?>
            <div class="table-responsive">
                <table id="mitabla" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Dirección</th>
                            <th>Mascota</th>
                            <th><?= servH($colPersona) ?></th>
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
                                <?php if (!empty($dt['fecha_cancelacion'])) { ?>
                                    <div class="small text-muted">Cancelado: <?= servFecha($dt['fecha_cancelacion']) ?></div>
                                <?php } ?>
                            </td>
                            <td>
                                <?= servH($dt['direccion'] ?: 'Sin dirección') ?>
                                <?php if (!empty($dt['referencia'])) { ?>
                                    <div class="small text-muted"><?= servH($dt['referencia']) ?></div>
                                <?php } ?>
                            </td>
                            <td><?= servH($dt['nommasc'] ?: '—') ?></td>
                            <td>
                                <?php if ($esVistaPaseador) { ?>
                                    <?= servH(trim(($dt['prinom'] ?? '') . ' ' . ($dt['priapel'] ?? ''))) ?: '—' ?>
                                <?php } else { ?>
                                    <?= servH(trim(($dt['prinomps'] ?? '') . ' ' . ($dt['priapelps'] ?? ''))) ?: '—' ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?= servH($dt['inicio_fmt'] ?: '—') ?>
                                <?php if (!empty($dt['fin_fmt'])) { ?>
                                    <div class="small text-muted">Hasta <?= servH($dt['fin_fmt']) ?></div>
                                <?php } ?>
                            </td>
                            <td><?= servPrice($dt['precio']) ?></td>
                            <td><?= servBadge($dt['estapas']) ?></td>
                            <td>
                                <?php $puedeCancelar = $esAdmin || (int) $dt['iduser'] === $iduser; ?>
                                <?php if ($puedeCancelar && in_array($dt['estapas'], ['Solicitado', 'Aceptado'], true)) { ?>
                                    <form action="home.php?pg=15&amp;ope=cancelar" method="POST" class="d-flex gap-1"
                                          onsubmit="return confirm('¿Cancelar este paseo?');">
                                        <?= servCsrfField() ?>
                                        <input type="hidden" name="idpas" value="<?= (int) $dt['idpas'] ?>">
                                        <input type="text" name="motivo" class="form-control form-control-sm"
                                               placeholder="Motivo" maxlength="255">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Cancelar</button>
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
                <div class="alert alert-info mb-0">
                    <?= $esVistaPaseador ? 'No tienes paseos asignados.' : 'No hay servicios registrados.' ?>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php if ($esAdmin) { ?>
        <?php include __DIR__ . '/vsermul.php'; ?>
    <?php } ?>
</section>
