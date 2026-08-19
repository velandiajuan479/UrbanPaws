<?php require_once("controllers/ccofcof.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-gear"></i>
        Configuración del Sistema
    </h4>
    <form action="home.php?pg=25&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idconf" name="idconf" value="<?= $dtOn ? $dtOn['idconf'] : '' ?>">

        <!-- Nombre de la empresa -->
        <div class="col-md-4">
            <i class="fa-solid fa-building"></i>
            <label class="form-label">Nombre de la Empresa</label>
            <input type="text" class="form-control" name="nomcon" placeholder="Ej: UrbanPaws" required
                   value="<?= $dtOn ? $dtOn['nomcon'] : '' ?>">
        </div>

        <!-- Email -->
        <div class="col-md-4">
            <i class="fa-solid fa-envelope"></i>
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="emailcon" placeholder="correo@ejemplo.com" required
                   value="<?= $dtOn ? $dtOn['emailcon'] : '' ?>">
        </div>

        <!-- Teléfono -->
        <div class="col-md-4">
            <i class="fa-solid fa-phone"></i>
            <label class="form-label">Teléfono</label>
            <input type="tel" class="form-control" name="telecon" placeholder="3000000000"
                   value="<?= $dtOn ? $dtOn['telecon'] : '' ?>">
        </div>

        <!-- Logo (ruta o URL) con vista previa -->
        <div class="col-md-8">
            <i class="fa-solid fa-image"></i>
            <label class="form-label">Logo (ruta o URL)</label>
            <div class="input-group">
                <input type="text" class="form-control" name="logocon" placeholder="https://... o uploads/..."
                       value="<?= $dtOn ? $dtOn['logocon'] : '' ?>">
                <?php if ($dtOn && $dtOn['logocon']) { ?>
                <span class="input-group-text">
                    <img src="<?= $dtOn['logocon'] ?>" alt="logo" height="24">
                </span>
                <?php } ?>
            </div>
        </div>

        <!-- Estado: radios generados desde valor (dominio 1) -->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label class="form-label">Estado</label>
            <div class="w-100"></div>
            <?php if ($datEst) { foreach ($datEst AS $est) { ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="estacon"
                       id="est<?= $est['idval'] ?>" value="<?= $est['idval'] ?>" required
                       <?= ($dtOn && $dtOn['estacon'] == $est['idval']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="est<?= $est['idval'] ?>"><?= $est['codval'] ?></label>
            </div>
            <?php }} ?>
        </div>

        <!-- Botones -->
        <div class="col-md-12 mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent">
                <i class="fa-solid fa-trash fa-xl"></i>
            </button>
        </div>
    </form>
</div>

<div class="card card-form mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de configuraciones
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Configuración</th>
                    <th>Contacto</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                <tr>
                    <td>
                        <strong>
                            <?php if ($dt['logocon']) { ?>
                                <img src="<?= $dt['logocon'] ?>" height="24" class="me-1">
                            <?php } ?>
                            <?= $dt["idconf"] ?> <?= $dt["nomcon"] ?>
                        </strong>
                    </td>
                    <td>
                        <small>
                            Email: <?= $dt["emailcon"] ?>
                            <br>
                            Teléfono: <?= $dt["telecon"] ?>
                        </small>
                    </td>
                    <!-- Traducido por el LEFT JOIN con valor -->
                    <td><span class="badge <?= $dt['estacon'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                            <?= $dt['estacon'] == 1 ? 'Activo' : 'Inactivo' ?>
                        </span></td>
                    <td>
                        <a href="home.php?pg=25&ope=edi&idconf=<?= $dt['idconf'] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="home.php?pg=25&ope=eli&idconf=<?= $dt['idconf'] ?>" title="borrar"
                           onclick="return confirm('¿Eliminar la configuración?')">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Configuración</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>