<?php

require_once("./models/modmpqr/mpqr.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    echo '<script>window.location.href = "index.php";</script>';
    exit;
}

$iduser = (int) $_SESSION['iduser'];
$mpqr   = new mPqr();

if (!$mpqr->tienePerfil($iduser, ['Cliente', 'Paseador'])) {
    echo '<script>window.location.href = "home.php?pg=1";</script>';
    exit;
}

$tiposPqr = ['Peticion', 'Queja', 'Reclamo', 'Sugerencia', 'Felicitacion'];
$flashKey = 'pqr_flash';

$flash    = isset($_SESSION[$flashKey]) && is_array($_SESSION[$flashKey]) ? $_SESSION[$flashKey] : ['ok' => '', 'err' => ''];
$msgOk    = isset($flash['ok']) ? (string) $flash['ok'] : '';
$msgErr   = isset($flash['err']) ? (string) $flash['err'] : '';
$_SESSION[$flashKey] = ['ok' => '', 'err' => ''];

if (empty($_SESSION['token_pqr'])) {
    $_SESSION['token_pqr'] = bin2hex(random_bytes(32));
}
$csrfTokenPqr = $_SESSION['token_pqr'];
$tokenValido = isset($_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($csrfTokenPqr, $_POST['csrf_token']);

$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;

if ($ope === 'save') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $msgErr = 'No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.';
    } else {
        $tippqr  = trim((string) (isset($_POST['tippqr']) ? $_POST['tippqr'] : ''));
        $descpqr = trim((string) (isset($_POST['descpqr']) ? $_POST['descpqr'] : ''));

        if (!in_array($tippqr, $tiposPqr, true)) {
            $msgErr = 'Selecciona un tipo de PQRSF válido.';
        } elseif (strlen($descpqr) < 10 || strlen($descpqr) > 2000) {
            $msgErr = 'La descripción debe tener entre 10 y 2000 caracteres.';
        } else {
            $mpqr->setTippqr($tippqr);
            $mpqr->setDescpqr($descpqr);
            $mpqr->setFechpqr(date('Y-m-d'));
            $mpqr->setIduser($iduser);

            if ($mpqr->save()) {
                $msgOk = 'Tu PQRSF fue radicada correctamente.';
            } else {
                $msgErr = 'No se pudo guardar la PQRSF. Inténtalo de nuevo.';
            }
        }
    }

    $_SESSION[$flashKey] = ['ok' => $msgOk, 'err' => $msgErr];
    echo '<script>window.location.href = "home.php?pg=21";</script>';
    exit;
}

$datPqr = $mpqr->getByUser($iduser);
