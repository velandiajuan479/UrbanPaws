<?php
require_once '../models/musuval.php';

$ope = isset($_POST['ope']) ? $_POST['ope'] : (isset($_GET['ope']) ? $_GET['ope'] : NULL);

$val = new mUsuVal();

if($ope == "aprobar"){
    $val->validar($_GET['iduser'], 1);
    header('Location: ../index.php?pg=6');
    exit();
}

if($ope == "rechazar"){
    $val->validar($_GET['iduser'], 2);
    header('Location: ../index.php?pg=6');
    exit();
}
?>