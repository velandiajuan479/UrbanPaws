<?php
require_once '../models/helpers.php';
require_once '../models/musudatper.php';

$dest = '../home.php?pg=7';
up_controller_guard($dest);

if (($_POST['ope'] ?? '') === 'actualizar') {
    $prinom  = trim($_POST['prinom'] ?? '');
    $seconom = trim($_POST['seconom'] ?? '');
    $priapel = trim($_POST['priapel'] ?? '');
    $emailu  = trim($_POST['emailu'] ?? '');
    $teleu   = preg_replace('/[\s\-]/', '', trim($_POST['teleu'] ?? ''));
    $idubi   = (int) ($_POST['idubi'] ?? 0);

    if ($prinom === '' || $priapel === '' || $idubi <= 0 ||
        mb_strlen($prinom) > 100 || mb_strlen($seconom) > 100 || mb_strlen($priapel) > 100) {
        header('Location: ' . $dest . '&err=campos'); exit();
    }
    if (!filter_var($emailu, FILTER_VALIDATE_EMAIL) || mb_strlen($emailu) > 255) {
        header('Location: ' . $dest . '&err=email'); exit();
    }
    // teleu es UNIQUE: un texto vacío chocaría entre usuarios, por eso se guarda NULL
    if ($teleu === '') {
        $teleu = null;
    } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $teleu)) {
        header('Location: ' . $dest . '&err=telefono'); exit();
    }

    $datper = new mUsuDatPer();
    $datper->setIduser($_SESSION['iduser']);      // siempre el usuario de la sesión, nunca un dato del formulario
    $datper->setPrinom($prinom);
    $datper->setSeconom($seconom !== '' ? $seconom : null);
    $datper->setPriapel($priapel);
    $datper->setEmailu($emailu);
    $datper->setTeleu($teleu);
    $datper->setIdubi($idubi);

    if ($datper->upd()) { header('Location: ' . $dest . '&ok=1'); exit(); }
    header('Location: ' . $dest . '&err=' . ($datper->getErrcod() === 1062 ? 'duplicado' : 'general'));
    exit();
}

header('Location: ' . $dest);
exit();
