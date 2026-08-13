<?php
require_once '../models/musulisusu.php';

$ope = isset($_POST['ope']) ? $_POST['ope'] : (isset($_GET['ope']) ? $_GET['ope'] : NULL);

$lis = new mUsuLisUsu();

if($ope == "activar"){
    $lis->updEstado($_GET['iduser'], 1);
    header('Location: ../index.php?pg=5');
    exit();
}

if($ope == "desactivar"){
    $lis->updEstado($_GET['iduser'], 0);
    header('Location: ../index.php?pg=5');
    exit();
}

if($ope == "borrar"){
    $lis->del($_GET['iduser']);
    header('Location: ../index.php?pg=5');
    exit();
}
?>