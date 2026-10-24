<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

require_once("models/musuadmin.php");
require_once("models/mcofper.php");

$iduser = isset($_REQUEST["iduser"]) ? (int) $_REQUEST["iduser"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

// Lógica de rol preparada (por ahora la vista queda abierta).
// Para activar la restricción más adelante basta descomentar el bloque.
$nomPerf = isset($_SESSION['nomperf']) ? (string) $_SESSION['nomperf'] : "";
$esAdmin = (stripos($nomPerf, "Admin") !== false);
/*
if (!$esAdmin) {
    echo '<script>window.location.href = "home.php?pg=1";</script>';
    exit();
}
*/

if (empty($_SESSION['token_usu'])) {
    $_SESSION['token_usu'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['token_usu'];
$tokenValido = isset($_SESSION['token_usu'], $_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($_SESSION['token_usu'], $_POST['csrf_token']);

$msgOk = isset($_SESSION['msgOk']) ? $_SESSION['msgOk'] : NULL;
unset($_SESSION['msgOk']);
$msgErr = isset($_SESSION['msgErr']) ? $_SESSION['msgErr'] : NULL;
unset($_SESSION['msgErr']);

$dtOn = NULL;
$rolesUsuario = array();

$musuadmin = new mUsuAdmin();
$musuadmin->setIduser($iduser);
$mcofper = new mCofPer();

function cusuadminRedirect($msgOk = NULL, $msgErr = NULL, $iduser = NULL)
{
    if ($msgOk) {
        $_SESSION['msgOk'] = $msgOk;
    }
    if ($msgErr) {
        $_SESSION['msgErr'] = $msgErr;
    }
    $dest = "home.php?pg=2";
    if ($iduser) {
        $dest .= "&ope=edi&iduser=" . (int) $iduser;
    }
    echo '<script>window.location.href = "' . $dest . '";</script>';
    exit();
}

if ($ope == "save") {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $msgErr = "No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.";
    } else {
        $docu    = isset($_POST["docu"]) ? trim($_POST["docu"]) : "";
        $prinom  = isset($_POST["prinom"]) ? trim($_POST["prinom"]) : "";
        $seconom = isset($_POST["seconom"]) ? trim($_POST["seconom"]) : "";
        $priapel = isset($_POST["priapel"]) ? trim($_POST["priapel"]) : "";
        $segapel = isset($_POST["segapel"]) ? trim($_POST["segapel"]) : "";
        $emailu  = isset($_POST["emailu"]) ? trim($_POST["emailu"]) : "";
        $teleu   = isset($_POST["teleu"]) ? trim($_POST["teleu"]) : "";
        $passusu = isset($_POST["passusu"]) ? $_POST["passusu"] : "";
        $estusr  = isset($_POST["estusr"]) ? (int) $_POST["estusr"] : 1;
        $idperf  = isset($_POST["idperf"]) ? (int) $_POST["idperf"] : 0;

        $errores = array();
        if ($docu === "" || !ctype_digit($docu)) {
            $errores[] = "El documento es obligatorio y debe ser numérico.";
        }
        if ($prinom === "") {
            $errores[] = "El primer nombre es obligatorio.";
        }
        if ($priapel === "") {
            $errores[] = "El primer apellido es obligatorio.";
        }
        if (filter_var($emailu, FILTER_VALIDATE_EMAIL) === false) {
            $errores[] = "El correo electrónico no es válido.";
        }
        if ($idperf <= 0) {
            $errores[] = "Debe seleccionar un rol (perfil).";
        }
        if (!$iduser && $passusu === "") {
            $errores[] = "La contraseña es obligatoria al crear el usuario.";
        }
        if ($passusu !== "" && strlen($passusu) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        if (count($errores) > 0) {
            $msgErr = implode(" ", $errores);
        } else {
            $musuadmin->setDocu($docu);
            $musuadmin->setPrinom($prinom);
            $musuadmin->setSeconom($seconom);
            $musuadmin->setPriapel($priapel);
            $musuadmin->setSegapel($segapel);
            $musuadmin->setEmailu($emailu);
            $musuadmin->setTeleu($teleu === "" ? NULL : $teleu);
            $musuadmin->setPassusu($passusu === "" ? NULL : $passusu);
            $musuadmin->setEstusr($estusr);

            if ($iduser) {
                $ok = $musuadmin->upd();
            } else {
                $ok = $musuadmin->ins();
            }

            if ($ok) {
                if (!$iduser) {
                    $iduser = (int) $musuadmin->getIduser();
                }
                $musuadmin->setIdperf($idperf);
                $okRol = $musuadmin->asignarRoles();
                if ($okRol) {
                    cusuadminRedirect("Usuario guardado correctamente.", NULL, NULL);
                }
                $msgErr = $musuadmin->getError() ? $musuadmin->getError()
                    : "El usuario se guardó pero no se pudo asignar el rol.";
            } else {
                $msgErr = $musuadmin->getError() ? $musuadmin->getError()
                    : "No fue posible guardar el usuario.";
            }
        }
    }
    cusuadminRedirect(NULL, $msgErr, $iduser ? $iduser : NULL);
}

if ($ope == "eli" && $iduser) {
    $ok = $musuadmin->del();
    if ($ok) {
        cusuadminRedirect("Usuario eliminado correctamente.");
    }
    cusuadminRedirect(NULL, $musuadmin->getError()
        ? $musuadmin->getError()
        : "No fue posible eliminar el usuario.");
}

if ($ope == "edi" && $iduser) {
    $dtOn = $musuadmin->getOne();
    if (!$dtOn) {
        cusuadminRedirect(NULL, "El usuario solicitado no existe.");
    }
    $rolesUsuario = $musuadmin->getRolesUsuario();
}

if ($ope == "savepag") {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $msgErr = "No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.";
    } else {
        $porPerfil = isset($_POST["pagxper"]) && is_array($_POST["pagxper"])
            ? $_POST["pagxper"] : array();
        $datPerfTmp = $musuadmin->getPerfiles();
        $errorPag = NULL;

        if ($datPerfTmp) {
            foreach ($datPerfTmp as $perf) {
                $idp = (int) $perf["idperf"];
                $ids = isset($porPerfil[$idp]) && is_array($porPerfil[$idp])
                    ? $porPerfil[$idp] : array();

                $mcofper->setIdperf($idp);
                $mcofper->setIdsPaginas($ids);
                $resultado = $mcofper->asignarPaginas();
                if (!$resultado) {
                    $errorPag = $mcofper->getError()
                        ? $mcofper->getError()
                        : "No fue posible actualizar las páginas del perfil.";
                    break;
                }
            }
        }

        if ($errorPag) {
            $msgErr = $errorPag;
        } else {
            $msgOk = "Páginas asignadas a cada perfil correctamente.";
        }
    }
    cusuadminRedirect($msgOk, $msgErr, NULL);
}

$datAll = $musuadmin->getAll();
$datPerf = $musuadmin->getPerfiles();
$datPag = $mcofper->getPaginas();
$datMatriz = $mcofper->getMatriz();
?>
