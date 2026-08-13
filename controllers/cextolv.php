<?php
    require_once("models/mextolv.php");

    // Captura de POST según vextolv.php
    $emailu = isset($_POST["emailu"]) ? $_POST["emailu"] : "NULL";
    $ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextolv = new mExtolv();

    if($ope == "save"){
        $mcextolv->setEmailu($emailu);
        $user = $mcextolv->getByEmail();

        if($user){
            $claveTemp = bin2hex(random_bytes(8));
            $mcextolv->setIduser($user['iduser']);
            $mcextolv->setClaveu($claveTemp);
            $mcextolv->saveClave();
            // TODO: enviar correo con $claveTemp
            $mensaje = "Clave temporal enviada.";
        } else {
            $mensaje = "Correo no encontrado.";
        }
    }
?>
