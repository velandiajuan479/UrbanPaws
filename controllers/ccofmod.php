<?php
require_once("models/mcofmod.php");
require_once("models/mcofval.php");
require_once("models/musupef.php");

$idmod   = isset($_REQUEST["idmod"])   ? $_REQUEST["idmod"]   : NULL;
$nommod  = isset($_POST["nommod"])     ? $_POST["nommod"]     : NULL;
$icomod  = isset($_POST["icomod"])     ? $_POST["icomod"]     : NULL;
$estamod = isset($_POST["estamod"])    ? $_POST["estamod"]    : NULL;
$ordmod  = isset($_POST["ordmod"])     ? $_POST["ordmod"]     : NULL;
$idperf  = !empty($_POST["idperf"])    ? $_POST["idperf"]     : NULL; // "Sin usuarios" = NULL
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mcofmod = new mCofmod;
$mcofmod->setIdmod($idmod);

if($ope == "save") {
    $mcofmod->setNommod($nommod);
    $mcofmod->setIcomod($icomod);
    $mcofmod->setEstamod($estamod);
    $mcofmod->setOrdmod($ordmod);
    $mcofmod->setIdperf($idperf);

    if($idmod){
        $mcofmod->upd();
    } else {
        $mcofmod->save();
    }
    header("Location: index.php?pg=24"); // <-- cambia por tu página de módulos
    exit();
}

if($ope == "eli" AND $idmod) {
    $mcofmod->setIdmod($idmod);
    $mcofmod->del();
    header("Location: index.php?pg=24");
    exit();
}

if($ope == "edi" AND $idmod) {
    $mcofmod->setIdmod($idmod);
    $dtOn = $mcofmod->getOne();
}

// === DATOS DE VALOR (JOIN con dominio) ===
// Dominio 1: Estado (Activo / Inactivo) para el radio "Estado"
$mcofvalEst = new mCofVal;
$mcofvalEst->setIddom(1);
$datEst = $mcofvalEst->getByDom();

// Dominio 2: Iconos para el select "Icono"
$mcofvalIco = new mCofVal;
$mcofvalIco->setIddom(2);
$datIco = $mcofvalIco->getByDom();

// Perfiles para el select "Usuarios con acceso"
$datPer = $mcofmod->getPerfiles();

$datAll = $mcofmod->getAll();
?>