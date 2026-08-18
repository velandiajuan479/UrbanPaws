<?php

require_once("models/musupef.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
$iduser  = isset($_REQUEST["iduser"])  ? $_REQUEST["iduser"]  : NULL;
$docu    = isset($_POST["docu"])       ? $_POST["docu"]       : NULL;
$prinom  = isset($_POST["prinom"])     ? $_POST["prinom"]     : NULL;
$seconom = isset($_POST["seconom"])    ? $_POST["seconom"]    : NULL;
$priapel = isset($_POST["priapel"])    ? $_POST["priapel"]    : NULL;
$emailu  = isset($_POST["emailu"])     ? $_POST["emailu"]     : NULL;
$teleu   = isset($_POST["teleu"])      ? $_POST["teleu"]      : NULL;
$foto    = isset($_POST["foto"])       ? $_POST["foto"]       : NULL;
$estusr  = isset($_POST["estusr"])     ? $_POST["estusr"]     : NULL;
$ECMusr  = isset($_POST["ECMusr"])     ? $_POST["ECMusr"]     : NULL;
$idubi   = isset($_POST["idubi"])      ? $_POST["idubi"]      : NULL;
$idperf  = isset($_POST["idperf"])     ? $_POST["idperf"]     : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = NULL;

// ✅ CORRECCIÓN: Instanciar la clase correcta (mUsuPef, no mUsucli)
$musupef = new mUsuPef();

// La BD utiliza iduser
if ($iduser) {
    $musupef->setIduser($iduser);
}

/* ===============================
   GUARDAR / ACTUALIZAR
================================ */
if ($ope == "save") {
    $musupef->setDocu($docu);
    $musupef->setPrinom($prinom);
    $musupef->setSeconom($seconom);
    $musupef->setPriapel($priapel);
    $musupef->setEmailu($emailu);
    $musupef->setTeleu($teleu);
    $musupef->setFoto($foto);
    $musupef->setEstusr($estusr);
    $musupef->setECMusr($ECMusr);
    $musupef->setIdubi($idubi);

    if ($iduser) {
        $musupef->upd();      // Actualizar existente
    } else {
        $musupef->save();     // Crear nuevo
    }
}

/* ===============================
   ELIMINAR
================================ */
if ($ope == "eli" && $iduser) {
    $musupef->del();
}

/* ===============================
   CONSULTAR USUARIO (para la vista)
================================ */
if ($iduser) {
    $dtOn = $musupef->getOne();
}

/* ===============================
   LISTAR USUARIOS POR PERFIL
================================ */
$datAll = [];
if ($idperf) {
    $musupef->setIdperf($idperf);
    $datAll = $musupef->getAll();
}

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vusupef.php) es quien incluye a este controlador.
?>