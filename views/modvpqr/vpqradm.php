<?php require_once("./controllers/modcpqr/cpqradm.php"); ?>
<?php
$h = function ($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); };
$badges = [
    'Peticion'     => 'bg-primary',
    'Queja'        => 'bg-warning text-dark',
    'Reclamo'      => 'bg-danger',
    'Sugerencia'   => 'bg-info text-dark',
    'Felicitacion' => 'bg-success',
];
?>
<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-inbox fa-lg"></i>PQRFS
        </div>
        <p class="text-muted mb-0">Todas las PQRSF radicadas por clientes y paseadores, ordenadas de la más reciente a la más antigua.</p>
    </section>

    <div class="alert alert-info d-flex align-items-center gap-2" role="status">
        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
        <span>Total de radicaciones: <strong><?= (int) $totalPqr ?></strong></span>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table id="mitabla" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Contacto</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                    <tr>
                        <td><strong><?= (int) $dt['idpqr'] ?></strong></td>
                        <td><?= $h($dt['fechpqr']) ?></td>
                        <td>
                            <span class="badge <?= isset($badges[$dt['tippqr']]) ? $badges[$dt['tippqr']] : 'bg-secondary' ?>">
                                <?= $h($dt['tippqr']) ?>
                            </span>
                        </td>
                        <td>
                            <strong><?= $h(trim($dt['prinom'] . ' ' . $dt['priapel'])) ?></strong>
                            <br><small class="text-muted">Doc. <?= $h($dt['docu']) ?></small>
                        </td>
                        <td><?= $h($dt['nomperf']) ?></td>
                        <td>
                            <?= $h($dt['emailu']) ?>
                            <br><small class="text-muted"><?= $h($dt['teleu']) ?></small>
                        </td>
                        <td><?= nl2br($h($dt['descpqr'])) ?></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
