<?php require_once("controllers/ccofval.php");?>
<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-box-open"></i>
        Nuevo Valor
    </h4> 
    
    <form action="index.php?pg=27&ope=save" method="POST" class="row g-3">
        <input type="hidden" id="idval" name="idval" value="<?= $dtOn ? $dtOn['idval'] : '' ?>">
    <!--Selección de dominio-->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label" for="">Dominio</label>
            <div class="input-group">
                <select name="iddom" id="" class="form-control form-select">
                    <option value="0">Selecciona Dominio</option>
                    <?php if($dtdom) { foreach($dtdom AS $dd){?>
                    <option value="<?= $dd["iddom"];?>" <?= ($dtOn && $dtOn["iddom"] == $dd["iddom"]) ? 'selected' : '' ?>>
                        <?= $dd["nomdom"]; ?>
                    </option>
                    <?php }}?>
                </select>
            </div>
        </div>
    <!--Nombre del módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Nombre de valor</label>
            <input type="text" class="form-control" name="codval" placeholder="C.C" required value="<?= $dtOn ? $dtOn['codval'] : '' ?>">
        </div>
    <!--Parametros del valor-->
        <div class="col-md-4">
            <i class="fa-solid fa-hashtag"></i>
            <label for="" class="form-label">Parametros</label>
            <input type="text" class="form-control" name="PARAVAL" required value="<?= $dtOn ? $dtOn['PARAVAL'] : ''?>">
        </div>
    <!--Estado del Módulo-->
        <div class="col-md-4">
            <i class="fa-solid fa-toggle-on"></i>
            <label for="" class="form-label">Estado</label>
            <div class="w-100"></div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estaval" id="actv" value="1" <?= ($dtOn && $dtOn['estaval'] == 1) ? 'checked' : '' ?> required>
            <label class="form-check-label" for="actv">Activo</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estaval" id="inactv" value="2" <?= ($dtOn && $dtOn['estaval'] == 2) ? 'checked' : '' ?> required>
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
        Lista de valores
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Dominio</th>
                    <th>Valores</th>
                    <th>Parametros</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tablebody">
                <?php if($datAll) { foreach ($datAll AS $dt){?>
                <tr>
                    <td> <?= $dt["idval"] ?> </td>
                    <td>
                        <?= $dt["nomdom"] ?>
                    </td>
                    <td>
                        <?= $dt["codval"] ?>
                    </td>
                    <td>
                        <?= $dt["PARAVAL"] ?>
                    </td>
                    <td> <span class="badge <?= $dt['estaval'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                            <?= $dt['estaval'] == 1 ? 'Activo' : 'Inactivo' ?>
                        </span> 
                    </td>
                    <td>
                        <a href="index.php?pg=27&ope=edi&idval=<?= $dt["idval"] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="index.php?pg=27&ope=eli&idval=<?= $dt["idval"] ?>" title="borrar" onclick="return confirm('¿Estás seguro de borrar?');">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }}?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Codigo</th>
                    <th>Dominio</th>
                    <th>Valores</th>
                    <th>Parametros</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>