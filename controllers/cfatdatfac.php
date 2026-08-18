<?php

require_once("models/mfatdatfac.php");

$iddetfac = isset($_REQUEST["iddetfac"]) ? $_REQUEST["iddetfac"] : NULL;
$timpfin = isset($_POST["timpfin"]) ? $_POST["timpfin"] : NULL;
$subtotal = isset($_POST["subtotal"]) ? $_POST["subtotal"] : NULL;
$idrut = isset($_POST["idrut"]) ? $_POST["idrut"] : NULL;
$idserv = isset($_POST["idserv"]) ? $_POST["idserv"] : NULL;
$idmasc = isset($_POST["idmasc"]) ? $_POST["idmasc"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : 0;

$dton = NULL;

$mfatdatfac = new mfatdatfac();

$datAll = $mfatdatfac->getAll();

$mfatdatfac->setIddetfac($iddetfac);

if ($ope == "save") {

    $mfatdatfac->setTimpfin($timpfin);
    $mfatdatfac->setSubtotal($subtotal);
    $mfatdatfac->setIdrut($idrut);
    $mfatdatfac->setIdserv($idserv);
    $mfatdatfac->setIdmasc($idmasc);

    if ($iddetfac) {
        $mfatdatfac->upd();
    } else {
        $mfatdatfac->save();
    }

    $datAll = $mfatdatfac->getAll();
}

if ($ope == "eli" && $iddetfac) {

    $mfatdatfac->del();

    $datAll = $mfatdatfac->getAll();
}

if ($ope == "edi" && $iddetfac) {

    $dton = $mfatdatfac->getOne();
}

?>