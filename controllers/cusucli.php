<?php

require_once("models/musucli.php");

$idusu = isset($_REQUEST["idusu"])
    ? $_REQUEST["idusu"]
    : NULL;

$docu = isset($_POST["docu"])
    ? $_POST["docu"]
    : NULL;

$prinom = isset($_POST["prinom"])
    ? $_POST["prinom"]
    : NULL;

$seconom = isset($_POST["seconom"])
    ? $_POST["seconom"]
    : NULL;

$priapel = isset($_POST["priapel"])
    ? $_POST["priapel"]
    : NULL;

$seapel = isset($_POST["seapel"])
    ? $_POST["seapel"]
    : NULL;

$emailu = isset($_POST["emailu"])
    ? $_POST["emailu"]
    : NULL;

$teleu = isset($_POST["teleu"])
    ? $_POST["teleu"]
    : NULL;

$foto = isset($_POST["foto"])
    ? $_POST["foto"]
    : NULL;

$idperf = isset($_POST["idperf"])
    ? $_POST["idperf"]
    : NULL;

$idubi = isset($_POST["idubi"])
    ? $_POST["idubi"]
    : NULL;

$ope = isset($_REQUEST["ope"])
    ? $_REQUEST["ope"]
    : NULL;

$dtOn = NULL;


$musucli = new mUsucli();

$musucli->setIdusu($idusu);


if($ope == "save"){

    $musucli->setDocu($docu);
    $musucli->setPrinom($prinom);
    $musucli->setSeconom($seconom);
    $musucli->setPriapel($priapel);
    $musucli->setSeapel($seapel);
    $musucli->setEmailu($emailu);
    $musucli->setTeleu($teleu);
    $musucli->setFoto($foto);
    $musucli->setIdperf($idperf);
    $musucli->setIdubi($idubi);

    if($idusu)
        $musucli->upd();
    else
        $musucli->save();
}


if($ope == "eli" AND $idusu)
    $musucli->del();


if($ope == "edi" AND $idusu)
    $dtOn = $musucli->getOne();


$musucli->setIdperf(2);

$datAll = $musucli->getAll();

?>