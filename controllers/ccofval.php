<?php
require_once("models/mcofval.php");
require_once("models/mcofdom.php");

$idval = isset($_REQUEST["idval"]) ? $_REQUEST["idval"] : NULL;
$codval = isset($_POST["codval"]) ? $_POST["codval"] : NULL;
$PARAVAL = isset($_POST["PARAVAL"]) ? $_POST["PARAVAL"] : NULL;
$estaval = isset($_POST["estaval"]) ? $_POST["estaval"] : NULL;
$iddom = isset($_POST["iddom"]) ? $_POST["iddom"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;
$dtOn = NULL;

$mcofval = new mCofval();
$mcofdom = new mCofdom();
$mcofval->setIdval($idval);

if($ope == "save") {
    $mcofval->setCodval($codval);
    $mcofval->setPARAVAL($PARAVAL);
    $mcofval->setEstaval($estaval);
    $mcofval->setIddom($iddom);
    
    if($idval){
        $mcofval->upd();
    } else {
        $mcofval->save();
    }
    header("Location: index.php?pg=27");
    exit();
}

// Operación de Eliminar
if($ope == "eli" AND $idval) {
    $mcofval->setIdval($idval);
    $mcofval->del();
    header("Location: index.php?pg=27");
    exit();
}

if($ope == "edi" AND $idval) {
    $mcofval->setIdval($idval);
    $dtOn = $mcofval->getOne(); 
}

$dtdom = $mcofdom->getAll();
$datAll = $mcofval->getAll();
?>