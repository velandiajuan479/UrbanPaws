<?php require_once("./controllers/modcpqr/cpqr.php"); ?>
<?php $h = function ($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }; ?>
<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-message fa-lg"></i>Radicar PQRSF
        </div>
        <p class="text-muted mb-0">Registra una petición, queja, reclamo, sugerencia o felicitación. Tu radicación queda asociada a tu cuenta.</p>
    </section>

    <?php if ($msgOk !== '') { ?>
        <div class="alert alert-success" role="alert"><?= $h($msgOk) ?></div>
    <?php } ?>
    <?php if ($msgErr !== '') { ?>
        <div class="alert alert-danger" role="alert"><?= $h($msgErr) ?></div>
    <?php } ?>

    <section class="form-grid">
        <form action="home.php?pg=21&ope=save" method="POST" class="card form-grid" id="formpqr">
            <input type="hidden" name="csrf_token" value="<?= $h($csrfTokenPqr) ?>">

            <div class="form-group col-md-11">
                <label for="tippqr">Tipo de PQRSF <span class="text-danger">*</span></label>
                <select name="tippqr" id="tippqr" class="form-control" required>
                    <option value="">Selecciona una opción</option>
                    <?php foreach ($tiposPqr AS $tipo) { ?>
                        <option value="<?= $h($tipo) ?>"><?= $h($tipo) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-11">
                <label for="fechpqr">Fecha de radicación</label>
                <input type="text" id="fechpqr" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
            </div>

            <div class="form-group col-md-11">
                <label for="descpqr">Descripción <span class="text-danger">*</span></label>
                <textarea name="descpqr" id="descpqr" class="form-control" rows="6" minlength="10" maxlength="2000" required placeholder="Cuéntanos con detalle el motivo de tu PQRSF..."></textarea>
                <div class="form-text">Mínimo 10 caracteres. Máximo 2000 caracteres.</div>
            </div>

            <div class="col-12 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Enviar PQRSF
                </button>
                <a href="home.php?pg=1" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </section>

    <section class="mt-4">
        <h2 class="section-title">
            <i class="fa-solid fa-clock-rotate-left fa-lg"></i>Mis PQRSF
        </h2>
        <div class="card p-3">
            <div class="table-responsive">
                <table id="mitabla" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($datPqr) { foreach ($datPqr AS $dt) { ?>
                        <tr>
                            <td><strong><?= (int) $dt['idpqr'] ?></strong></td>
                            <td><?= $h($dt['fechpqr']) ?></td>
                            <td><span class="badge bg-secondary"><?= $h($dt['tippqr']) ?></span></td>
                            <td><?= nl2br($h($dt['descpqr'])) ?></td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>
