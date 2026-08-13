<?php
require_once("models/mextregis.php");

// Capturamos TODAS las variables (como en tu ejemplo de mrcn.php)
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
$datAll = $mcextregis->getAll(); // Cargamos la lista para la tabla
$mensaje = "";

if($ope == "save") {
    // Verificar que las contraseñas coincidan
    if($passusu === $confirm_pass) {
        // Verificar que el correo no esté registrado
        $mcextregis->setEmailu($emailu);
        $existe = $mcextregis->getByEmail();

        if($existe) {
            $mensaje = "⚠️ El correo ya está registrado.";
        } else {
            // Generar documento aleatorio si no se proporciona
            if($docu == "NULL" || empty($docu)) {
                $docu = rand(100000000, 999999999);
            }

            // Encriptar contraseña
            $passHash = password_hash($passusu, PASSWORD_DEFAULT);

            // Setear todos los valores
            $mcextregis->setDocu($docu);
            $mcextregis->setPrinom($prinom);
            $mcextregis->setSeconom($seconom);
            $mcextregis->setPriapel($priapel);
            $mcextregis->setEmailu($emailu);
            $mcextregis->setTeleu($teleu);
            $mcextregis->setPassusu($passHash);
            $mcextregis->setClaveu('');
            $mcextregis->setEstusr(1);
            $mcextregis->setECMusr(0);
            $mcextregis->setIdubi(NULL);

            if($mcextregis->save()) {
                $mensaje = "✅ Registro exitoso. Ya puedes iniciar sesión.";
                $datAll = $mcextregis->getAll(); // Recargar tabla
            } else {
                $mensaje = "❌ Error al registrar.";
            }
        }
    } else {
        $mensaje = "⚠️ Las contraseñas no coinciden.";
    }
}
?>