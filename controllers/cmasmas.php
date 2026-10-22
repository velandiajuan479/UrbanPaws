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
require_once("models/mmasarchivo.php");

// La subida de archivos la resuelve mMasArchivo (validación por contenido,
// peso máximo de 5 MB y guardado en uploads/mascotas/).

$iduser = (int) $_SESSION['iduser'];
$idmasc = isset($_REQUEST["idmasc"]) ? (int) $_REQUEST["idmasc"] : 0;
$ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$mmasmas = new mCofmas;
$esAdmin = $mmasmas->esAdmin($iduser);
$errorMascota = NULL;
$dtOn = NULL;
$mascotaActual = NULL;

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
            $sizemasc  = isset($_POST["sizemasc"]) ? $_POST["sizemasc"] : NULL;
            $descmasc  = isset($_POST["descmasc"]) ? $_POST["descmasc"] : NULL;
            $enfermasc = isset($_POST["enfermasc"]) ? $_POST["enfermasc"] : NULL;

            // --- Archivos: la foto de la mascota y el carnet de vacunas ---
            // Las rutas anteriores se leen de la BD, nunca del POST (evita
            // que se manipule la ruta guardada).
            $oldFotovacu = ($mascotaActual && !empty($mascotaActual['fotovacu'])) ? $mascotaActual['fotovacu'] : NULL;
            $oldFotomasc = ($mascotaActual && !empty($mascotaActual['fotomasc'])) ? $mascotaActual['fotomasc'] : NULL;

            $upVac = mMasArchivo::guardar("fotovacu", "carnet",  ["jpg", "png", "pdf"]);
            $upMas = mMasArchivo::guardar("fotomasc", "mascota", ["jpg", "png"]);

            if ($upVac['error'] || $upMas['error']) {
                // Si un archivo falla, se descarta el otro para no dejar huérfano
                if (!empty($upVac['ruta'])) { mMasArchivo::eliminar($upVac['ruta']); }
                if (!empty($upMas['ruta'])) { mMasArchivo::eliminar($upMas['ruta']); }
                $errorMascota = !empty($upVac['error']) ? $upVac['error'] : $upMas['error'];
            } else {
                $fotovacu = !empty($upVac['ruta']) ? $upVac['ruta'] : $oldFotovacu;
                $fotomasc = !empty($upMas['ruta']) ? $upMas['ruta'] : $oldFotomasc;

                // Quitar explícitamente el archivo actual
                if (isset($_POST["quitarfotovacu"]) && $_POST["quitarfotovacu"] === "1") { $fotovacu = NULL; }
                if (isset($_POST["quitarfotomasc"]) && $_POST["quitarfotomasc"] === "1") { $fotomasc = NULL; }

                $mmasmas->setIdmasc($idmasc ?: NULL);
                $mmasmas->setNommasc($nommasc);
                $mmasmas->setSexmasc($sexmasc);
                $mmasmas->setFotovacu($fotovacu);
                $mmasmas->setFotomasc($fotomasc);
                $mmasmas->setRazamasc($razamasc);
                $mmasmas->setSizemasc($sizemasc);
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
                    // El archivo reemplazado se elimina del disco
                    if (!empty($oldFotomasc) && $oldFotomasc !== $fotomasc) { mMasArchivo::eliminar($oldFotomasc); }
                    if (!empty($oldFotovacu) && $oldFotovacu !== $fotovacu) { mMasArchivo::eliminar($oldFotovacu); }
                    echo '<script>window.location.href = "home.php?pg=9";</script>';
                    exit();
                }
                $errorMascota = "No se pudo guardar la mascota.";
            }
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
$mcofvalTam = new mCofVal;
$mcofvalTam->setIddom(4); // Dominio 4: Tamaño Mascota
$datTam = $mcofvalTam->getByDom();

$datAll = $esAdmin ? $mmasmas->getAll() : $mmasmas->getAllByUser($iduser);
?>
