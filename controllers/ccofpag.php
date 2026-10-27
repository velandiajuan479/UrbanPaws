<?php
require_once("models/mcofpag.php");
require_once("models/mcofval.php");

$idpag   = isset($_REQUEST["idpag"])   ? $_REQUEST["idpag"]   : NULL;
$nompag  = isset($_POST["nompag"])     ? $_POST["nompag"]     : NULL;
$titpag  = isset($_POST["titpag"])     ? $_POST["titpag"]     : NULL;
$mostpag = isset($_POST["mostpag"])    ? $_POST["mostpag"]    : NULL;
$icopag  = isset($_POST["icopag"])     ? $_POST["icopag"]     : NULL;
$rutpag  = isset($_POST["rutpag"])     ? $_POST["rutpag"]     : NULL;
$ordpag  = isset($_POST["ordpag"])     ? $_POST["ordpag"]     : NULL;
$descpag = isset($_POST["descpag"])    ? $_POST["descpag"]    : NULL;
$ope     = isset($_REQUEST["ope"])     ? $_REQUEST["ope"]     : NULL;

$dtOn = null;
$mcofpag = new mCofpag();
$mcofval = new mCofVal();

if (empty($_SESSION['token_pag'])) {
    $_SESSION['token_pag'] = bin2hex(random_bytes(32));
}
$csrfTokenPag = $_SESSION['token_pag'];
$tokenValido = isset($_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($csrfTokenPag, $_POST['csrf_token']);

$mcofpag->setIdpag($idpag);


$mcofval->setIddom(2);
$datIco = $mcofval->getByDom();


$valoresEstado = $mcofval->getAll() ?: [];
$datMost = array_values(array_filter($valoresEstado, static function ($valor) {
    return (int) $valor['iddom'] === 1 && in_array((int) $valor['idval'], [1, 2], true);
}));

if ($ope == "toggle" && $_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValido) {
    $idpagValido = filter_var($idpag, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($idpagValido) {
        $mcofpag->setIdpag($idpagValido);
        $mcofpag->toggleMostpag();
    }
    echo '<script>window.location.href = "home.php?pg=23";</script>';
    exit();
}

if($ope == "save"){
    $estadoValido = filter_var($mostpag, FILTER_VALIDATE_INT);
    if (!in_array($estadoValido, [1, 2], true)) {
        echo '<script>alert("Estado inválido.");window.location.href = "home.php?pg=23";</script>';
        exit();
    }
    $mcofpag->setNompag($nompag);
    $mcofpag->setTitpag($titpag);
    $mcofpag->setMostpag($estadoValido);
    $mcofpag->setIcopag($icopag);
    $mcofpag->setRutpag($rutpag);
    $mcofpag->setOrdpag($ordpag);
    $mcofpag->setDescpag($descpag);

    if($idpag){
        $mcofpag->upd();
    }else{
        $mcofpag->save();
    }
    echo '<script>window.location.href = "home.php?pg=23";</script>';
    exit();
}

if($ope == "eli" AND $idpag){
    $mcofpag->del();
    echo '<script>window.location.href = "home.php?pg=23";</script>';
    exit();
}

if($ope == "edi" AND $idpag){
    $mcofpag->setIdpag($idpag);
    $dtOn = $mcofpag->getOne();
}

$datAll = $mcofpag->getAll();
?>
