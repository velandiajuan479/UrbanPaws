<?php
/**
 * cusudatper — Controlador de Datos personales (pg=7).
 *
 * Patrón moderno: la vista lo incluye como primera línea y el formulario
 * postea a home.php?pg=7&ope=save. SIEMPRE opera sobre el iduser de la
 * sesión (sin iduser del request: evita IDOR).
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

require_once("models/musudatper.php");

$iduser = (int) $_SESSION['iduser'];
$ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

/* ========================= CSRF + FLASH ========================= */
if (empty($_SESSION['token_dtp'])) {
    $_SESSION['token_dtp'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['token_dtp'];
$tokenValido = isset($_SESSION['token_dtp'], $_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($_SESSION['token_dtp'], $_POST['csrf_token']);

$msgOk = isset($_SESSION['msgOk']) ? $_SESSION['msgOk'] : NULL;
unset($_SESSION['msgOk']);
$msgErr = isset($_SESSION['msgErr']) ? $_SESSION['msgErr'] : NULL;
unset($_SESSION['msgErr']);

function cusudatperRedirect($msgOk = NULL, $msgErr = NULL, $dest = "home.php?pg=7")
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

$datper = new mUsuDatPer();
$datper->setIduser($iduser);

/* ===============================
   GUARDAR DATOS PERSONALES
================================ */
if ($ope == "save") {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $msgErr = "No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.";
    } else {
        $prinom  = isset($_POST["prinom"])  ? trim($_POST["prinom"])  : "";
        $seconom = isset($_POST["seconom"]) ? trim($_POST["seconom"]) : "";
        $priapel = isset($_POST["priapel"]) ? trim($_POST["priapel"]) : "";
        $segapel = isset($_POST["segapel"]) ? trim($_POST["segapel"]) : "";
        $emailu  = isset($_POST["emailu"])  ? trim($_POST["emailu"])  : "";
        $teleu   = isset($_POST["teleu"])   ? trim($_POST["teleu"])   : "";
        $idubi   = isset($_POST["idubi"])   ? trim($_POST["idubi"])   : "";
        $quitarFoto = isset($_POST["quitar_foto"]) && $_POST["quitar_foto"] == "1";

        $errores = array();
        if ($prinom === "") {
            $errores[] = "El primer nombre es obligatorio.";
        }
        if ($priapel === "") {
            $errores[] = "El primer apellido es obligatorio.";
        }
        if ($emailu === "" || !filter_var($emailu, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }
        if ($teleu !== "" && !ctype_digit($teleu)) {
            $errores[] = "El teléfono debe contener solo números.";
        }
        if ($idubi !== "" && (!ctype_digit($idubi) || (int) $idubi <= 0)) {
            $errores[] = "La ubicación seleccionada no es válida.";
        }

        // Foto nueva (si se envió): se valida ANTES de tocar la BD
        $fotoNueva = NULL;
        $subida    = $datper->subirFoto("foto");
        if ($subida['error'] !== NULL) {
            $errores[] = $subida['error'];
        } elseif ($subida['subido']) {
            $fotoNueva = $subida['ruta'];
        }

        if ($errores) {
            // si la foto ya se subió pero los datos no pasan validación, se descarta
            if ($fotoNueva !== NULL) {
                $datper->borrarFoto($fotoNueva);
            }
            $msgErr = implode(" ", $errores);
        } else {
            $fotoActual = isset($usuario['foto']) ? $usuario['foto'] : NULL;
            $fila = $datper->getOne($iduser);
            $fotoActual = is_array($fila) && isset($fila['foto']) ? $fila['foto'] : NULL;

            if ($fotoNueva !== NULL) {
                $fotoFinal = $fotoNueva;
            } elseif ($quitarFoto) {
                $fotoFinal = NULL;
            } else {
                $fotoFinal = $fotoActual;
            }

            $datper->setPrinom($prinom);
            $datper->setSeconom($seconom);
            $datper->setPriapel($priapel);
            $datper->setSegapel($segapel);
            $datper->setEmailu($emailu);
            $datper->setTeleu($teleu);
            $datper->setFoto($fotoFinal);
            $datper->setIdubi($idubi !== "" ? (int) $idubi : NULL);

            if ($datper->upd()) {
                // la foto anterior se borra solo si salió bien la actualización
                if ($fotoNueva !== NULL && $fotoActual !== NULL && $fotoActual !== $fotoNueva) {
                    $datper->borrarFoto($fotoActual);
                }
                if ($quitarFoto && $fotoActual !== NULL) {
                    $datper->borrarFoto($fotoActual);
                }
                // el correo de sesión puede haber cambiado: se refresca el flash
                cusudatperRedirect("Datos personales actualizados correctamente.");
            }
            // si la BD falló y había foto nueva, se retira del disco
            if ($fotoNueva !== NULL) {
                $datper->borrarFoto($fotoNueva);
            }
            cusudatperRedirect(NULL, "No se pudieron guardar los datos. Intenta de nuevo.");
        }
    }
}

/* =========================
   DATOS PARA LA VISTA
   ========================= */
$usuario    = $datper->getOne($iduser);
$ubicaciones = $datper->getUbicaciones();

// el token se regenera tras un POST fallido para no reutilizarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $ope == "save" && !$tokenValido) {
    $_SESSION['token_dtp'] = bin2hex(random_bytes(32));
    $csrfToken = $_SESSION['token_dtp'];
}

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vusudatper.php) es quien incluye a este controlador.
?>
