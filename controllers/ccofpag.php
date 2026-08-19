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


$mcofval->setIddom(2);
$datIco = $mcofval->getByDom();


$mcofval->setIddom(1); 
$datMost = $mcofval->getByDom();

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
    echo '<script>window.location.href = "home.php?pg=23";</script>';
    exit();
}

if($ope == "eli" AND $idpag){
    $mcofpag->del();
    echo '<script>window.location.href = "home.php?pg=23";</script>';
    exit();
}

if($ope == "edi" AND $idpag){
    $mcofpag->setIdpag($idpag);
    $dtOn = $mcofpag->getOne();
}

$datAll = $mcofpag->getAll();
?>