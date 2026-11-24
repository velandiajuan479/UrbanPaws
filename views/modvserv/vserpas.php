<?php require_once __DIR__ . '/../../controllers/modcserv/cserpas.php'; ?>

<?php
$fechaVal = $form['fecha'] ?? date('Y-m-d', strtotime('+1 day'));
$horaInicioVal = $form['hora_inicio'] ?? ($dtRut['horaini_fmt'] ?? '');
$horaFinVal = $form['hora_fin'] ?? ($dtRut['horafin_fmt'] ?? '');
$idmascVal = $form['idmasc'] ?? '';
$servtipoVal = $form['servtipo'] ?? 'Individual';
$descservVal = $form['descserv'] ?? '';
$mapTitulo = 'Ubicación de la ruta';
$mapDireccion = $dtRut['direccion_rut'] ?? '';
$mapReferencia = $dtRut['referencia_rut'] ?? '';
$minFecha = date('Y-m-d', strtotime('+1 day'));
?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-person-walking fa-lg"></i>Agendar paseo
        </div>

        <?= servRenderFlash($flash); ?>
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

    <?php if (!$dtRut) { ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            No has seleccionado una ruta válida.
            <a href="home.php?pg=11">Volver a rutas disponibles</a>.
        </div>
    <?php } else { ?>
    <section class="form-grid">
        <section>
            <span>Información de la ruta</span>
            <div class="card p-3 mb-3">
                <p class="mb-1"><strong>Ruta:</strong> <?= servH($dtRut['nomrut']) ?></p>
                <p class="mb-1"><strong>Paseador:</strong> <?= servH(trim(($dtRut['prinom'] ?? '') . ' ' . ($dtRut['priapel'] ?? ''))) ?></p>
                <p class="mb-1"><strong>Dirección:</strong> <?= servH($dtRut['direccion_rut'] ?: 'Sin dirección') ?></p>
                <p class="mb-1"><strong>Referencia:</strong> <?= servH($dtRut['referencia_rut'] ?: 'Sin referencia') ?></p>
                <p class="mb-1"><strong>Horario de la ruta:</strong> <?= servH($dtRut['horaini_fmt']) ?> - <?= servH($dtRut['horafin_fmt']) ?></p>
                <p class="mb-0"><strong>Precio:</strong> <?= servPrice($dtRut['precioini']) ?></p>
            </div>
            <?php include __DIR__ . '/vserpmap.php'; ?>
        </section>

        <section>
            <span>Datos del paseo</span>
            <form action="home.php?pg=13&amp;idrut=<?= (int) $dtRut['idrut'] ?>&amp;ope=save" method="POST" class="card form-grid" id="formpas">
                <?= servCsrfField() ?>
                <input type="hidden" name="idrut" value="<?= (int) $dtRut['idrut'] ?>">

                <div class="form-group col-md-11">
                    <label for="fecha">Fecha del paseo</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required
                           min="<?= servH($minFecha) ?>" value="<?= servH($fechaVal) ?>">
                </div>

                <div class="form-group col-md-5">
                    <label for="hora_inicio">Hora de recogida</label>
                    <input type="time" step="1800" name="hora_inicio" id="hora_inicio" class="form-control" required
                           value="<?= servH($horaInicioVal) ?>">
                </div>

                <div class="form-group col-md-5">
                    <label for="hora_fin">Hora de fin</label>
                    <input type="time" step="1800" name="hora_fin" id="hora_fin" class="form-control" required
                           value="<?= servH($horaFinVal) ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="idmasc">Mascota</label>
                    <select name="idmasc" id="idmasc" class="form-control form-select" required>
                        <option value="">Seleccionar mascota...</option>
                        <?php if (is_array($datMas)) { foreach ($datMas as $mas) { ?>
                            <option value="<?= (int) $mas['idmasc'] ?>" <?= (int) $idmascVal === (int) $mas['idmasc'] ? 'selected' : '' ?>>
                                <?= servH($mas['nommasc']) ?>
                            </option>
                        <?php }} ?>
                    </select>
                    <?php if (empty($datMas)) { ?>
                        <div class="form-text">No tienes mascotas registradas. <a href="home.php?pg=9">Registrar mascota</a>.</div>
                    <?php } ?>
                </div>

                <div class="form-group col-md-11">
                    <label for="servtipo">Tipo de servicio</label>
                    <select name="servtipo" id="servtipo" class="form-control form-select" required>
                        <?php if (is_array($datServ) && $datServ) { foreach ($datServ as $serv) { ?>
                            <option value="<?= servH($serv['codval']) ?>" <?= $servtipoVal === $serv['codval'] ? 'selected' : '' ?>>
                                <?= servH($serv['codval']) ?>
                            </option>
                        <?php }} else { ?>
                            <option value="Individual" <?= $servtipoVal === 'Individual' ? 'selected' : '' ?>>Individual</option>
                            <option value="Grupal" <?= $servtipoVal === 'Grupal' ? 'selected' : '' ?>>Grupal</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-11">
                    <label for="descserv">Descripción o notas</label>
                    <textarea name="descserv" id="descserv" rows="3" class="form-control"
                              placeholder="Indicaciones para el paseador..."><?= servH($descservVal) ?></textarea>
                </div>

                <div class="form-group col-md-11">
                    <button type="submit" class="btn btn-primary">Solicitar paseo</button>
                    <a href="home.php?pg=11" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </section>
    </section>
        <?php } ?>
</section>
