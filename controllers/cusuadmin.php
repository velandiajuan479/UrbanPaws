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
require_once(__DIR__ . "/../models/musuperm.php");

$iduser = isset($_REQUEST["iduser"]) ? (int) $_REQUEST["iduser"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

// La administración de usuarios, roles y páginas es exclusiva del perfil Admin.
$permisosAdmin = up_permisos();
if (!$permisosAdmin->esAdmin()) {
    $_SESSION['msgErr'] = 'Tu perfil no tiene acceso a la administración de usuarios.';
    echo '<script>window.location.href = "home.php?pg=' . (int) $permisosAdmin->dashboard() . '";</script>';
    exit();
}

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

// Identifica si un idperf corresponde al perfil Admin, evitando quitarle
// accidentalmente al administrador en sesión su propia página de gestión.
$esRolAdmin = function ($idperf) use ($musuadmin) {
    $perfiles = $musuadmin->getPerfiles();
    if (!$perfiles) {
        return false;
    }
    foreach ($perfiles as $perf) {
        if ((int) $perf['idperf'] === (int) $idperf) {
            return stripos((string) $perf['nomperf'], 'admin') !== false;
        }
    }
    return false;
};

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
        if ($iduser && (int) $iduser === (int) $_SESSION['iduser']) {
            if (!$esRolAdmin($idperf)) {
                $errores[] = "No puedes quitarte tu propio rol de administrador.";
            }
            if ($estusr !== 1) {
                $errores[] = "No puedes desactivar tu propia cuenta.";
            }
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
    if ((int) $iduser === (int) $_SESSION['iduser']) {
        cusuadminRedirect(NULL, "No puedes eliminar tu propia cuenta.");
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        cusuadminRedirect(NULL, "No se pudo validar la eliminación. Recarga la página e inténtalo de nuevo.");
    }
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
                $ids = array_values(array_unique(array_map('intval', $ids)));

                // El perfil Admin siempre conserva la página de administración.
                if ($esRolAdmin($idp) && !in_array(2, $ids, true)) {
                    $ids[] = 2;
                }

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
