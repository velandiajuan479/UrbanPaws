<?php
require_once("models/mmasdue.php");

/* Este módulo NO tiene vista propia, por lo tanto NO se usan
   redirecciones (header). La relación dueño-mascota se crea y se
   elimina automáticamente desde cmasmas al guardar/borrar una mascota.
   Este controlador queda disponible para operaciones manuales si las necesitas. */

$iddueno = isset($_REQUEST["iddueno"]) ? $_REQUEST["iddueno"] : NULL;
$iduser  = !empty($_REQUEST["iduser"]) ? $_REQUEST["iduser"]  : NULL;
$idmasc  = !empty($_REQUEST["idmasc"]) ? $_REQUEST["idmasc"]  : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mmasdue = new mCofdue;

if($ope == "saveDue" AND $iduser AND $idmasc) {
    $mmasdue->setIduser($iduser);
    $mmasdue->setIdmasc($idmasc);
    if(!$mmasdue->existe()){
        $mmasdue->save();
    }
    // SIN header: el flujo lo controla quien lo invoque
}

if($ope == "eliDue" AND $iddueno) {
    $mmasdue->setIddueno($iddueno);
    $mmasdue->del();
}

$datAllDue = $mmasdue->getAll();
?>