<?php

require_once __DIR__ . '/cserbase.php';
require_once __DIR__ . '/../../models/modmserv/mserrut.php';
require_once __DIR__ . '/../../models/musupef.php';

$iduser = servRequireLogin();
$esAdmin = servIsAdmin($iduser);

$mserrut = new mServRut();
$musupef = new mUsuPef();
$dtCli = null;
$idubi = null;

$musupef->setIduser($iduser);
$dtCli = $musupef->getOne();

if ($dtCli) {
    $idubi = $dtCli['idubi'];
}

if ($esAdmin) {
    $datAll = $mserrut->getAll();
} else {
    $mserrut->setIdubi($idubi);
    $datAll = $mserrut->getActivas();
}

$flash = servTakeFlash();
?>
