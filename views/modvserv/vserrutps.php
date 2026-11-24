<?php require_once __DIR__ . '/../../controllers/modcserv/cserrutps.php'; ?>

<?php
$nomrutVal = array_key_exists('nomrut', $form) ? $form['nomrut'] : ($dtOn['nomrut'] ?? '');
$direccionVal = array_key_exists('direccion_rut', $form) ? $form['direccion_rut'] : ($dtOn['direccion_rut'] ?? '');
$referenciaVal = array_key_exists('referencia_rut', $form) ? $form['referencia_rut'] : ($dtOn['referencia_rut'] ?? '');
$distrutVal = array_key_exists('distrut', $form) ? $form['distrut'] : ($dtOn['distrut'] ?? '');
$idubiVal = array_key_exists('idubi', $form) ? $form['idubi'] : ($dtOn['idubi'] ?? '');
$precioVal = array_key_exists('precioini', $form) ? $form['precioini'] : ($dtOn['precioini'] ?? '');
$horainiVal = array_key_exists('horaini', $form) ? $form['horaini'] : ($dtOn['horaini_fmt'] ?? '');
$horafinVal = array_key_exists('horafin', $form) ? $form['horafin'] : ($dtOn['horafin_fmt'] ?? '');
$estarutVal = array_key_exists('estarut', $form) ? $form['estarut'] : ($dtOn['estarut'] ?? 1);
$mapTitulo = 'Ubicación de la ruta';
$mapDireccion = $direccionVal;
$mapReferencia = $referenciaVal;
?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i><?= $esAdmin ? 'Rutas registradas' : 'Tus rutas' ?>
        </div>

        <?= servRenderFlash($flash); ?>
        <?php if ($errorRuta) { ?>
            <div class="alert alert-danger"><?= servH($errorRuta) ?></div>
        <?php } ?>
        <?php if ($errores) { ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $error) { ?>
                        <li><?= servH($error) ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </section>

    <?php if (!$puedeGestionar) { ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Para crear rutas necesitas el perfil <strong>Paseador</strong> o <strong>Admin</strong>.
        </div>
    <?php } else { ?>
    <section class="form-grid">
        <section>
            <span><?= $dtOn ? 'Editar ruta' : 'Crear ruta' ?></span>
            <form class="card form-grid" id="formrutps" action="home.php?pg=12&amp;ope=save" method="POST">
                <?= servCsrfField() ?>
                <input type="hidden" name="idrut" value="<?= $dtOn ? (int) $dtOn['idrut'] : 0 ?>">

                <div class="form-group col-md-11">
                    <label for="nomrut">Nombre de la ruta</label>
                    <input type="text" name="nomrut" id="nomrut" class="form-control" required maxlength="50"
                           value="<?= servH($nomrutVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="direccion_rut">Dirección escrita</label>
                    <input type="text" name="direccion_rut" id="direccion_rut" class="form-control" required maxlength="255"
                           placeholder="Ej: Calle 123 #45-67, barrio La Esperanza"
                           value="<?= servH($direccionVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="referencia_rut">Punto de referencia</label>
                    <input type="text" name="referencia_rut" id="referencia_rut" class="form-control" maxlength="255"
                           placeholder="Ej: Frente al parque"
                           value="<?= servH($referenciaVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="distrut">Distancia aproximada (km)</label>
                    <input type="number" step="0.01" min="0" name="distrut" id="distrut" class="form-control"
                           value="<?= servH($distrutVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="idubi">Ubicación</label>
                    <select name="idubi" id="idubi" class="form-control form-select">
                        <option value="0" <?= (int) $idubiVal === 0 ? 'selected' : '' ?>>Sin zona específica</option>
                        <?php if (is_array($datUbi)) { foreach ($datUbi as $ubi) { ?>
                            <option value="<?= (int) $ubi['idubi'] ?>" <?= (int) $idubiVal === (int) $ubi['idubi'] ? 'selected' : '' ?>>
                                <?= servH($ubi['nomubi']) ?> — <?= servH($ubi['depaubi']) ?>
                            </option>
                        <?php }} ?>
                    </select>
                </div>

                <div class="form-group col-md-11">
                    <label for="precioini">Precio base</label>
                    <input type="number" step="0.01" min="0" name="precioini" id="precioini" class="form-control" required
                           value="<?= servH($precioVal) ?>">
                </div>

                <div class="form-group col-md-5">
                    <label for="horaini">Hora inicio</label>
                    <input type="time" step="1800" name="horaini" id="horaini" class="form-control" required
                           value="<?= servH($horainiVal) ?>">
                </div>

                <div class="form-group col-md-5">
                    <label for="horafin">Hora fin</label>
                    <input type="time" step="1800" name="horafin" id="horafin" class="form-control" required
                           value="<?= servH($horafinVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="estarut">Estado</label>
                    <select name="estarut" id="estarut" class="form-control form-select">
                        <option value="1" <?= (int) $estarutVal === 1 ? 'selected' : '' ?>>Activa</option>
                        <option value="2" <?= (int) $estarutVal === 2 ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </div>

                <div class="form-group col-md-11">
                    <button type="submit" class="btn btn-primary"><?= $dtOn ? 'Actualizar ruta' : 'Crear ruta' ?></button>
                    <?php if ($dtOn) { ?>
                        <a href="home.php?pg=12" class="btn btn-secondary">Cancelar edición</a>
                    <?php } ?>
                </div>
            </form>
        </section>

        <section>
            <span>Vista previa del mapa</span>
            <?php include __DIR__ . '/vserpmap.php'; ?>
        </section>
    </section>

    <section class="mt-4">
        <span>Rutas registradas</span>
        <div class="card p-3">
            <?php if (!empty($datAll)) { ?>
            <div class="table-responsive">
                <table id="mitabla" class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Ruta</th>
                            <th>Dirección</th>
                            <th>Ubicación</th>
                            <th>Horario</th>
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
                                <div class="small text-muted"><?= servH(trim(($dt['prinom'] ?? '') . ' ' . ($dt['priapel'] ?? ''))) ?></div>
                            </td>
                            <td>
                                <?= servH($dt['direccion_rut'] ?: 'Sin dirección') ?>
                                <?php if (!empty($dt['referencia_rut'])) { ?>
                                    <div class="small text-muted"><?= servH($dt['referencia_rut']) ?></div>
                                <?php } ?>
                            </td>
                            <td><?= servH($dt['nomubi'] ?: 'Sin zona') ?></td>
                            <td><?= servH($dt['horaini_fmt']) ?> - <?= servH($dt['horafin_fmt']) ?></td>
                            <td><?= servPrice($dt['precioini']) ?></td>
                            <td>
                                <?php if ((int) $dt['estarut'] === 1) { ?>
                                    <span class="badge bg-success">Activa</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">Inactiva</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="home.php?pg=12&amp;ope=edi&amp;idrut=<?= (int) $dt['idrut'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="home.php?pg=12&amp;ope=eli&amp;idrut=<?= (int) $dt['idrut'] ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar la ruta?');">
                                    <?= servCsrfField() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="alert alert-info mb-0">Todavía no tienes rutas registradas.</div>
            <?php } ?>
        </div>
    </section>
    <?php } ?>
</section>
