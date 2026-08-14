<?php
require_once("models/mcofpag.php");
require_once("models/mcofval.php");

$idpag   = isset($_REQUEST["idpag"])  ? $_REQUEST["idpag"]  : NULL;
$titpag  = isset($_POST["titpag"])    ? $_POST["titpag"]    : NULL;
$nompag  = isset($_POST["nompag"])    ? $_POST["nompag"]    : NULL;
$mostpag = isset($_POST["mostpag"])   ? $_POST["mostpag"]   : NULL;
$icopag  = isset($_POST["icopag"])    ? $_POST["icopag"]    : NULL;
$rutpag  = isset($_POST["rutpag"])    ? $_POST["rutpag"]    : NULL;
$ordpag  = isset($_POST["ordpag"])    ? $_POST["ordpag"]    : NULL;
$descpag = isset($_POST["descpag"])   ? $_POST["descpag"]   : NULL;
$ope     = isset($_REQUEST["ope"])    ? $_REQUEST["ope"]    : NULL;

$dtOn = null;
$mcofpag = new mCofpag;
$mcofpag->setIdpag($idpag);

if($ope == "save") {
    $mcofpag->setTitpag($titpag);
    $mcofpag->setNompag($nompag);
    $mcofpag->setMostpag($mostpag);
    $mcofpag->setIcopag($icopag);
    $mcofpag->setRutpag($rutpag);
    $mcofpag->setOrdpag($ordpag);
    $mcofpag->setDescpag($descpag);

    if($idpag){
        $mcofpag->upd();
    } else {
        $mcofpag->save();
    }
    header("Location: index.php?pg=23");
    exit();
}

if($ope == "eli" AND $idpag) {
    $mcofpag->setIdpag($idpag);
    $mcofpag->del();
    header("Location: index.php?pg=23");
    exit();
}

if($ope == "edi" AND $idpag) {
    $mcofpag->setIdpag($idpag);
    $dtOn = $mcofpag->getOne();
}

// Dominio 1: Estado (Activo / Inactivo) para el radio "Mostrar Página"
$mcofvalEst = new mCofVal;
$mcofvalEst->setIddom(1);
$datEst = $mcofvalEst->getByDom();

// Dominio 2: Iconos para el select "Icono"
$mcofvalIco = new mCofVal;
$mcofvalIco->setIddom(2);
$datIco = $mcofvalIco->getByDom();

$datAll = $mcofpag->getAll();
?>