<?php
require_once("controllers/cusupef.php");

if (!is_array($dtOn)) {
    $dtOn = array();
}

$prinom  = isset($dtOn['prinom'])  ? (string) $dtOn['prinom']  : '';
$seconom = isset($dtOn['seconom']) ? (string) $dtOn['seconom'] : '';
$priapel = isset($dtOn['priapel']) ? (string) $dtOn['priapel'] : '';
$segapel = isset($dtOn['segapel']) ? (string) $dtOn['segapel'] : '';
$docu    = isset($dtOn['docu'])    ? (string) $dtOn['docu']    : '';
$emailu  = isset($dtOn['emailu'])  ? (string) $dtOn['emailu']  : '';
$teleu   = isset($dtOn['teleu'])   ? (string) $dtOn['teleu']   : '';
$fotoRel = isset($dtOn['foto'])    ? (string) $dtOn['foto']    : '';
$nomubi  = isset($dtOn['nomubi'])  ? (string) $dtOn['nomubi']  : '';
$depaubi = isset($dtOn['depaubi']) ? (string) $dtOn['depaubi'] : '';
$nomperf = isset($dtOn['nomperf']) ? trim((string) $dtOn['nomperf']) : trim((string) ($_SESSION['nomperf'] ?? ''));
$profileId = (int) ($_SESSION['iduser'] ?? 0);

$nombreCompleto = trim($prinom . ' ' . $seconom . ' ' . $priapel . ' ' . $segapel);
if ($nombreCompleto === '') {
    $nombreCompleto = trim((string) ($_SESSION['prinom'] ?? $_SESSION['nomusr'] ?? ''));
}
if ($nombreCompleto === '') {
    $nombreCompleto = 'Usuario UrbanPaws';
}

// Foto de perfil: solo se muestra si el archivo existe realmente en disco
$hayFoto = ($fotoRel !== '' && is_file(dirname(__DIR__) . '/' . ltrim(str_replace('\\', '/', $fotoRel), '/')));
$iniciales = function_exists('mb_substr')
    ? mb_strtoupper(mb_substr($nombreCompleto, 0, 1, 'UTF-8'), 'UTF-8')
    : strtoupper(substr($nombreCompleto, 0, 1));

$ubicacion = '';
if ($nomubi !== '') {
    $ubicacion = $nomubi . ($depaubi !== '' ? ' - ' . $depaubi : '');
}

$rolEtiqueta = ($nomperf !== '') ? $nomperf : 'Cuenta UrbanPaws';

// Accesos rápidos según el rol del usuario (páginas existentes del mapeo de home.php)
$accesos = array();
if (stripos($nomperf, 'Admin') !== false) {
    $accesos = array(
        array('pg' => 2,  'titulo' => 'Administración', 'desc' => 'Gestión general del panel.',              'icono' => 'fa-shield-halved'),
        array('pg' => 5,  'titulo' => 'Usuarios',       'desc' => 'Administra cuentas, roles y estados.',     'icono' => 'fa-users'),
        array('pg' => 6,  'titulo' => 'Validaciones',   'desc' => 'Revisa los paseadores pendientes.',        'icono' => 'fa-check-double'),
        array('pg' => 25, 'titulo' => 'Configuración',  'desc' => 'Ajustes del sistema.',                    'icono' => 'fa-gear'),
    );
} elseif (stripos($nomperf, 'Paseador') !== false) {
    $accesos = array(
        array('pg' => 3,  'titulo' => 'Mi espacio',      'desc' => 'Tu panel como paseador de mascotas.',      'icono' => 'fa-dog'),
        array('pg' => 14, 'titulo' => 'Solicitudes',     'desc' => 'Paseos que te han asignado.',              'icono' => 'fa-clipboard-list'),
        array('pg' => 11, 'titulo' => 'Rutas',           'desc' => 'Consulta las rutas disponibles.',          'icono' => 'fa-route'),
        array('pg' => 19, 'titulo' => 'Facturas',        'desc' => 'Revisa tus facturas y pagos.',             'icono' => 'fa-file-invoice-dollar'),
    );
} else {
    // Cliente o cuenta sin rol asignado todavía (mismo destino que el inicio pg=1)
    $accesos = array(
        array('pg' => 9,  'titulo' => 'Mis mascotas',    'desc' => 'Ve a sus perfiles y detalles de cuidado.', 'icono' => 'fa-paw'),
        array('pg' => 11, 'titulo' => 'Rutas',           'desc' => 'Explora las rutas de paseo.',              'icono' => 'fa-route'),
        array('pg' => 13, 'titulo' => 'Agendar paseo',   'desc' => 'Reserva un paseo para tu mascota.',        'icono' => 'fa-calendar-check'),
        array('pg' => 19, 'titulo' => 'Facturas',        'desc' => 'Consulta tus facturas y pagos.',           'icono' => 'fa-file-invoice-dollar'),
    );
}
?>
<div class="page-heading">
    <div>
        <span class="eyebrow">Tu espacio personal</span>
        <h1>Mi perfil</h1>
        <p>Consulta la información de tu cuenta UrbanPaws y accede a tus servicios.</p>
    </div>
