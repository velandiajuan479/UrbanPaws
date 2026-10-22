<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit;
}

require_once("models/mmasmas.php");
require_once("models/mmasdue.php");
require_once("models/musupef.php");
require_once("models/mcofval.php");

// Función auxiliar para subir foto/carnet a uploads/
function subirArchivo($campo, $prefijo){
    if(isset($_FILES[$campo]) && $_FILES[$campo]["error"] === UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES[$campo]["name"], PATHINFO_EXTENSION));
        if (in_array($ext, ["jpg", "jpeg", "png", "pdf"])) {
            if(!is_dir("uploads")){ mkdir("uploads", 0777, true); }
            $nom  = $prefijo . "_" . time() . "_" . uniqid() . "." . $ext;
            $ruta = "uploads/" . $nom;
            move_uploaded_file($_FILES[$campo]["tmp_name"], $ruta);
            return $ruta;
        }
    }
    return NULL;
}

$iduser = (int) $_SESSION['iduser'];
$idmasc = isset($_REQUEST["idmasc"]) ? (int) $_REQUEST["idmasc"] : 0;
$ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$mmasmas = new mCofmas;
$esAdmin = $mmasmas->esAdmin($iduser);
$errorMascota = NULL;
$dtOn = NULL;

if (empty($_SESSION['token_masc'])) {
    $_SESSION['token_masc'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['token_masc'];
$tokenValido = isset($_SESSION['token_masc'], $_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($_SESSION['token_masc'], $_POST['csrf_token']);

$musupef = new mUsuPef;
$musupef->setIduser($iduser);
$dtDuen = $musupef->getOne();

if($ope == "save") {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $errorMascota = "No se pudo validar el formulario. Recarga la página e inténtalo de nuevo.";
    } else {
        $idmasc = isset($_POST["idmasc"]) ? (int) $_POST["idmasc"] : 0;
        $puedeGuardar = true;

        if ($idmasc) {
            $mmasmas->setIdmasc($idmasc);
            $mascotaActual = $mmasmas->getOne();
            if (!$mascotaActual || (!$esAdmin && (int) $mascotaActual['iduser'] !== $iduser)) {
                $errorMascota = "No tienes permiso para editar esta mascota.";
                $puedeGuardar = false;
            }
        }

        if ($puedeGuardar) {
            $nommasc   = isset($_POST["nommasc"]) ? $_POST["nommasc"] : NULL;
            $sexmasc   = isset($_POST["sexmasc"]) ? $_POST["sexmasc"] : NULL;
            $razamasc  = isset($_POST["razamasc"]) ? $_POST["razamasc"] : NULL;
            $descmasc  = isset($_POST["descmasc"]) ? $_POST["descmasc"] : NULL;
            $enfermasc = isset($_POST["enfermasc"]) ? $_POST["enfermasc"] : NULL;

            $fotovacu = subirArchivo("fotovacu", "carnet");
            if($fotovacu === NULL){ $fotovacu = isset($_POST["fotovacu_old"]) ? $_POST["fotovacu_old"] : NULL; }

            $fotomasc = subirArchivo("fotomasc", "mascota");
            if($fotomasc === NULL){ $fotomasc = isset($_POST["fotomasc_old"]) ? $_POST["fotomasc_old"] : NULL; }

            $mmasmas->setIdmasc($idmasc ?: NULL);
            $mmasmas->setNommasc($nommasc);
            $mmasmas->setSexmasc($sexmasc);
            $mmasmas->setFotovacu($fotovacu);
            $mmasmas->setFotomasc($fotomasc);
            $mmasmas->setRazamasc($razamasc);
            $mmasmas->setDescmasc($descmasc);
            $mmasmas->setEnfermasc($enfermasc);
            $mmasmas->setIduser($iduser);

            $guardado = true;
            if($idmasc){
                $guardado = $mmasmas->upd($iduser, $esAdmin);
            }else{
                $idmascNew = $mmasmas->save();
                $guardado = (bool) $idmascNew;
                if($idmascNew){
                    $mmasdue = new mCofdue;
                    $mmasdue->setIduser($iduser);
                    $mmasdue->setIdmasc($idmascNew);
                    if(!$mmasdue->existe()){
                        $mmasdue->save();
                    }
                }
            }

            if ($guardado) {
                echo '<script>window.location.href = "home.php?pg=9";</script>';
                exit();
            }
            $errorMascota = "No se pudo guardar la mascota.";
        }
    }
}

if($ope == "eli" AND $idmasc) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$tokenValido) {
        $errorMascota = "No se pudo validar la eliminación. Recarga la página e inténtalo de nuevo.";
    } else {
        $mmasmas->setIdmasc($idmasc);
        $mascotaActual = $mmasmas->getOne();
        if (!$mascotaActual || (!$esAdmin && (int) $mascotaActual['iduser'] !== $iduser)) {
            $errorMascota = "No tienes permiso para eliminar esta mascota.";
        } else {
            if ($mmasmas->delOwned($iduser, $esAdmin)) {
                echo '<script>window.location.href = "home.php?pg=9";</script>';
                exit();
            }
            $errorMascota = "No se pudo eliminar la mascota.";
        }
    }
}

if($ope == "edi" AND $idmasc) {
    $mmasmas->setIdmasc($idmasc);
    $mascotaActual = $mmasmas->getOne();
    if (!$mascotaActual || (!$esAdmin && (int) $mascotaActual['iduser'] !== $iduser)) {
        $errorMascota = "No tienes permiso para editar esta mascota.";
    } else {
        $dtOn = $mascotaActual;
        if ($esAdmin && (int) $dtOn['iduser'] !== $iduser) {
            $musupef->setIduser((int) $dtOn['iduser']);
            $dtDuen = $musupef->getOne();
        }
    }
}

$mcofvalRaz = new mCofVal;
$mcofvalRaz->setIddom(3); // Dominio 3: Razas
$datRaz = $mcofvalRaz->getByDom();

$datAll = $esAdmin ? $mmasmas->getAll() : $mmasmas->getAllByUser($iduser);
?>
