<?php

require_once("models/mserrut.php");
require_once("models/musupef.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
// El iduser se toma de la sesión (al iniciar sesión con credenciales).
// Si no hay sesión, se permite pasar por URL (ej: index.php?pg=11&iduser=6)
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);

$mserrut = new mServRut();
$musupef = new mUsuPef();

/* ===============================
   UBICACIÓN DEL CLIENTE (para filtrar las rutas)
================================ */
$idubi = NULL;
$dtCli = NULL;
if ($iduser) {
    $musupef->setIduser($iduser);
    $dtCli = $musupef->getOne();
    if ($dtCli) { $idubi = $dtCli["idubi"]; }
}

/* ===============================
   LISTAR RUTAS ACTIVAS SEGÚN LA UBICACIÓN DEL CLIENTE
================================ */
$mserrut->setIdubi($idubi);
$datAll = $mserrut->getActivas();

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vserrutcl.php) es quien incluye a este controlador.
?>