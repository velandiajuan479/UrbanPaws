<?php
require_once 'models/musuubi.php';
$ubi = new mUsuUbi();
$datAll = $ubi->getAll();
?>

<div class="card card-form p-4">
    <!-- SECCIÓN 1: FORMULARIO DE REGISTRO -->
    <h4 class="section-title">
        <i class="fa-solid fa-location-dot"></i>
        Nueva Ubicación
    </h4>

    <form action="controllers/cusuubi.php" method="POST" class="row g-3">
        <input type="hidden" name="ope" value="guardar">
        <!--Nombre de la ubicación-->
        <div class="col-md-6">
            <i class="fa-solid fa-city"></i>
            <label for="nomubi" class="form-label">Ciudad / Municipio</label>
            <input type="text" class="form-control" name="nomubi" id="nomubi" placeholder="Ej: Chía" required>
        </div>
        <!--Departamento-->
        <div class="col-md-6">
            <i class="fa-solid fa-map"></i>
            <label for="depaubi" class="form-label">Departamento</label>
            <input type="text" class="form-control" name="depaubi" id="depaubi" placeholder="Ej: Cundinamarca" required>
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

<div class="table-container mt-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-table-list"></i>
        Lista de ubicaciones
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Ciudad / Municipio</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if($datAll){ foreach ($datAll as $dt) { ?>
                <tr>
                    <td><?=$dt['nomubi'];?></td>
                    <td><?=$dt['depaubi'];?></td>
                    <td>
                        <a href="#" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="controllers/cusuubi.php?ope=borrar&idubi=<?=$dt['idubi'];?>" title="borrar" onclick="return confirm('¿Está seguro que desea eliminar esta ubicación?');">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Ciudad / Municipio</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>