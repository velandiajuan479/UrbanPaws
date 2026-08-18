<?php

require_once("models/mfaclisfac.php");

$idfac = isset($_REQUEST["idfac"]) ? $_REQUEST["idfac"] : NULL;
$iduser = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL;

$cliente = isset($_REQUEST["cliente"]) ? $_REQUEST["cliente"] : NULL;
$estado = isset($_REQUEST["estado"]) ? $_REQUEST["estado"] : NULL;

$fechaInicio = isset($_REQUEST["fechaInicio"]) ? $_REQUEST["fechaInicio"] : NULL;
$fechaFin = isset($_REQUEST["fechaFin"]) ? $_REQUEST["fechaFin"] : NULL;

$montoMin = isset($_REQUEST["montoMin"]) ? $_REQUEST["montoMin"] : NULL;
$montoMax = isset($_REQUEST["montoMax"]) ? $_REQUEST["montoMax"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : 0;

$mfaclisfac = new mfaclisfac();

$mfaclisfac->setIdfac($idfac);
$mfaclisfac->setIduser($iduser);
$mfaclisfac->setCliente($cliente);
$mfaclisfac->setEstado($estado);
$mfaclisfac->setFechaInicio($fechaInicio);
$mfaclisfac->setFechaFin($fechaFin);
$mfaclisfac->setMontoMin($montoMin);
$mfaclisfac->setMontoMax($montoMax);

if (
    $cliente !== NULL ||
    $estado !== NULL ||
    $fechaInicio !== NULL ||
    $fechaFin !== NULL ||
    $montoMin !== NULL ||
    $montoMax !== NULL ||
    $iduser !== NULL
) {

    $datAll = $mfaclisfac->getFiltered();

} else {

    $datAll = $mfaclisfac->getAll();

}

$dton = NULL;

if ($ope == "edi" && $idfac) {

    $dton = $mfaclisfac->getOne();

}

?>