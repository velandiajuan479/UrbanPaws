<?php
require_once 'models/helpers.php';
require_once 'models/musudatper.php';
require_once 'models/musuubi.php';

// Siempre se editan los datos de quien tiene la sesión iniciada (ya no se acepta ?iduser= en la URL).
$iduser = (int) ($_SESSION['iduser'] ?? 0);

$datper      = new mUsuDatPer();
$usuario     = $datper->getOne($iduser);
$ubicaciones = (new mUsuUbi())->getAll();

$errMsgs = [
    'campos'    => 'Escribe tu primer nombre, tu primer apellido y elige tu ubicación.',
    'email'     => 'Escribe un correo electrónico válido.',
    'telefono'  => 'El teléfono debe tener entre 7 y 15 dígitos.',
    'duplicado' => 'Ese correo o teléfono ya pertenece a otra cuenta.',
    'general'   => 'No se pudieron guardar los cambios. Inténtalo de nuevo.',
];
$ok  = (($_GET['ok'] ?? '') === '1');
$err = $errMsgs[$_GET['err'] ?? ''] ?? null;

if ($usuario) {
    $nombre  = trim($usuario['prinom'] . ' ' . $usuario['priapel']);
    $inicial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($nombre, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($nombre, 0, 1));
}
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Tu espacio personal</span>
        <h1>Datos personales</h1>
        <p>Mantén tu información de contacto al día para que podamos avisarte de tus servicios.</p>
    </div>
</div>

<?php if ($ok) { ?><div class="alert alert-success" role="status">Tus datos se guardaron correctamente.</div><?php } ?>
<?php if ($err) { ?><div class="alert alert-danger" role="alert"><?= up_e($err) ?></div><?php } ?>

<?php if (!$usuario) { ?>
    <div class="alert alert-warning" role="alert">No encontramos tu información. Cierra sesión e inicia de nuevo.</div>
<?php } else { ?>
<section class="profile-layout">
    <article class="card profile-card">
        <div class="profile-avatar" aria-hidden="true"><?= up_e($inicial) ?></div>
        <h2><?= up_e($nombre) ?></h2>
        <p>Cuenta #<?= (int) $usuario['iduser'] ?></p>
        <div class="profile-divider"></div>
        <dl class="profile-details">
            <div><dt><i class="fa-solid fa-fingerprint" aria-hidden="true"></i>Documento</dt><dd><?= up_e($usuario['docu']) ?></dd></div>
            <div><dt><i class="fa-solid fa-envelope" aria-hidden="true"></i>Correo</dt><dd><?= up_e($usuario['emailu']) ?></dd></div>
            <div><dt><i class="fa-solid fa-phone" aria-hidden="true"></i>Teléfono</dt><dd><?= up_e($usuario['teleu'] ?: 'Sin teléfono') ?></dd></div>
            <div><dt><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ubicación</dt><dd><?= $usuario['nomubi'] ? up_e($usuario['nomubi'] . ', ' . $usuario['depaubi']) : 'Sin ubicación' ?></dd></div>
        </dl>
    </article>

    <div class="profile-side">
        <section class="card">
            <h4 class="section-title"><i class="fa-solid fa-id-card" aria-hidden="true"></i>Editar mis datos</h4>
            <form action="controllers/cusudatper.php" method="post" class="row g-3">
                <?= up_csrf_field() ?>
                <input type="hidden" name="ope" value="actualizar">

                <div class="col-md-6">
                    <label for="prinom" class="form-label"><i class="fa-solid fa-user" aria-hidden="true"></i>Primer nombre</label>
                    <input type="text" class="form-control" name="prinom" id="prinom" maxlength="100" autocomplete="given-name"
                           value="<?= up_e($usuario['prinom']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="seconom" class="form-label">Segundo nombre <small class="text-muted">(opcional)</small></label>
                    <input type="text" class="form-control" name="seconom" id="seconom" maxlength="100" autocomplete="additional-name"
                           value="<?= up_e($usuario['seconom']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="priapel" class="form-label">Primer apellido</label>
                    <input type="text" class="form-control" name="priapel" id="priapel" maxlength="100" autocomplete="family-name"
                           value="<?= up_e($usuario['priapel']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="emailu" class="form-label"><i class="fa-solid fa-envelope" aria-hidden="true"></i>Correo electrónico</label>
                    <input type="email" class="form-control" name="emailu" id="emailu" maxlength="255" autocomplete="email"
                           value="<?= up_e($usuario['emailu']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="teleu" class="form-label"><i class="fa-solid fa-phone" aria-hidden="true"></i>Teléfono</label>
                    <input type="tel" class="form-control" name="teleu" id="teleu" maxlength="20" inputmode="tel" autocomplete="tel"
                           pattern="\+?[0-9 \-]{7,20}" placeholder="3001234567" value="<?= up_e($usuario['teleu']) ?>">
                </div>
                <div class="col-md-6">
                    <label for="idubi" class="form-label"><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ciudad o ubicación</label>
                    <select class="form-select" name="idubi" id="idubi" data-autocomplete required>
                        <option value="">Selecciona tu ciudad</option>
                        <?php foreach ($ubicaciones as $u) { ?>
                            <option value="<?= (int) $u['idubi'] ?>" <?= ((int) $u['idubi'] === (int) $usuario['idubi']) ? 'selected' : '' ?>>
                                <?= up_e($u['nomubi'] . ' - ' . $u['depaubi']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline">Deshacer cambios</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>Guardar cambios
                    </button>
                </div>
            </form>
        </section>
    </div>
</section>
<?php } ?>
