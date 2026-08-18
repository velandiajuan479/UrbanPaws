<?php

require_once("models/mserrut.php");
require_once("models/musuubi.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
$idrut  = isset($_REQUEST["idrut"])  ? $_REQUEST["idrut"]  : NULL;
// El iduser se toma de la sesión (al iniciar sesión con credenciales).
// Si no hay sesión, se permite pasar por URL (ej: index.php?pg=32&iduser=5)
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);

$nomrut    = isset($_POST["nomrut"])    ? $_POST["nomrut"]    : NULL;
$distrut   = isset($_POST["distrut"])   ? $_POST["distrut"]   : NULL;
$precioini = isset($_POST["precioini"]) ? $_POST["precioini"] : NULL;
$horaini   = isset($_POST["horaini"])   ? $_POST["horaini"]   : NULL;
$horafin   = isset($_POST["horafin"])   ? $_POST["horafin"]   : NULL;
$estarut   = isset($_POST["estarut"])   ? $_POST["estarut"]   : NULL;
$idubi     = isset($_POST["idubi"])     ? $_POST["idubi"]     : NULL;
$ope       = isset($_REQUEST["ope"])    ? $_REQUEST["ope"]    : NULL;

$dtOn = NULL;

$mserrut = new mServRut();

/* ===============================
   GUARDAR / ACTUALIZAR
================================ */
if ($ope == "save") {
    // El campo horaini/horafin llega como hora (HH:MM) y la BD es DATETIME
    if ($horaini) { $horaini = date("Y-m-d") . " " . $horaini . ":00"; }
    if ($horafin) { $horafin = date("Y-m-d") . " " . $horafin . ":00"; }

    $mserrut->setIdrut($idrut);
    $mserrut->setNomrut($nomrut);
    $mserrut->setDistrut($distrut);
    $mserrut->setIduser($iduser);
    $mserrut->setIdubi($idubi);
    $mserrut->setEstarut($estarut);
    $mserrut->setHoraini($horaini);
    $mserrut->setHorafin($horafin);
    $mserrut->setPrecioini($precioini);

    if ($idrut) {
        $mserrut->upd();
    } else {
        $mserrut->save();
    }

    header("Location: index.php?pg=32&iduser=" . $iduser);
    exit();
}

/* ===============================
   ELIMINAR
================================ */
if ($ope == "eli" AND $idrut) {
    $mserrut->setIdrut($idrut);
    $mserrut->del();

    header("Location: index.php?pg=32&iduser=" . $iduser);
    exit();
}

/* ===============================
   CONSULTAR RUTA (para la vista)
================================ */
if ($ope == "edi" AND $idrut) {
    $mserrut->setIdrut($idrut);
    $dtOn = $mserrut->getOne();
}

/* ===============================
   LISTAR RUTAS DEL PASEADOR
================================ */
$datAll = [];
if ($iduser) {
    $mserrut->setIduser($iduser);
    $datAll = $mserrut->getByUser();
}

/* ===============================
   UBICACIONES (para el select del formulario)
================================ */
$musuubi = new mUsuUbi();
$datUbi = $musuubi->getAll();

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vserrutps.php) es quien incluye a este controlador.
?>