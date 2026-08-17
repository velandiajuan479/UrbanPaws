<?php

require_once("models/mserrut.php");
require_once("models/mserpas.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
// El iduser se toma de la sesión (al iniciar sesión con credenciales).
// Si no hay sesión, se permite pasar por URL (ej: index.php?pg=13&iduser=6&idrut=1)
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);
$idrut  = isset($_REQUEST["idrut"])  ? $_REQUEST["idrut"]  : NULL;

$idmasc   = isset($_POST["idmasc"])   ? $_POST["idmasc"]   : NULL;
$descserv = isset($_POST["descserv"]) ? $_POST["descserv"] : NULL;
$servtipo = isset($_POST["servtipo"]) ? $_POST["servtipo"] : NULL;
$ope      = isset($_REQUEST["ope"])   ? $_REQUEST["ope"]   : NULL;

$mserrut = new mServRut();
$mserpas = new mServPas();

/* ===============================
   RUTA ELEGIDA (info total de la ruta y del paseador)
================================ */
$dtRut = NULL;
if ($idrut) {
    $mserrut->setIdrut($idrut);
    $dtRut = $mserrut->getOne();
}

/* ===============================
   AGENDAR PASE0 (finaliza la solicitud)
================================ */
if ($ope == "save" AND $idrut AND $iduser) {
    $mserpas->setEstapas("Solicitado");
    $mserpas->setIdmasc($idmasc);
    $mserpas->setIdrut($idrut);
    $mserpas->setIduser($iduser);
    $mserpas->setDescserv($descserv);
    $mserpas->setServtipo($servtipo);
    $mserpas->save();

    header("Location: index.php?pg=14&iduser=" . $iduser);
    exit();
}

/* ===============================
   MASCOTAS DEL CLIENTE (para elegir al agendar)
================================ */
$datMas = [];
if ($iduser) {
    $mserpas->setIduser($iduser);
    $datMas = $mserpas->getMascotasByUser();
}

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vserpas.php) es quien incluye a este controlador.
?>