<?php
require_once("models/mmasmas.php");

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

$idmasc   = isset($_REQUEST["idmasc"])  ? $_REQUEST["idmasc"]  : NULL;
$nommasc  = isset($_POST["nommasc"])    ? $_POST["nommasc"]    : NULL;
$sexmasc  = isset($_POST["sexmasc"])    ? $_POST["sexmasc"]    : NULL;
$razamasc = isset($_POST["razamasc"])   ? $_POST["razamasc"]   : NULL;
$descmasc = isset($_POST["descmasc"])   ? $_POST["descmasc"]   : NULL;
$enfermasc= isset($_POST["enfermasc"])  ? $_POST["enfermasc"]  : NULL;
$iduser   = !empty($_POST["iduser"])    ? $_POST["iduser"]     : NULL;
$ope      = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mmasmas = new mCofmas;
$mmasmas->setIdmasc($idmasc);

if($ope == "save") {
    // Si sube archivo nuevo se guarda su ruta; si no, se conserva el anterior
    $fotovacu = subirArchivo("fotovacu", "carnet");
    if($fotovacu === NULL){ $fotovacu = isset($_POST["fotovacu_old"]) ? $_POST["fotovacu_old"] : NULL; }

    $fotomasc = subirArchivo("fotomasc", "mascota");
    if($fotomasc === NULL){ $fotomasc = isset($_POST["fotomasc_old"]) ? $_POST["fotomasc_old"] : NULL; }

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
    } else {
        $mmasmas->save();
    }
    header("Location: index.php?pg=27"); // <-- cambia por tu página de mascotas
    exit();
}

if($ope == "eli" AND $idmasc) {
    $mmasmas->setIdmasc($idmasc);
    $mmasmas->del();
    header("Location: index.php?pg=27");
    exit();
}

if($ope == "edi" AND $idmasc) {
    $mmasmas->setIdmasc($idmasc);
    $dtOn = $mmasmas->getOne();
}

// Usuarios para el select "Dueño"
$datDuen = $mmasmas->getDuenos();

$datAll = $mmasmas->getAll();
?>