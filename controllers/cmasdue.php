<?php
require_once("models/mmasdue.php");

$iddueno = isset($_REQUEST["iddueno"]) ? $_REQUEST["iddueno"] : NULL;
$iduser  = !empty($_POST["iduser"])    ? $_POST["iduser"]     : NULL;
$idmasc  = !empty($_POST["idmasc"])    ? $_POST["idmasc"]     : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mmasdue = new mCofdue;
$mmasdue->setIddueno($iddueno);

if($ope == "save") {
    $mmasdue->setIduser($iduser);
    $mmasdue->setIdmasc($idmasc);

    if($iddueno){
        $mmasdue->upd();
    } else {
        $mmasdue->save();
    }
    header("Location: index.php?pg=28"); // <-- cambia por tu página de dueños
    exit();
}

if($ope == "eli" AND $iddueno) {
    $mmasdue->setIddueno($iddueno);
    $mmasdue->del();
    header("Location: index.php?pg=28");
    exit();
}

if($ope == "edi" AND $iddueno) {
    $mmasdue->setIddueno($iddueno);
    $dtOn = $mmasdue->getOne();
}

// Datos para los selects del formulario
$datDuen = $mmasdue->getDuenos();
$datMasc = $mmasdue->getMascotas();

$datAll = $mmasdue->getAll();
?>