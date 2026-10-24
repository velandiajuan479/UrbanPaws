<?php
/**
 * cusupef — Controlador de Mi perfil (pg=4).
 *
 * Perfil privado: SIEMPRE opera sobre el iduser de la sesión (sin iduser
 * del request). Este módulo solo consulta los datos del usuario y gestiona
 * el cambio de contraseña; la edición de datos personales vive en pg=7.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

require_once("models/musupef.php");

$iduser = (int) $_SESSION['iduser'];
$ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

/* ========================= CSRF + FLASH ========================= */
if (empty($_SESSION['token_pef'])) {
    $_SESSION['token_pef'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['token_pef'];
$tokenValido = isset($_SESSION['token_pef'], $_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($_SESSION['token_pef'], $_POST['csrf_token']);

$msgOk = isset($_SESSION['msgOk']) ? $_SESSION['msgOk'] : NULL;
unset($_SESSION['msgOk']);
$msgErr = isset($_SESSION['msgErr']) ? $_SESSION['msgErr'] : NULL;
unset($_SESSION['msgErr']);

function cusupefRedirect($msgOk = NULL, $msgErr = NULL, $dest = "home.php?pg=4")
{
    if ($msgOk) {
        $_SESSION['msgOk'] = $msgOk;
    }
    if ($msgErr) {
        $_SESSION['msgErr'] = $msgErr;
    }
    // home.php ya imprimió HTML: header() falla, se redirige con script (ERRORES A17)
    echo '<script>window.location.href = "' . $dest . '";</script>';
    exit();
}

$musupef = new mUsuPef();
$musupef->setIduser($iduser);

/* ===============================
   CAMBIAR CONTRASEÑA
================================ */
if ($ope == "pass") {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $msgErr = "No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.";
    } else {
        $actual = isset($_POST["pass_actual"])   ? $_POST["pass_actual"]   : "";
        $nueva  = isset($_POST["pass_nueva"])    ? $_POST["pass_nueva"]    : "";
        $conf   = isset($_POST["pass_confirma"]) ? $_POST["pass_confirma"] : "";

        $errores = array();

        $hash = $musupef->getPassHash();
        if ($hash === FALSE) {
            $errores[] = "No se pudo verificar tu cuenta. Intenta de nuevo.";
        } elseif (!password_verify($actual, $hash)) {
            $errores[] = "La contraseña actual es incorrecta.";
        }
        if (strlen($nueva) < 6) {
            $errores[] = "La nueva contraseña debe tener al menos 6 caracteres.";
        }
        if ($nueva !== $conf) {
            $errores[] = "La confirmación no coincide con la nueva contraseña.";
        }

        if ($errores) {
            $msgErr = implode(" ", $errores);
        } else {
            $musupef->setPassusu(password_hash($nueva, PASSWORD_DEFAULT));
            if ($musupef->updPass()) {
                cusupefRedirect("Contraseña actualizada correctamente.");
            }
            cusupefRedirect(NULL, "No se pudo actualizar la contraseña. Intenta de nuevo.");
        }
    }
}

/* ===============================
   DATOS DEL USUARIO PARA LA VISTA
================================ */
$dtOn = $musupef->getOne();

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vusupef.php) es quien incluye a este controlador.
?>
