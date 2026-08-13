<?php

require_once("models/mfacrepfac.php");

$fechaInicio = isset($_REQUEST["fechaInicio"]) ? $_REQUEST["fechaInicio"] : NULL;
$fechaFin = isset($_REQUEST["fechaFin"]) ? $_REQUEST["fechaFin"] : NULL;
$estado = isset($_REQUEST["estado"]) ? $_REQUEST["estado"] : NULL;
$iduser = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : 0;

$mfacrepfac = new mfacrepfac();

$mfacrepfac->setFechaInicio($fechaInicio);
$mfacrepfac->setFechaFin($fechaFin);
$mfacrepfac->setEstado($estado);
$mfacrepfac->setIduser($iduser);

$datResumen = $mfacrepfac->getResumen();

$datPeriodo = $mfacrepfac->getPorPeriodo();

$datEstado = $mfacrepfac->getPorEstado();

$datFacturas = $mfacrepfac->getFacturasReporte();

?>