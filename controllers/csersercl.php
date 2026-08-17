<?php

require_once("models/mserpas.php");

/* ========================= RECEPCIÓN DE DATOS ========================= */
// El iduser se toma de la sesión (al iniciar sesión con credenciales).
// Si no hay sesión, se permite pasar por URL (ej: index.php?pg=14&iduser=6)
$iduser = isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : (isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL);

$mserpas = new mServPas();

/* ===============================
   LISTAR SERVICIOS (PASEOS) DEL CLIENTE
================================ */
$datAll = [];
if ($iduser) {
    $mserpas->setIduser($iduser);
    $datAll = $mserpas->getByCliente();
}

// IMPORTANTE: NO incluir la vista aquí.
// La vista (vsersercl.php) es quien incluye a este controlador.
?>