<?php
require_once("models/mmasmas.php");
require_once("models/mmasdue.php");
require_once("models/musupef.php");
require_once("models/mcofval.php");

// Función auxiliar para subir foto/carnet a uploads/
function subirArchivo($campo, $prefijo){
    if(isset($_FILES[$campo]) && $_FILES[$campo]["error"] === UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES[$campo]["name"], PATHINFO_EXTENSION));
        if(in_array($ext, ["jpg","jpeg","png","pdf"])){
            if(!is_dir("uploads")){ mkdir("uploads", 0777, true); }
            $nom  = $prefijo . "_" . time() . "_" . uniqid() . "." . $ext;
            $ruta = "uploads/" . $nom;
            move_uploaded_file($_FILES[$campo]["tmp_name"], $ruta);
            return $ruta;
        }
    }
    return NULL;
}

$idmasc   = isset($_REQUEST["idmasc"]) ? $_REQUEST["idmasc"] : NULL;
// SIN SESIÓN: el dueño llega por URL (ej: index.php?pg=27&iduser=1).
// Cuando tengas sesión, cambia esta línea por: $iduser = $_SESSION["iduser"];
$iduser   = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL;

$nommasc  = isset($_POST["nommasc"])   ? $_POST["nommasc"]   : NULL;
$sexmasc  = isset($_POST["sexmasc"])   ? $_POST["sexmasc"]   : NULL;
$razamasc = isset($_POST["razamasc"])  ? $_POST["razamasc"]  : NULL;
$descmasc = isset($_POST["descmasc"])  ? $_POST["descmasc"]  : NULL;
$enfermasc= isset($_POST["enfermasc"]) ? $_POST["enfermasc"] : NULL;
$ope      = isset($_REQUEST["ope"])    ? $_REQUEST["ope"]    : NULL;

$dtOn = null;
$mmasmas = new mCofmas;

$dtDuen = null;
if($iduser){
    $musupef = new mUsuPef;
    $musupef->setIduser($iduser);
    $dtDuen = $musupef->getOne();
}

if($ope == "save") {
    $fotovacu = subirArchivo("fotovacu", "carnet");
    if($fotovacu === NULL){ $fotovacu = isset($_POST["fotovacu_old"]) ? $_POST["fotovacu_old"] : NULL; }

    $fotomasc = subirArchivo("fotomasc", "mascota");
    if($fotomasc === NULL){ $fotomasc = isset($_POST["fotomasc_old"]) ? $_POST["fotomasc_old"] : NULL; }

    $mmasmas->setIdmasc($idmasc);
    $mmasmas->setNommasc($nommasc);
    $mmasmas->setSexmasc($sexmasc);
    $mmasmas->setFotovacu($fotovacu);
    $mmasmas->setFotomasc($fotomasc);
    $mmasmas->setRazamasc($razamasc);
    $mmasmas->setDescmasc($descmasc);
    $mmasmas->setEnfermasc($enfermasc);
    $mmasmas->setIduser($iduser);

    if($idmasc){
        $mmasmas->upd();
        $idmascNew = $idmasc;
    }else{
        $idmascNew = $mmasmas->save();
    }

    if($iduser && $idmascNew){
        $mmasdue = new mCofdue;
        $mmasdue->setIduser($iduser);
        $mmasdue->setIdmasc($idmascNew);
        if(!$mmasdue->existe()){
            $mmasdue->save();
        }
    }

    header("Location: index.php?pg=27&iduser=" . $iduser);
    exit();
}

if($ope == "eli" AND $idmasc) {
    $mmasdue = new mCofdue;
    $mmasdue->setIdmasc($idmasc);
    $mmasdue->delByMasc();

    $mmasmas->setIdmasc($idmasc);
    $mmasmas->del();

    header("Location: index.php?pg=27&iduser=" . $iduser);
    exit();
}

if($ope == "edi" AND $idmasc) {
    $mmasmas->setIdmasc($idmasc);
    $dtOn = $mmasmas->getOne();
}

$mcofvalRaz = new mCofVal;
$mcofvalRaz->setIddom(5);
$datRaz = $mcofvalRaz->getByDom();

$datAll = $mmasmas->getAll();
?>