<?php
require_once("models/mcofdom.php");
require_once("models/mcofval.php");


$iddom = isset($_REQUEST["iddom"]) ? $_REQUEST["iddom"] : NULL;
$nomdom = isset($_POST["nomdom"]) ? $_POST["nomdom"] : NULL;
$actdom = isset($_POST["actdom"]) ? $_POST["actdom"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$dtOn = NULL;
$mcofdom = new mCofdom();
$mcofval   = new mCofVal();
$mcofdom->setIddom($iddom);

if($ope == "save") {
    $mcofdom->setNomdom($nomdom);
    $mcofdom->setActdom($actdom);
    if($iddom){
        $mcofdom->upd();
    }else{
        $mcofdom->save(); 
    }
    header("Location: index.php?pg=26"); 
    exit();
}

if($ope == "eli" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $mcofdom->del();
    header("Location: index.php?pg=26");
    exit();
}

if($ope == "edi" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $dtOn = $mcofdom->getOne();
}

$datEst = $mcofval->getAll();
$datAll = $mcofdom->getAll();

?>