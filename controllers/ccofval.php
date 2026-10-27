<?php
require_once("models/mcofval.php");
require_once("models/mcofdom.php");

$idval = isset($_REQUEST["idval"]) ? $_REQUEST["idval"] : NULL;
$codval = isset($_POST["codval"]) ? $_POST["codval"] : NULL;
$PARAVAL = isset($_POST["PARAVAL"]) ? $_POST["PARAVAL"] : NULL;
$estaval = isset($_POST["estaval"]) ? $_POST["estaval"] : NULL;
$iddom = isset($_POST["iddom"]) ? $_POST["iddom"] : NULL;

$ope = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : NULL;
$dtOn = NULL;

$mcofval = new mCofval();
$mcofdom = new mCofdom();
$mcofval->setIdval($idval);

if (empty($_SESSION['token_cofval'])) {
    $_SESSION['token_cofval'] = bin2hex(random_bytes(32));
}
$csrfTokenCofval = $_SESSION['token_cofval'];
$tokenValido = isset($_POST['csrf_token'])
    && is_string($_POST['csrf_token'])
    && hash_equals($csrfTokenCofval, $_POST['csrf_token']);

if ($ope == "toggle") {
    $idvalValido = filter_var($_POST['idval'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValido && $idvalValido) {
        $mcofval->setIdval($idvalValido);
        $mcofval->toggleEstaval();
    }
    echo '<script>window.location.href = "home.php?pg=27";</script>';
    exit();
}

if($ope == "save") {
    $estadoValido = filter_var($estaval, FILTER_VALIDATE_INT);
    if (!in_array($estadoValido, [1, 2], true)) {
        echo '<script>alert("Estado inválido.");window.location.href = "home.php?pg=27";</script>';
        exit();
    }
    $mcofval->setCodval($codval);
    $mcofval->setPARAVAL($PARAVAL);
    $mcofval->setEstaval($estadoValido);
    $mcofval->setIddom($iddom);
    
    if($idval){
        $mcofval->upd();
    } else {
        $mcofval->save();
    }
echo '<script>window.location.href = "home.php?pg=27";</script>';    exit();
}

// Operación de Eliminar
if($ope == "eli" AND $idval) {
    $mcofval->setIdval($idval);
    $mcofval->del();
echo '<script>window.location.href = "home.php?pg=27";</script>';    exit();
}

if($ope == "edi" AND $idval) {
    $mcofval->setIdval($idval);
    $dtOn = $mcofval->getOne(); 
}

$dtdom = $mcofdom->getAll();
$datAll = $mcofval->getAll();
?>
