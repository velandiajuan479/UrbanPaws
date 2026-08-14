<?php
require_once("controllers/ccofdom.php");
?>
<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Dominio
    </h4> 
    
    <form action="index.php?pg=26&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="iddom" name="iddom" value="<?= $dtOn ? $dtOn['iddom'] : '' ?>">


    <!--Nombre del módulo-->

        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre del dominio</label>
            <input type="text" name="nomdom" class="form-control" placeholder="Tipo de documento" required value="<?= $dtOn ? $dtOn["nomdom"] : '' ?>">
        </div>

    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Estado</label>
            <div class="w-100"></div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="actdom" id="actv" value="1" <?= ($dtOn && $dtOn['actdom'] == 1) ? 'checked' : '' ?> required>
            <label class="form-check-label" for="actv">Activo</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="actdom" id="inactv" value="2" <?= ($dtOn && $dtOn['actdom'] == 2) ? 'checked' : '' ?> required>
            <label class="form-check-label" for="inactv">Inactivo</label>
            </div>
        </div>
    <!--Botones-->
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
        Lista de dominios
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Dominio</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if($datAll) { foreach ($datAll as $dt){ ?>
                <tr>
                    <td><?= $dt["iddom"] ?></td>
                    <td>
                        <strong>
                            <i class="fa fa-box"></i>
                            <?= $dt["nomdom"] ?>
                            <br>
                        </strong>
                    </td>
                    <td>
                        <span class="badge <?= $dt['actdom'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                            <?= $dt['actdom'] == 1 ? 'Activo' : 'Inactivo' ?>
                        </span> 
                    </td>
                    <td>
                        <a href="index.php?pg=26&ope=edi&iddom=<?= $dt["iddom"] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="index.php?pg=26&ope=eli&iddom=<?= $dt["iddom"] ?>" title="borrar" onclick="return confirm('¿Estás seguro de borrar?');">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Dominio</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>