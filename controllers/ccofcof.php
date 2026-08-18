<?php
require_once("models/mcofcof.php");
require_once("models/mcofval.php");

$idconf  = isset($_REQUEST["idconf"])  ? $_REQUEST["idconf"]  : NULL;
$nomcon  = isset($_POST["nomcon"])     ? $_POST["nomcon"]     : NULL;
$logocon = isset($_POST["logocon"])    ? $_POST["logocon"]    : NULL;
$emailcon= isset($_POST["emailcon"])   ? $_POST["emailcon"]   : NULL;
$telecon = isset($_POST["telecon"])    ? $_POST["telecon"]    : NULL;
$estacon = isset($_POST["estacon"])    ? $_POST["estacon"]    : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mcofcof = new mCofcof;
$mcofcof->setIdconf($idconf);

if($ope == "save") {
    $mcofcof->setNomcon($nomcon);
    $mcofcof->setLogocon($logocon);
    $mcofcof->setEmailcon($emailcon);
    $mcofcof->setTelecon($telecon);
    $mcofcof->setEstacon($estacon);

    if($idconf){
        $mcofcof->upd();
    } else {
        $mcofcof->save();
    }
    header("Location: index.php?pg=25"); // <-- cambia por tu página de configuración
    exit();
}

if($ope == "eli" AND $idconf) {
    $mcofcof->setIdconf($idconf);
    $mcofcof->del();
    header("Location: index.php?pg=25");
    exit();
}

if($ope == "edi" AND $idconf) {
    $mcofcof->setIdconf($idconf);
    $dtOn = $mcofcof->getOne();
}

// === DATOS DE VALOR (JOIN con dominio) ===
// Dominio 1: Estado (Activo / Inactivo) para el radio "Estado"
$mcofvalEst = new mCofVal;
$mcofvalEst->setIddom(1);
$datEst = $mcofvalEst->getByDom();

$datAll = $mcofcof->getAll();
?>