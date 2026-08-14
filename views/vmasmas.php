<?php require_once("controllers/cmasmas.php"); ?>
<div class="card card-form p-4">
    <h4 class="section-title">
        <i class="fa-solid fa-paw"></i>
        Nuevo Registro de Mascota
    </h4>
    <form action="index.php?pg=27&ope=save" method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="idmasc" value="<?= $dtOn ? $dtOn['idmasc'] : '' ?>">

        <!-- Nombre -->
        <div class="col-md-4">
            <i class="fa-solid fa-heart"></i>
            <label class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nommasc" placeholder="Ej: Luna, Max..." required
                   value="<?= $dtOn ? $dtOn['nommasc'] : '' ?>">
        </div>

        <!-- Sexo -->
        <div class="col-md-4">
            <i class="fa-solid fa-venus-mars"></i>
            <label class="form-label">Sexo <span class="text-danger">*</span></label>
            <select name="sexmasc" class="form-control form-select" required>
                <option value="">Seleccionar...</option>
                <option value="Macho"  <?= ($dtOn && $dtOn['sexmasc']=='Macho')  ? 'selected' : '' ?>>Macho</option>
                <option value="Hembra" <?= ($dtOn && $dtOn['sexmasc']=='Hembra') ? 'selected' : '' ?>>Hembra</option>
            </select>
        </div>

        <!-- Raza -->
        <div class="col-md-4">
            <i class="fa-solid fa-paw"></i>
            <label class="form-label">Raza <span class="text-danger">*</span></label>
            <select name="razamasc" class="form-control form-select" required>
                <option value="">Seleccionar raza...</option>
                <?php
                $razas = ["Labrador Retriever","Pastor Alemán","Bulldog (Inglés / Francés)","Poodle / Caniche",
                          "Cocker Spaniel","Schnauzer","Beagle","Criollo Colombiano","Golden Retriever","Mestizo / Mixto"];
                foreach($razas AS $rz){ ?>
                <option value="<?= $rz ?>" <?= ($dtOn && $dtOn['razamasc']==$rz) ? 'selected' : '' ?>><?= $rz ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Dueño -->
        <div class="col-md-4">
            <i class="fa-solid fa-user"></i>
            <label class="form-label">Dueño</label>
            <select name="iduser" class="form-control form-select">
                <option value="">Sin dueño</option>
                <?php if ($datDuen) { foreach ($datDuen AS $du) { ?>
                <option value="<?= $du['iduser'] ?>"
                    <?= ($dtOn && $dtOn['iduser'] == $du['iduser']) ? 'selected' : '' ?>>
                    <?= $du['nomuser'] ?> (<?= $du['docu'] ?>)
                </option>
                <?php }} ?>
            </select>
        </div>

        <!-- Foto de la mascota -->
        <div class="col-md-4">
            <i class="fa-solid fa-camera"></i>
            <label class="form-label">Foto de la mascota</label>
            <input type="file" class="form-control" name="fotomasc" accept=".jpg,.jpeg,.png">
            <input type="hidden" name="fotomasc_old" value="<?= $dtOn ? $dtOn['fotomasc'] : '' ?>">
            <?php if ($dtOn && $dtOn['fotomasc']) { ?>
                <img src="<?= $dtOn['fotomasc'] ?>" alt="foto mascota" height="50" class="mt-2 rounded">
            <?php } ?>
        </div>

        <!-- Carnet de vacunas -->
        <div class="col-md-4">
            <i class="fa-solid fa-syringe"></i>
            <label class="form-label">Carnet de Vacunas <small>(JPG, PNG o PDF máx. 5MB)</small></label>
            <input type="file" class="form-control" name="fotovacu" accept=".pdf,.jpg,.jpeg,.png">
            <input type="hidden" name="fotovacu_old" value="<?= $dtOn ? $dtOn['fotovacu'] : '' ?>">
            <?php if ($dtOn && $dtOn['fotovacu']) { ?>
                <a href="<?= $dtOn['fotovacu'] ?>" target="_blank" class="d-block mt-2">
                    <i class="fa-solid fa-file-medical"></i> Ver carnet actual
                </a>
            <?php } ?>
        </div>

        <!-- Descripción -->
        <div class="col-md-6">
            <i class="fa-solid fa-align-left"></i>
            <label class="form-label">Descripción / Notas</label>
            <textarea class="form-control" name="descmasc" rows="3"
                      placeholder="Temperamento, rutina, preferencias..."><?= $dtOn ? $dtOn['descmasc'] : '' ?></textarea>
        </div>

        <!-- Enfermedades -->
        <div class="col-md-6">
            <i class="fa-solid fa-notes-medical"></i>
            <label class="form-label">Enfermedades / Alergias</label>
            <textarea class="form-control" name="enfermasc" rows="2"
                      placeholder="Escribe 'Ninguna' o detalla condiciones..."><?= $dtOn ? $dtOn['enfermasc'] : '' ?></textarea>
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
        Historial de Mascotas
    </h5>
    <div class="table-responsive">
        <table id="mitabla" class="table table-striped">
            <thead>
                <tr>
                    <th>Mascota</th>
                    <th>Sexo</th>
                    <th>Dueño</th>
                    <th>Detalles</th>
                    <th>Carnet</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($datAll) { foreach ($datAll AS $dt) { ?>
                <tr>
                    <td>
                        <strong>
                            <?php if ($dt['fotomasc']) { ?>
                                <img src="<?= $dt['fotomasc'] ?>" height="35" class="rounded me-1">
                            <?php } else { ?>
                                <i class="fa-solid fa-paw"></i>
                            <?php } ?>
                            <?= $dt["idmasc"] ?> <?= $dt["nommasc"] ?>
                        </strong>
                        <br>
                        <small>Raza: <?= $dt["razamasc"] ?></small>
                    </td>
                    <td>
                        <?php if ($dt["sexmasc"] == 'Hembra') { ?>
                            <span class="badge bg-danger"><i class="fa-solid fa-venus"></i> Hembra</span>
                        <?php } else { ?>
                            <span class="badge bg-primary"><i class="fa-solid fa-mars"></i> Macho</span>
                        <?php } ?>
                    </td>
                    <td><?= $dt["nomdueno"] ? $dt["nomdueno"] : 'Sin dueño' ?></td>
                    <td>
                        <small>
                            <?= $dt["descmasc"] ?>
                            <br>
                            <em>Enfermedades:</em> <?= $dt["enfermasc"] ?>
                        </small>
                    </td>
                    <td>
                        <?php if ($dt["fotovacu"]) { ?>
                            <a href="<?= $dt['fotovacu'] ?>" target="_blank" title="Ver carnet">
                                <i class="fa-solid fa-file-medical fa-2x"></i>
                            </a>
                        <?php } else { echo '—'; } ?>
                    </td>
                    <td>
                        <a href="index.php?pg=27&ope=edi&idmasc=<?= $dt['idmasc'] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <a href="index.php?pg=27&ope=eli&idmasc=<?= $dt['idmasc'] ?>" title="borrar"
                           onclick="return confirm('¿Eliminar la mascota?')">
                            <i class="fa-solid fa-trash-can fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>