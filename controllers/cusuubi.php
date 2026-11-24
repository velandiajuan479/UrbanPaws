<?php
require_once '../models/helpers.php';
require_once '../models/musuubi.php';

$dest = '../home.php?pg=8';
up_controller_guard($dest);

$ope    = $_POST['ope'] ?? '';
$idubi  = (int) ($_POST['idubi'] ?? 0);
$ubi    = new mUsuUbi();

if ($ope === 'guardar' || $ope === 'editar') {
    $nom = trim($_POST['nomubi'] ?? '');
    $dep = trim($_POST['depaubi'] ?? '');
    $volver = $dest . ($ope === 'editar' ? '&edi=' . $idubi : '');   // si editaba, sigue en modo edición

    // Límites de las columnas: nomubi VARCHAR(35), depaubi VARCHAR(20)
    if ($nom === '' || $dep === '' || mb_strlen($nom) > 35 || mb_strlen($dep) > 20 || ($ope === 'editar' && $idubi <= 0)) {
        header('Location: ' . $volver . '&err=campos'); exit();
    }
    $ubi->setNomubi($nom);
    $ubi->setDepaubi($dep);
    if ($ubi->existe($ope === 'editar' ? $idubi : 0)) { header('Location: ' . $volver . '&err=duplicada'); exit(); }

    if ($ope === 'guardar') {
        $res = $ubi->save();
    } else {
        $ubi->setIdubi($idubi);
        $res = $ubi->upd();
    }
    header('Location: ' . ($res ? $dest . '&ok=' . ($ope === 'guardar' ? 'guardada' : 'actualizada') : $volver . '&err=general'));
    exit();
}

if ($ope === 'borrar' && $idubi > 0) {
    if ($ubi->del($idubi)) { header('Location: ' . $dest . '&ok=borrada'); exit(); }
    header('Location: ' . $dest . '&err=' . ($ubi->getErrcod() === 1451 ? 'enuso' : 'general'));
    exit();
}

header('Location: ' . $dest);
exit();
