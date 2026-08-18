<?php
require_once("models/mcofpag.php");

$idpag   = isset($_REQUEST["idpag"])  ? $_REQUEST["idpag"]  : NULL;
$nompag  = isset($_POST["nompag"])    ? $_POST["nompag"]    : NULL;
$titpag  = isset($_POST["titpag"])    ? $_POST["titpag"]    : NULL;
$rutpag  = isset($_POST["rutpag"])    ? $_POST["rutpag"]    : NULL;
$mostpag = isset($_POST["mostpag"])   ? $_POST["mostpag"]   : NULL;
$ordpag  = isset($_POST["ordpag"])    ? $_POST["ordpag"]    : NULL;
$icopag  = isset($_POST["icopag"])    ? $_POST["icopag"]    : NULL;
$descpag = isset($_POST["descpag"])   ? $_POST["descpag"]   : NULL;
$ope     = isset($_REQUEST['ope'])    ? $_REQUEST['ope']    : NULL;

$dtOn = NULL;

$mcofpag = new mCofpag();
$mcofpag->setIdpag($idpag);

if($ope == "save"){
    $mcofpag->setNompag($nompag);
    $mcofpag->setTitpag($titpag);
    $mcofpag->setRutpag($rutpag);
    $mcofpag->setMostpag($mostpag);
    $mcofpag->setOrdpag($ordpag);
    $mcofpag->setIcopag($icopag);
    $mcofpag->setDescpag($descpag);
    
    if($idpag) $mcofpag->upd();
    else $mcofpag->save();
}

if($ope == "eli" AND $idpag) $mcofpag->del();

if($ope == "edi" AND $idpag) $dtOn = $mcofpag->getOne();

$datAll = $mcofpag->getAll();
?>