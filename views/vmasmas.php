<?php require_once("controllers/cmasmas.php"); ?>
<div class="card card-form p-4">
    <?php if (!empty($errorMascota)) { ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errorMascota, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>
    <h4 class="section-title">
        <i class="fa-solid fa-paw"></i>
        Nuevo Registro de Mascota
    </h4>

    <form action="home.php?pg=9&ope=save" method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="idmasc" value="<?= $dtOn ? $dtOn['idmasc'] : '' ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

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

        <!-- Raza: alimentada desde la tabla valor (dominio raza) -->
        <div class="col-md-4">
            <i class="fa-solid fa-paw"></i>
            <label class="form-label">Raza <span class="text-danger">*</span></label>
            <select name="razamasc" class="form-control form-select" data-autocomplete required>
                <option value="">Seleccionar raza...</option>
                <?php if ($datRaz) { foreach ($datRaz AS $rz) { ?>
                <option value="<?= $rz['codval'] ?>"
                    <?= ($dtOn && $dtOn['razamasc'] == $rz['codval']) ? 'selected' : '' ?>>
                    <?= $rz['codval'] ?>
                </option>
                <?php }} ?>
            </select>
        </div>

        <!-- Foto de la mascota -->
        <div class="col-md-6">
            <i class="fa-solid fa-camera"></i>
            <label class="form-label">Foto de la mascota <small>(JPG o PNG, máx. 5 MB)</small></label>
            <input type="file" class="form-control" name="fotomasc" accept=".jpg,.jpeg,.png" data-preview="infoFotomasc">
            <small id="infoFotomasc" class="form-text"></small>
            <?php if ($dtOn && !empty($dtOn['fotomasc'])) { ?>
                <button type="button" class="btn btn-link p-0 mt-2" data-preview-src="<?= htmlspecialchars($dtOn['fotomasc'], ENT_QUOTES, 'UTF-8') ?>" data-preview-mode="image" data-preview-title="Foto de <?= htmlspecialchars($dtOn['nommasc'], ENT_QUOTES, 'UTF-8') ?>">
                    <img src="<?= htmlspecialchars($dtOn['fotomasc'], ENT_QUOTES, 'UTF-8') ?>"
                         alt="Ver foto actual de la mascota" height="50" class="rounded">
                </button>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="quitarfotomasc" value="1" id="quitarFotoMasc">
                    <label class="form-check-label" for="quitarFotoMasc">Quitar la foto actual</label>
                </div>
            <?php } ?>
        </div>

        <!-- Carnet de vacunas -->
        <div class="col-md-6">
            <i class="fa-solid fa-syringe"></i>
            <label class="form-label">Carnet de Vacunas <small>(JPG, PNG o PDF, máx. 5 MB)</small></label>
            <input type="file" class="form-control" name="fotovacu" accept=".pdf,.jpg,.jpeg,.png" data-preview="infoFotovacu">
            <small id="infoFotovacu" class="form-text"></small>
            <?php if ($dtOn && !empty($dtOn['fotovacu'])) {
                $extVac = strtolower((string) pathinfo($dtOn['fotovacu'], PATHINFO_EXTENSION)); ?>
                <button type="button" class="btn btn-link p-0 mt-2" data-preview-src="<?= htmlspecialchars($dtOn['fotovacu'], ENT_QUOTES, 'UTF-8') ?>" data-preview-mode="frame" data-preview-title="Carnet de vacunas de <?= htmlspecialchars($dtOn['nommasc'], ENT_QUOTES, 'UTF-8') ?>" title="Ver carnet actual">
                    <?php if (in_array($extVac, ['jpg', 'jpeg', 'png'], true)) { ?>
                        <img src="<?= htmlspecialchars($dtOn['fotovacu'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="Carnet de vacunas actual" height="60" class="mt-2 rounded">
                    <?php } else { ?>
                        <i class="fa-solid fa-file-medical"></i> Ver carnet actual
                    <?php } ?>
                </button>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="quitarfotovacu" value="1" id="quitarFotoVacu">
                    <label class="form-check-label" for="quitarFotoVacu">Quitar el carnet actual</label>
                </div>
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
            <button type="submit" class="btn btn-primary" aria-label="Guardar mascota">
                <i class="fa-solid fa-floppy-disk fa-xl"></i>
            </button>
            <button type="reset" class="btn btn-accent" aria-label="Limpiar formulario">
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
                    <th>Raza</th>
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
                            <?php if (!empty($dt['fotomasc'])) { ?>
                                <button type="button" class="btn btn-link p-0" data-preview-src="<?= htmlspecialchars($dt['fotomasc'], ENT_QUOTES, 'UTF-8') ?>" data-preview-mode="image" data-preview-title="Foto de <?= htmlspecialchars($dt['nommasc'], ENT_QUOTES, 'UTF-8') ?>">
                                    <img src="<?= htmlspecialchars($dt['fotomasc'], ENT_QUOTES, 'UTF-8') ?>" alt="Ver foto de la mascota" height="35" class="rounded me-1">
                                </button>
                            <?php } else { ?>
                                <i class="fa-solid fa-paw"></i>
                            <?php } ?>
                            <?= (int) $dt["idmasc"] ?> <?= htmlspecialchars($dt["nommasc"], ENT_QUOTES, 'UTF-8') ?>
                        </strong>
                    </td>
                    <td>
                        <?php if ($dt["sexmasc"] == 'Hembra') { ?>
                            <span class="badge bg-danger"><i class="fa-solid fa-venus"></i> Hembra</span>
                        <?php } else { ?>
                            <span class="badge bg-primary"><i class="fa-solid fa-mars"></i> Macho</span>
                        <?php } ?>
                    </td>
                    <td><?= $dt["razamasc"] ?></td>
                    <td><?= $dt["nomdueno"] ? $dt["nomdueno"] : 'Sin dueño' ?></td>
                    <td>
                        <small>
                            <?= $dt["descmasc"] ?>
                            <br>
                            <em>Enfermedades:</em> <?= $dt["enfermasc"] ?>
                        </small>
                    </td>
                    <td>
                        <?php if (!empty($dt["fotovacu"])) {
                            $extTabla = strtolower((string) pathinfo($dt['fotovacu'], PATHINFO_EXTENSION)); ?>
                            <button type="button" class="btn btn-link p-0" data-preview-src="<?= htmlspecialchars($dt['fotovacu'], ENT_QUOTES, 'UTF-8') ?>" data-preview-mode="frame" data-preview-title="Carnet de vacunas de <?= htmlspecialchars($dt['nommasc'], ENT_QUOTES, 'UTF-8') ?>" title="Ver carnet">
                                <?php if (in_array($extTabla, ['jpg', 'jpeg', 'png'], true)) { ?>
                                    <img src="<?= htmlspecialchars($dt['fotovacu'], ENT_QUOTES, 'UTF-8') ?>" alt="Carnet de vacunas" height="35" class="rounded">
                                <?php } else { ?>
                                    <i class="fa-solid fa-file-medical fa-2x"></i>
                                <?php } ?>
                            </button>
                        <?php } else { echo '—'; } ?>
                    </td>
                    <td>
                        <a href="home.php?pg=9&ope=edi&idmasc=<?= (int) $dt['idmasc'] ?>" title="editar">
                            <i class="fa-solid fa-pencil fa-2x"></i>
                        </a>
                        <form action="home.php?pg=9&ope=eli" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar la mascota?')">
                            <input type="hidden" name="idmasc" value="<?= (int) $dt['idmasc'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-link p-0" title="borrar" aria-label="Eliminar <?= htmlspecialchars($dt['nommasc'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-solid fa-trash-can fa-2x"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalVistaArchivoMascota" tabindex="-1" aria-labelledby="tituloVistaArchivoMascota" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloVistaArchivoMascota">Previsualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagenVistaArchivoMascota" class="img-fluid d-none" alt="Previsualización de mascota">
                <iframe id="marcoVistaArchivoMascota" class="w-100 d-none" height="600" title="Previsualización del carnet"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('modalVistaArchivoMascota');
    var imagen = document.getElementById('imagenVistaArchivoMascota');
    var marco = document.getElementById('marcoVistaArchivoMascota');
    var titulo = document.getElementById('tituloVistaArchivoMascota');

    document.addEventListener('click', function (event) {
        var boton = event.target.closest('[data-preview-src]');
        if (!boton || !modal) { return; }

        titulo.textContent = boton.getAttribute('data-preview-title') || 'Previsualización';
        if (boton.getAttribute('data-preview-mode') === 'image') {
            imagen.src = boton.getAttribute('data-preview-src');
            imagen.classList.remove('d-none');
            marco.classList.add('d-none');
            marco.removeAttribute('src');
        } else {
            marco.src = boton.getAttribute('data-preview-src');
            marco.classList.remove('d-none');
            imagen.classList.add('d-none');
            imagen.removeAttribute('src');
        }
        bootstrap.Modal.getOrCreateInstance(modal).show();
    });

    modal.addEventListener('hidden.bs.modal', function () {
        imagen.removeAttribute('src');
        marco.removeAttribute('src');
    });

    var LIMITE = 5 * 1024 * 1024; // 5 MB
    var inputs = document.querySelectorAll('input[type="file"][data-preview]');
    Array.prototype.forEach.call(inputs, function (input) {
        input.addEventListener('change', function () {
            var salida = document.getElementById(input.getAttribute('data-preview'));
            if (!salida) { return; }
            var archivo = input.files && input.files[0];
            if (!archivo) {
                salida.textContent = '';
                salida.classList.remove('text-danger');
                return;
            }
            var mb = (archivo.size / (1024 * 1024)).toFixed(2);
            if (archivo.size > LIMITE) {
                salida.textContent = archivo.name + ' (' + mb + ' MB): supera el límite de 5 MB.';
                salida.classList.add('text-danger');
            } else {
                salida.textContent = archivo.name + ' (' + mb + ' MB)';
                salida.classList.remove('text-danger');
            }
        });
    });
})();
</script>
