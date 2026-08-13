<?php
require_once("models/mextolv.php");

// Capturamos TODAS las variables (como en tu ejemplo de mrcn.php)
$iduser   = isset($_POST["iduser"])   ? $_POST["iduser"]   : "NULL";
$docu     = isset($_POST["docu"])     ? $_POST["docu"]     : "NULL";
$prinom   = isset($_POST["prinom"])   ? $_POST["prinom"]   : "NULL";
$seconom  = isset($_POST["seconom"])  ? $_POST["seconom"]  : "NULL";
$priapel  = isset($_POST["priapel"])  ? $_POST["priapel"]  : "NULL";
$emailu   = isset($_POST["emailu"])   ? $_POST["emailu"]   : "NULL";
$teleu    = isset($_POST["teleu"])    ? $_POST["teleu"]    : "NULL";
$foto     = isset($_POST["foto"])     ? $_POST["foto"]     : "NULL";
$passusu  = isset($_POST["passusu"])  ? $_POST["passusu"]  : "NULL";
$claveu   = isset($_POST["claveu"])   ? $_POST["claveu"]   : "NULL";
$estusr   = isset($_POST["estusr"])   ? $_POST["estusr"]   : "NULL";
$ECMusr   = isset($_POST["ECMusr"])   ? $_POST["ECMusr"]   : "NULL";
$idubi    = isset($_POST["idubi"])    ? $_POST["idubi"]    : "NULL";
$ope      = isset($_REQUEST["ope"])   ? $_REQUEST["ope"]   : "NULL";

$mcextolv = new mExtolv();
$datAll = $mcextolv->getAll(); // Cargamos la lista para la tabla
$mensaje = "";

if($ope == "save" && $emailu != "NULL") {
    // Pasamos el email al modelo
    $mcextolv->setEmailu($emailu);
    $user = $mcextolv->getByEmail();

    if($user) {
        // Generamos una clave temporal aleatoria
        $claveTemp = bin2hex(random_bytes(8));

        $mcextolv->setIduser($user['iduser']);
        $mcextolv->setClaveu($claveTemp);

        if($mcextolv->saveClave()) {
            $mensaje = "✅ Clave temporal generada: <strong>" . $claveTemp . "</strong><br>(En el futuro esto se enviará por correo a " . htmlspecialchars($emailu) . ")";
            $datAll = $mcextolv->getAll(); // Recargar tabla
        } else {
            $mensaje = "❌ Error al guardar la clave temporal.";
        }
    } else {
        $mensaje = "⚠️ Correo no encontrado o usuario inactivo.";
    }
}
?>