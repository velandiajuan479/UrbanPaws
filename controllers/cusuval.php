<?php
require_once '../models/helpers.php';
require_once '../models/musuval.php';

$dest = '../home.php?pg=6';
up_controller_guard($dest);

$ope    = $_POST['ope'] ?? '';
$iduser = (int) ($_POST['iduser'] ?? 0);
$val    = new mUsuVal();

if ($iduser > 0 && ($ope === 'aprobar' || $ope === 'rechazar')) {
    $res = $val->validar($iduser, $ope === 'aprobar' ? 1 : 2);
    header('Location: ' . $dest . ($res ? '&ok=' . ($ope === 'aprobar' ? 'aprobado' : 'rechazado') : '&err=nopendiente'));
    exit();
}

header('Location: ' . $dest);
exit();
