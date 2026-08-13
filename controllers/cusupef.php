<?php

require_once("models/musupef.php");

$iduser = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL;
$prinom = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$priapel = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
$emailu = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$teleu = isset($_POST["telefono"]) ? $_POST["telefono"] : NULL;
$nomubi = isset($_POST["direccion"]) ? $_POST["direccion"] : NULL;
$depaubi = isset($_POST["depaubi"]) ? $_POST["depaubi"] : NULL;
$foto = isset($_POST["foto"]) ? $_POST["foto"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$dtOn = NULL;

$musupef = new mUsuPef();
$musupef->setIduser($iduser);

if($ope == "edi" AND $iduser)
    $dtOn = $musupef->getOne();

if($ope == "save" AND $iduser){
    $musupef->setPrinom($prinom);
    $musupef->setPriapel($priapel);
    $musupef->setEmailu($emailu);
    $musupef->setTeleu($teleu);
    $musupef->setFoto($foto);
    $musupef->upd();

    if(isset($_POST["idubi"]) && $_POST["idubi"] != ""){
        $musupef->setIdubi($_POST["idubi"]);
        $musupef->setNomubi($nomubi);
        $musupef->setDepaubi($depaubi);
        $musupef->updUbicacion();
    }

    $dtOn = $musupef->getOne();
}

?>
