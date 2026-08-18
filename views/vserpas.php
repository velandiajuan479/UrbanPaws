<?php require_once("controllers/cserpas.php"); ?>

<section class="container mb-5">
    <section style="padding: 3rem 0 2rem;">
        <div class="section-title">
            <i class="fa-solid fa-route fa-lg"></i>Paseos
        </div>

        <?php if (!$idrut || !$dtRut) { ?>
            <div class="alert alert-warning">
                <i class="fa-solid fa-triangle-exclamation"></i>
                No has seleccionado ninguna ruta. Entra desde
                <a href="index.php?pg=11&iduser=<?= $iduser ?>">Ruta Cliente</a>
                y pulsa <strong>Agendar Ruta</strong>.
            </div>
        <?php } ?>
    </section>

    <?php if ($dtRut) { ?>
    <section class="form-grid">
        <section>
            <span>Información Ruta y precio</span>
            <div class="card form-grid p-3">
                <div class="form-group col-md-11">
                    <label for="nomrut">Nombre Ruta: </label>
                    <input type="text" name="nomrut" id="nomrut" class="form-control" readonly
                        value="<?= $dtRut['nomrut'] ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="distrut">Distancia: </label>
                    <input type="text" name="distrut" id="distrut" class="form-control" readonly
                        value="<?= $dtRut['distrut'] ?> km">
                </div>
                <div class="form-group col-md-11">
                    <label for="horaini">Hora inicio: </label>
                    <input type="text" name="horaini" id="horaini" class="form-control" readonly
                        value="<?= substr($dtRut['horaini'], 11, 5) ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="horafin">Hora fin: </label>
                    <input type="text" name="horafin" id="horafin" class="form-control" readonly
                        value="<?= substr($dtRut['horafin'], 11, 5) ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="precioini">Precio: </label>
                    <input type="text" name="precioini" id="precioini" class="form-control" readonly
                        value="$<?= number_format($dtRut['precioini'], 0, ',', '.') ?>">
                </div>
            </div>
        </section>

        <section>
            <span>Información del Paseador a cargo de la ruta</span>
            <form action="index.php?pg=13&iduser=<?= $iduser ?>&idrut=<?= $dtRut['idrut'] ?>&ope=save"
                  class="card form-grid" method="POST" id="formpas">

                <div class="form-group col-md-11">
                    <label for="foto">Foto: </label>
                    <?php if ($dtRut['foto']) { ?>
                        <img src="<?= $dtRut['foto'] ?>" alt="Foto del paseador" height="90" class="rounded-circle">
                    <?php } else { ?>
                        <i class="fa-solid fa-user fa-3x text-secondary"></i>
                    <?php } ?>
                </div>
                <div class="form-group col-md-11">
                    <label for="prinom">Nombre Paceador: </label>
                    <input type="text" name="prinom" id="prinom" class="form-control" readonly
                        value="<?= $dtRut['prinom'] . ' ' . $dtRut['priapel'] ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="docu">Documento: </label>
                    <input type="text" name="docu" id="docu" class="form-control" readonly
                        value="<?= $dtRut['docu'] ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="emailu">Email: </label>
                    <input type="text" name="emailu" id="emailu" class="form-control" readonly
                        value="<?= $dtRut['emailu'] ?>">
                </div>
                <div class="form-group col-md-11">
                    <label for="teleu">Teléfono: </label>
                    <input type="text" name="teleu" id="teleu" class="form-control" readonly
                        value="<?= $dtRut['teleu'] ?>">
                </div>

                <div class="form-group col-md-11">
                    <label for="idmasc">Mascota: </label>
                    <select name="idmasc" id="idmasc" class="form-control form-select" required>
                        <option value="">Seleccionar mascota...</option>
                        <?php if ($datMas) { foreach ($datMas AS $mas) { ?>
                        <option value="<?= $mas['idmasc'] ?>"><?= $mas['nommasc'] ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="form-group col-md-11">
                    <label for="servtipo">Tipo de servicio: </label>
                    <input type="text" name="servtipo" id="servtipo" class="form-control"
                        placeholder="Ej: Paseo diario, Paseo grupal...">
                </div>
                <div class="form-group col-md-11">
                    <label for="descserv">Descripción: </label>
                    <textarea name="descserv" id="descserv" rows="3" class="form-control"
                        placeholder="Notas para el paseador..."></textarea>
                </div>

                <div class="form-group col-md-6">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Agendar Paseo">
                </div>
            </form>
        </section>
    </section>
    <?php } ?>
</section>