<?php
require_once("models/mcofpag.php");
require_once("models/mcofval.php");

$idpag   = isset($_REQUEST["idpag"])   ? $_REQUEST["idpag"]   : NULL;
$nompag  = isset($_POST["nompag"])     ? $_POST["nompag"]     : NULL;
$titpag  = isset($_POST["titpag"])     ? $_POST["titpag"]     : NULL;
$mostpag = isset($_POST["mostpag"])    ? $_POST["mostpag"]    : NULL;
$icopag  = isset($_POST["icopag"])     ? $_POST["icopag"]     : NULL;
$rutpag  = isset($_POST["rutpag"])     ? $_POST["rutpag"]     : NULL;
$ordpag  = isset($_POST["ordpag"])     ? $_POST["ordpag"]     : NULL;
$descpag = isset($_POST["descpag"])    ? $_POST["descpag"]    : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mcofpag = new mCofpag();
$mcofval = new mCofVal();
$mcofpag->setIdpag($idpag);

// ---------- Cargar dominios auxiliares ----------
// Iconos (ajusta el iddom según tu tabla)
$mcofval->setIddom(2); // ← Cambia este número por el iddom de los iconos
$datIco = $mcofval->getByDom();

// Mostrar Página (Si/No)
$mcofval->setIddom(1); // ← Cambia este número por el iddom de Si/No
$datMost = $mcofval->getByDom();

// ---------- Operaciones CRUD ----------
if($ope == "save"){
    $mcofpag->setNompag($nompag);
    $mcofpag->setTitpag($titpag);
    $mcofpag->setMostpag($mostpag);
    $mcofpag->setIcopag($icopag);
    $mcofpag->setRutpag($rutpag);
    $mcofpag->setOrdpag($ordpag);
    $mcofpag->setDescpag($descpag);

    if($idpag){
        $mcofpag->upd();
    }else{
        $mcofpag->save();
    }
    header("Location: home.php?pg=23");
    exit();
}

if($ope == "eli" AND $idpag){
    $mcofpag->del();
    header("Location: home.php?pg=23");
    exit();
}

if($ope == "edi" AND $idpag){
    $mcofpag->setIdpag($idpag);
    $dtOn = $mcofpag->getOne();
}

$datAll = $mcofpag->getAll();
?>