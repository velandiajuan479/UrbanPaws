<?php

require_once("models/musuadmin.php");

$iduser = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : NULL;
$docu = isset($_POST["docu"]) ? $_POST["docu"] : NULL;
$prinom = isset($_POST["prinom"]) ? $_POST["prinom"] : NULL;
$seconom = isset($_POST["seconom"]) ? $_POST["seconom"] : NULL;
$priapel = isset($_POST["priapel"]) ? $_POST["priapel"] : NULL;
$emailu = isset($_POST["emailu"]) ? $_POST["emailu"] : NULL;
$teleu = isset($_POST["teleu"]) ? $_POST["teleu"] : NULL;
$foto = isset($_POST["foto"]) ? $_POST["foto"] : NULL;
$estusr = isset($_POST["estusr"]) ? $_POST["estusr"] : NULL;
$ECMusr = isset($_POST["ECMusr"]) ? $_POST["ECMusr"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$dtOn = NULL;

$musuadmin = new mUsuAdmin();
$musuadmin->setIduser($iduser);

if($ope == "save"){
    $musuadmin->setDocu($docu);
    $musuadmin->setPrinom($prinom);
    $musuadmin->setSeconom($seconom);
    $musuadmin->setPriapel($priapel);
    $musuadmin->setEmailu($emailu);
    $musuadmin->setTeleu($teleu);
    $musuadmin->setFoto($foto);
    $musuadmin->setEstusr($estusr);
    $musuadmin->setECMusr($ECMusr);

    if($iduser)
        $musuadmin->upd();
}

if($ope == "eli" AND $iduser)
    $musuadmin->del();

if($ope == "edi" AND $iduser)
    $dtOn = $musuadmin->getOne();

$datAll = $musuadmin->getAll();
?>
