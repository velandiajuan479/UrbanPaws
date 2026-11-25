<?php

require_once("./models/modmpqr/mpqr.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['iduser'])) {
    echo '<script>window.location.href = "index.php";</script>';
    exit;
}

$iduser = (int) $_SESSION['iduser'];
$mpqr   = new mPqr();

if (!$mpqr->esAdmin($iduser)) {
    echo '<script>window.location.href = "home.php?pg=1";</script>';
    exit;
}

$datAll   = $mpqr->getAll();
$totalPqr = count($datAll);
