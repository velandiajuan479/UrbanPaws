<?php
    require_once("models/mextolv.php");

    // Captura de POST según vextolv.php
    $emailu = isset($_POST["emailu"]) ? $_POST["emailu"] : "";
    $ope    = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "";

    $mcextolv = new mExtolv();
    $mensaje = "";
    $tipo_mensaje = "";

    if($ope == "save"){
        $mcextolv->setEmailu($emailu);
        $user = $mcextolv->getByEmail();

        if($user){
            $claveTemp = bin2hex(random_bytes(8));
            $mcextolv->setIduser($user['iduser']);
            $mcextolv->setClaveu($claveTemp);
            if($mcextolv->saveClave()){
                // TODO: enviar correo con $claveTemp
                $mensaje = "Se ha generado una clave temporal. Por favor revise su correo.";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al generar la clave temporal.";
                $tipo_mensaje = "danger";
            }
        } else {
            $mensaje = "Correo no encontrado.";
            $tipo_mensaje = "danger";
        }
    }
    
    include("views/vextolv.php");
?>
