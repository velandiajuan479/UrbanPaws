<?php
require_once("models/mcofpag.php");
$idpag = isset($_REQUEST["idpag"]) ?$_REQUEST["idpag"]:NULL;
$nompag = isset($_POST["nompag"]) ?$_POST["nompag"]:NULL;
$mostpag = isset($_POST["mostpag"]) ?$_POST["mostpag"]:NULL;
$ordpag = isset($_POST["ordpag"]) ?$_POST["ordpag"]:NULL;
$descpag = isset($_POST["descpag"]) ?$_POST["descpag"]:NULL;
$ope = isset($_REQUEST["ope"]) ?$_REQUEST["ope"]:NULL;

$dtOn = null;

$mcofpag = new mCofpag;
$mcofpag->setIdpag($idpag);

if($ope == "save") {
    $mcofpag->setNompag($nompag);
    $mcofpag->setMostpag($mostpag);
    $mcofpag->setOrdpag($ordpag);
    $mcofpag->setDescpag($descpag);
    $mcofpag->setIdpag($idpag);

    if($idpag){
        $mcofpag->upd();
    }else{
        $mcofpag->del();
    }

    exit();
}

if($ope == "eli" AND $idpag) {
    $mcofpag->setIdpag($idpag);
    $mcofpag->del();
    
    exit();
}

if($ope == "edi" AND $idpag) {
    $mcofpag->setIdpag($idpag);
    $datOne = $mcofpag->getOne();
}

$datAll = $mcofpag->getAll();


?>