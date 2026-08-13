<?php
require_once '../models/musuubi.php';

$ope = isset($_POST['ope']) ? $_POST['ope'] : (isset($_GET['ope']) ? $_GET['ope'] : NULL);

$ubi = new mUsuUbi();
$datAll = $ubi->getAll();

if($ope == "guardar"){
    $ubi->setNomubi($_POST['nomubi']);
    $ubi->setDepaubi($_POST['depaubi']);
    $ubi->save();
    header('Location: ../index.php?pg=8');
    exit();
}

if($ope == "editar"){
    $ubi->setIdubi($_POST['idubi']);
    $ubi->setNomubi($_POST['nomubi']);
    $ubi->setDepaubi($_POST['depaubi']);
    $ubi->upd();
    header('Location: ../index.php?pg=8');
    exit();
}

if($ope == "borrar"){
    $ubi->del($_GET['idubi']);
    header('Location: ../index.php?pg=8');
    exit();
}
?>