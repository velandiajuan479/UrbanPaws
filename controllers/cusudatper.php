<?php
require_once '../models/musudatper.php';
 
$ope = isset($_POST['ope']) ? $_POST['ope'] : (isset($_GET['ope']) ? $_GET['ope'] : NULL);
 
if($ope == "actualizar"){
    $datper = new mUsuDatPer();
    $datper->setIduser($_POST['iduser']);
    $datper->setPrinom($_POST['prinom']);
    $datper->setSeconom($_POST['seconom']);
    $datper->setPriapel($_POST['priapel']);
    $datper->setEmailu($_POST['emailu']);
    $datper->setTeleu($_POST['teleu']);
    $datper->setIdubi($_POST['idubi']);
    $datper->upd();
    header('Location: ../index.php?pg=7&ok=1');
    exit();
}
?>
