<?php require_once("controllers/ccofpag.php"); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Formulario -->
        <div class="col-md-5">
            <div class="card p-3 mb-3">
                <h5><i class="fa-solid fa-plus"></i> Nueva Página</h5>
                <form method="POST" action="">
                    <input type="hidden" name="ope" value="save">
                    <input type="hidden" name="idpag" value="<?= isset($dtOn[0]['idpag']) ? $dtOn[0]['idpag'] : '' ?>">
                    
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Nombre de la página</label>
                        <input type="text" name="nompag" class="form-control form-control-sm" value="<?= isset($dtOn[0]['nompag']) ? $dtOn[0]['nompag'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Título de la página</label>
                        <input type="text" name="titpag" class="form-control form-control-sm" value="<?= isset($dtOn[0]['titpag']) ? $dtOn[0]['titpag'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Mostrar Página</label>
                        <select name="mostpag" class="form-select form-select-sm">
                            <option value="1" <?= (isset($dtOn[0]['mostpag']) && $dtOn[0]['mostpag']==1) ? 'selected' : '' ?>>Sí</option>
                            <option value="0" <?= (isset($dtOn[0]['mostpag']) && $dtOn[0]['mostpag']==0) ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Icono</label>
                        <input type="text" name="icopag" class="form-control form-control-sm" placeholder="fa-solid fa-house" value="<?= isset($dtOn[0]['icopag']) ? $dtOn[0]['icopag'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Ruta de la página</label>
                        <input type="text" name="rutpag" class="form-control form-control-sm" placeholder="views/vinicio.php" value="<?= isset($dtOn[0]['rutpag']) ? $dtOn[0]['rutpag'] : '' ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Orden de carga</label>
                        <input type="number" name="ordpag" class="form-control form-control-sm" value="<?= isset($dtOn[0]['ordpag']) ? $dtOn[0]['ordpag'] : '1' ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Descripción corta</label>
                        <textarea name="descpag" class="form-control form-control-sm" rows="2"><?= isset($dtOn[0]['descpag']) ? $dtOn[0]['descpag'] : '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Listado -->
        <div class="col-md-7">
            <div class="card p-3">
                <h5><i class="fa-solid fa-list"></i> Lista de páginas</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Título</th>
                                <th>Ruta</th>
                                <th>Mostrar</th>
                                <th>Orden</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($datAll){ foreach($datAll as $dt){ ?>
                            <tr>
                                <td><?= $dt['idpag'] ?></td>
                                <td><?= $dt['nompag'] ?></td>
                                <td><?= $dt['titpag'] ?></td>
                                <td><small><?= $dt['rutpag'] ?></small></td>
                                <td><?= $dt['mostpag'] == 1 ? ' Sí' : ' No' ?></td>
                                <td><?= $dt['ordpag'] ?></td>
                                <td>
                                    <a href="home.php?pg=<?= $_GET['pg'] ?>&ope=edi&idpag=<?= $dt['idpag'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                                    <a href="home.php?pg=<?= $_GET['pg'] ?>&ope=eli&idpag=<?= $dt['idpag'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php }} else { ?>
                            <tr><td colspan="7" class="text-center">No hay páginas registradas.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>