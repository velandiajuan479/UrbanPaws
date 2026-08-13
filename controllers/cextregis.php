<?php
require_once("models/mextregis.php");

// Capturamos TODAS las variables
$iduser   = isset($_POST["iduser"])   ? $_POST["iduser"]   : "NULL";
$docu     = isset($_POST["docu"])     ? $_POST["docu"]     : "NULL";
$prinom   = isset($_POST["prinom"])   ? $_POST["prinom"]   : "NULL";
$seconom  = isset($_POST["seconom"])  ? $_POST["seconom"]  : "NULL";
$priapel  = isset($_POST["priapel"])  ? $_POST["priapel"]  : "NULL";
$emailu   = isset($_POST["emailu"])   ? $_POST["emailu"]   : "NULL";
$teleu    = isset($_POST["teleu"])    ? $_POST["teleu"]    : "NULL";
$passusu  = isset($_POST["passusu"])  ? $_POST["passusu"]  : "NULL";
$confirm_pass = isset($_POST["confirm_pass"]) ? $_POST["confirm_pass"] : "NULL";
$estusr   = isset($_POST["estusr"])   ? $_POST["estusr"]   : "NULL";
$ECMusr   = isset($_POST["ECMusr"])   ? $_POST["ECMusr"]   : "NULL";
$idubi    = isset($_POST["idubi"])    ? $_POST["idubi"]    : "NULL";
$ope      = isset($_REQUEST["ope"])   ? $_REQUEST["ope"]   : "NULL";

$mcextregis = new mExtregis();
$datAll = $mcextregis->getAll();
$mensaje = "";

if($ope == "save") {
    if($passusu === $confirm_pass) {
        $mcextregis->setEmailu($emailu);
        $existe = $mcextregis->getByEmail();

        if($existe) {
            $mensaje = "⚠️ El correo ya está registrado.";
        } else {
            // Generar documento aleatorio (docu es NOT NULL en la BD)
            if($docu == "NULL" || empty($docu)) {
                $docu = rand(100000000, 999999999);
            }

            $passHash = password_hash($passusu, PASSWORD_DEFAULT);

            $mcextregis->setDocu($docu);
            $mcextregis->setPrinom($prinom);
            $mcextregis->setSeconom($seconom);
            $mcextregis->setPriapel($priapel);
            $mcextregis->setEmailu($emailu);
            $mcextregis->setTeleu($teleu);
            $mcextregis->setPassusu($passHash);
            $mcextregis->setClaveu(NULL);   // ← NULL evita Duplicate entry
            $mcextregis->setEstusr(1);
            $mcextregis->setECMusr(0);
            $mcextregis->setIdubi(NULL);

            if($mcextregis->save()) {
                $mensaje = "✅ Registro exitoso. Ya puedes iniciar sesión.";
                $datAll = $mcextregis->getAll();
            } else {
                $mensaje = "❌ Error al registrar.";
            }
        }
    } else {
        $mensaje = "⚠️ Las contraseñas no coinciden.";
    }
}
?>