<?php

require_once("models/mcofpag.php");
$iddom = isset($_REQUEST["iddom"]) ?$_REQUEST["iddom"]:NULL;
$nomdom = isset($_POST["nomdom"]) ?$_POST["nomdom"]:NULL;
$ope = isset($_REQUEST["ope"]) ?$_REQUEST["ope"]:NULL;

$dtOn = NULL; 

$mcofdom = new mcofdom();
$mcofdom->setIddom($iddom);


if($ope == "save") {
    $mcofdom->setNomdom($nomdom);

    if($iddom){
        $mcofdom->upd();
    }else{
        $mcofdom->del();
    }

    exit();
}

if($ope == "eli" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $mcofdom->del();
    
    exit();
}

if($ope == "edi" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $datOne = $mcofdom->getOne();
}

$datAll = $mcofdom->getAll();

?>