<?php
require_once("models/mcofdom.php");
require_once("models/mcofval.php");


$iddom = isset($_REQUEST["iddom"]) ? $_REQUEST["iddom"] : NULL;
$nomdom = isset($_POST["nomdom"]) ? $_POST["nomdom"] : NULL;
$actdom = isset($_POST["actdom"]) ? $_POST["actdom"] : NULL;
$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;

$dtOn = NULL;
$mcofdom = new mCofdom();
$mcofval   = new mCofVal();
$mcofdom->setIddom($iddom);

if (empty($_SESSION['token_cofdom'])) {
    $_SESSION['token_cofdom'] = bin2hex(random_bytes(32));
}
$csrfTokenCofdom = $_SESSION['token_cofdom'];
$tokenValido = isset($_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($csrfTokenCofdom, $_POST['csrf_token']);

if ($ope == "toggle") {
    $iddomValido = filter_var($_POST['iddom'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValido && $iddomValido) {
        $mcofdom->setIddom($iddomValido);
        $mcofdom->toggleActdom();
    }
    echo '<script>window.location.href = "home.php?pg=26";</script>';
    exit();
}

if($ope == "save") {
    $mcofdom->setNomdom($nomdom);
    $mcofdom->setActdom($actdom);
    if($iddom){
        $mcofdom->upd();
    }else{
        $mcofdom->save(); 
    }
echo '<script>window.location.href = "home.php?pg=26";</script>';    exit();
}

if($ope == "eli" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $mcofdom->del();
echo '<script>window.location.href = "home.php?pg=26";</script>';
    exit();
}

if($ope == "edi" AND $iddom) {
    $mcofdom->setIddom($iddom);
    $dtOn = $mcofdom->getOne();
}

$datEst = $mcofval->getAll();
$datAll = $mcofdom->getAll();

?>