</div>

<?php if (!empty($msgOk)) { ?>
    <div class="alert alert-success" role="alert">
        <i class="fa-solid fa-circle-check" aria-hidden="true"></i> <?= htmlspecialchars($msgOk, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php } ?>
<?php if (!empty($msgErr)) { ?>
    <div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i> <?= htmlspecialchars($msgErr, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php } ?>

<section class="profile-layout">
    <article class="card profile-card">
        <?php if ($hayFoto) { ?>
            <div class="profile-avatar" aria-hidden="true">
                <img src="<?= htmlspecialchars($fotoRel, ENT_QUOTES, 'UTF-8') ?>" alt="" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
            </div>
        <?php } else { ?>
            <div class="profile-avatar" aria-hidden="true"><?= htmlspecialchars($iniciales, ENT_QUOTES, 'UTF-8') ?></div>
        <?php } ?>
        <span class="badge badge-active"><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Sesión activa</span>
        <h2><?= htmlspecialchars($nombreCompleto, ENT_QUOTES, 'UTF-8') ?></h2>
        <p><?= htmlspecialchars($rolEtiqueta, ENT_QUOTES, 'UTF-8') ?></p>
        <div class="profile-divider"></div>
        <dl class="profile-details">
            <div>
                <dt><i class="fa-solid fa-id-card" aria-hidden="true"></i>Documento</dt>
                <dd><?= $docu !== '' ? htmlspecialchars($docu, ENT_QUOTES, 'UTF-8') : 'Sin documento registrado' ?></dd>
            </div>
            <div>
                <dt><i class="fa-solid fa-envelope" aria-hidden="true"></i>Correo</dt>
                <dd><?= $emailu !== '' ? htmlspecialchars($emailu, ENT_QUOTES, 'UTF-8') : 'Sin correo registrado' ?></dd>
            </div>
            <div>
                <dt><i class="fa-solid fa-phone" aria-hidden="true"></i>Teléfono</dt>
                <dd><?= $teleu !== '' ? htmlspecialchars($teleu, ENT_QUOTES, 'UTF-8') : 'Sin teléfono registrado' ?></dd>
            </div>
            <div>
                <dt><i class="fa-solid fa-location-dot" aria-hidden="true"></i>Ubicación</dt>
                <dd><?= $ubicacion !== '' ? htmlspecialchars($ubicacion, ENT_QUOTES, 'UTF-8') : 'Sin ubicación registrada' ?></dd>
            </div>
            <div>
                <dt><i class="fa-solid fa-user-tag" aria-hidden="true"></i>Rol</dt>
                <dd><?= $nomperf !== '' ? htmlspecialchars($nomperf, ENT_QUOTES, 'UTF-8') : 'Sin rol asignado' ?></dd>
            </div>
            <div>
                <dt><i class="fa-solid fa-fingerprint" aria-hidden="true"></i>Número de cuenta</dt>
                <dd>#<?= $profileId ?></dd>
            </div>
        </dl>
        <a href="home.php?pg=7" class="btn btn-primary w-100 mb-2">
            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Editar perfil
        </a>
        <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#modalPass">
            <i class="fa-solid fa-key" aria-hidden="true"></i> Cambiar contraseña
        </button>
    </article>

    <div class="profile-side">
        <section class="card profile-note">
            <span class="tile-icon"><i class="fa-solid fa-leaf" aria-hidden="true"></i></span>
            <span class="eyebrow">Cuidado a tu manera</span>
            <h2>La información al día hace más fácil cada visita.</h2>
            <p>Mantén actualizados tus datos de contacto para estar cerca de las novedades de tus servicios.</p>
        </section>
        <?php foreach ($accesos as $ac) { ?>
            <a href="home.php?pg=<?= (int) $ac['pg'] ?>" class="card profile-link-card">
                <span class="tile-icon"><i class="fa-solid <?= htmlspecialchars($ac['icono'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i></span>
                <span><strong><?= htmlspecialchars($ac['titulo'], ENT_QUOTES, 'UTF-8') ?></strong><small><?= htmlspecialchars($ac['desc'], ENT_QUOTES, 'UTF-8') ?></small></span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        <?php } ?>
    </div>
</section>

<!-- Modal: cambiar contraseña -->
<div class="modal fade" id="modalPass" tabindex="-1" aria-labelledby="modalPassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="home.php?pg=4&amp;ope=pass" method="POST">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="modalPassLabel">
                        <i class="fa-solid fa-key" aria-hidden="true"></i> Cambiar contraseña
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                    <div class="mb-3">
                        <label for="pass_actual" class="form-label">Contraseña actual</label>
                        <input type="password" class="form-control" id="pass_actual" name="pass_actual" autocomplete="current-password" required>
                    </div>
                    <div class="mb-3">
                        <label for="pass_nueva" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="pass_nueva" name="pass_nueva" minlength="6" autocomplete="new-password" required>
                        <div class="form-text">Mínimo 6 caracteres.</div>
                    </div>
                    <div class="mb-0">
                        <label for="pass_confirma" class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" class="form-control" id="pass_confirma" name="pass_confirma" minlength="6" autocomplete="new-password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Guardar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
