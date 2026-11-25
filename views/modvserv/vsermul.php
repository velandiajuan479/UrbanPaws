<?php if (!isset($datMul) || !is_array($datMul)) { $datMul = []; } ?>

<section id="multas" class="mt-4">
    <span>Multas y advertencias</span>
    <div class="card p-3">
        <p class="text-muted">
            La multa automática sugerida es de <?= servPrice(50000) ?>. Al llegar a 3 cancelaciones tardías
            se registra como <strong>Pendiente</strong> y el administrador puede ajustar el monto, aplicarla,
            marcarla como pagada, anularla o vetar al usuario.
        </p>

        <?php if (!empty($datMul)) { ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Advertencias</th>
                        <th>Cancelaciones tardías</th>
                        <th>Multa</th>
                        <th>Estado</th>
                        <th>Veto</th>
                        <th>Observación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datMul as $dt) { ?>
                    <tr>
                        <td>
                            <strong><?= servH(trim(($dt['prinom'] ?? '') . ' ' . ($dt['priapel'] ?? ''))) ?></strong>
                            <div class="small text-muted"><?= servH($dt['emailu'] ?? '') ?></div>
                        </td>
                        <td><?= (int) $dt['advusr'] ?></td>
                        <td><?= (int) $dt['cancelaciones_tardias'] ?></td>
                        <td><?= servPrice($dt['multausr']) ?></td>
                        <td><?= servBadge($dt['sancionusr'] ?: 'Sin sanción') ?></td>
                        <td>
                            <?php if (!empty($dt['vetousr'])) { ?>
                                <span class="badge bg-danger">Sí</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">No</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?= servH($dt['obssancion'] ?: '—') ?>
                            <?php if (!empty($dt['fecsancion'])) { ?>
                                <div class="small text-muted"><?= servFecha($dt['fecsancion']) ?></div>
                            <?php } ?>
                        </td>
                        <td>
                            <form action="home.php?pg=15&amp;ope=mul_save" method="POST" class="row g-2 align-items-end">
                                <?= servCsrfField() ?>
                                <input type="hidden" name="iduser_sancion" value="<?= (int) $dt['iduser'] ?>">
                                <div class="col-6">
                                    <label class="form-label small mb-1" for="multausr_<?= (int) $dt['iduser'] ?>">Monto</label>
                                    <input type="number" step="0.01" min="0" class="form-control form-control-sm"
                                           id="multausr_<?= (int) $dt['iduser'] ?>" name="multausr"
                                           value="<?= servH(number_format((float) $dt['multausr'], 2, '.', '')) ?>">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small mb-1" for="sancionusr_<?= (int) $dt['iduser'] ?>">Estado</label>
                                    <select class="form-select form-select-sm" id="sancionusr_<?= (int) $dt['iduser'] ?>" name="sancionusr">
                                        <option value="" <?= empty($dt['sancionusr']) ? 'selected' : '' ?>>Sin sanción</option>
                                        <?php foreach (['Pendiente', 'Aplicada', 'Pagada', 'Anulada'] as $estado) { ?>
                                            <option value="<?= servH($estado) ?>" <?= $dt['sancionusr'] === $estado ? 'selected' : '' ?>><?= servH($estado) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vetousr" value="1"
                                               id="vetousr_<?= (int) $dt['iduser'] ?>" <?= !empty($dt['vetousr']) ? 'checked' : '' ?>>
                                        <label class="form-check-label small" for="vetousr_<?= (int) $dt['iduser'] ?>">Vetar</label>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
            <div class="alert alert-info mb-0">No hay usuarios con advertencias o multas registradas.</div>
        <?php } ?>
    </div>
</section>
