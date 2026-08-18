<?php

require_once("models/mserpas.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
// El iduser se toma de la sesión (al iniciar sesión con credenciales).
// Si no hay sesión, se permite pasar por URL (ej: index.php?pg=15&iduser=5)
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);
$idpas  = isset($_REQUEST["idpas"])  ? $_REQUEST["idpas"]  : NULL;
$ope    = isset($_REQUEST["ope"])    ? $_REQUEST["ope"]    : NULL;

$mserpas = new mServPas();

/* ===============================
   ACEPTAR SOLICITUD
================================ */
if ($ope == "aceptar" AND $idpas) {
    $mserpas->setIdpas($idpas);
    $mserpas->setEstapas("Aceptado");
    $mserpas->updEstado();

    header("Location: index.php?pg=15&iduser=" . $iduser);
    exit();
}

/* ===============================
   RECHAZAR SOLICITUD
================================ */
if ($ope == "rechazar" AND $idpas) {
    $mserpas->setIdpas($idpas);
    $mserpas->setEstapas("Rechazado");
    $mserpas->updEstado();

    header("Location: index.php?pg=15&iduser=" . $iduser);
    exit();
}

/* ===============================
   LISTAR SOLICITUDES DE LAS RUTAS DEL PASEADOR
================================ */
$datAll = [];
if ($iduser) {
    $mserpas->setIduser($iduser);
    $datAll = $mserpas->getByPaseador();
}

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vserserps.php) es quien incluye a este controlador.
?>