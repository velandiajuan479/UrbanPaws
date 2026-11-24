<?php
require_once '../models/helpers.php';
require_once '../models/musulisusu.php';

$dest = '../home.php?pg=5';
up_controller_guard($dest);

$ope    = $_POST['ope'] ?? '';
$iduser = (int) ($_POST['iduser'] ?? 0);
$miId   = (int) $_SESSION['iduser'];
$lis    = new mUsuLisUsu();

if ($iduser <= 0) { header('Location: ' . $dest . '&err=general'); exit(); }

if ($ope === 'activar' || $ope === 'desactivar') {
    if ($ope === 'desactivar' && $iduser === $miId) { header('Location: ' . $dest . '&err=propio'); exit(); }
    $nuevo = ($ope === 'activar') ? 1 : 0;
    $res   = $lis->updEstado($iduser, $nuevo);
    header('Location: ' . $dest . ($res ? '&ok=' . ($nuevo ? 'activado' : 'desactivado') : '&err=general'));
    exit();
}

if ($ope === 'borrar') {
    if ($iduser === $miId) { header('Location: ' . $dest . '&err=propio'); exit(); }
    if ($lis->del($iduser)) { header('Location: ' . $dest . '&ok=borrado'); exit(); }
    header('Location: ' . $dest . '&err=' . ($lis->getErrcod() === 1451 ? 'fk' : 'general'));
    exit();
}

header('Location: ' . $dest);
exit();
