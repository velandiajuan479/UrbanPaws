<?php
    require_once("models/mextreccon.php");

    // Captura de POST según vextreccon.php
    $emailu      = isset($_POST["emailu"]) ? $_POST["emailu"] : "";
    $nueva_pass  = isset($_POST["nueva_pass"]) ? $_POST["nueva_pass"] : "";
    $confirm_pass = isset($_POST["confirm_pass"]) ? $_POST["confirm_pass"] : "";
    $ope         = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "";

    $mcextreccon = new mExtreccon();
    $mensaje = "";
    $tipo_mensaje = "";

    if($ope == "save"){
        if($nueva_pass === $confirm_pass){
            $mcextreccon->setEmailu($emailu);
            $user = $mcextreccon->getByEmail();

            if($user){
                $hash = password_hash($nueva_pass, PASSWORD_DEFAULT);
                $mcextreccon->setIduser($user['iduser']);
                $mcextreccon->setPassusu($hash);
                $mcextreccon->setClaveu(''); // Limpiar clave temporal
                if($mcextreccon->updPass()){
                    $mensaje = "Contraseña actualizada exitosamente.";
                    $tipo_mensaje = "success";
                } else {
                    $mensaje = "Error al actualizar la contraseña.";
                    $tipo_mensaje = "danger";
                }
            } else {
                $mensaje = "Correo no encontrado.";
                $tipo_mensaje = "danger";
            }
        } else {
            $mensaje = "Las contraseñas no coinciden.";
            $tipo_mensaje = "danger";
        }
    }
    
    include("views/vextreccon.php");
?>
