<?php

require_once("models/mfacfac.php");

$idfac = isset($_REQUEST["idfac"]) ? $_REQUEST["idfac"] : NULL;
$fechfac = isset($_POST["fechfac"]) ? $_POST["fechfac"] : NULL;
$preciolin = isset($_POST["preciolin"]) ? $_POST["preciolin"] : NULL;
$estafac = isset($_POST["estafac"]) ? $_POST["estafac"] : NULL;
$comenfac = isset($_POST["comenfac"]) ? $_POST["comenfac"] : NULL;
$iduser = isset($_POST["iduser"]) ? $_POST["iduser"] : NULL;
$iddetfac = isset($_POST["iddetfac"]) ? $_POST["iddetfac"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : 0;

$dton = NULL;

$mfacfac = new mfacfac();

$datAll = $mfacfac->getAll();

$mfacfac->setIdfac($idfac);

if ($ope == "save") {

    $mfacfac->setFechfac($fechfac);
    $mfacfac->setPreciolin($preciolin);
    $mfacfac->setEstafac($estafac);
    $mfacfac->setComenfac($comenfac);
    $mfacfac->setIduser($iduser);
    $mfacfac->setIddetfac($iddetfac);

    if ($idfac) {
        $mfacfac->upd();
    } else {
        $mfacfac->save();
    }

    $datAll = $mfacfac->getAll();
}

if ($ope == "eli" && $idfac) {

    $mfacfac->del();

    $datAll = $mfacfac->getAll();
}

if ($ope == "edi" && $idfac) {

    $dton = $mfacfac->getOne();
}

?>