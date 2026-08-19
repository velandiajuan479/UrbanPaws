<?php
    require_once("models/mextregis.php");

    $prinom   = isset($_POST["prinom"]) ? $_POST["prinom"] : "NULL";
    $seconom  = isset($_POST["seconom"]) ? $_POST["seconom"] : "";
    $priapel  = isset($_POST["priapel"]) ? $_POST["priapel"] : "NULL";
    $segapel  = isset($_POST["segapel"]) ? $_POST["segapel"] : "";
    $docu     = isset($_POST["docu"]) ? $_POST["docu"] : "NULL";
    $teleu    = isset($_POST["teleu"]) ? $_POST["teleu"] : "NULL";
    $emailu   = isset($_POST["emailu"]) ? $_POST["emailu"] : "NULL";
    $passusu  = isset($_POST["passusu"]) ? $_POST["passusu"] : "NULL";
    $ope      = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextregis = new mExtregis();
    $mensaje = "";
    $tipo_mensaje = "";

    if($ope == "save"){
        // Validar que las contraseñas coincidan
        $confirm_pass = isset($_POST["confirm_pass"]) ? $_POST["confirm_pass"] : "";
        
        if($passusu !== $confirm_pass){
            $mensaje = "Las contraseñas no coinciden.";
            $tipo_mensaje = "danger";
        } else {
            // Verificar si el correo ya existe
            $mcextregis->setEmailu($emailu);
            $existe_email = $mcextregis->getByEmail();
            
            if($existe_email){
                $mensaje = "El correo ya está registrado.";
                $tipo_mensaje = "danger";
            } else {
                // Verificar si el teléfono ya existe
                $mcextregis->setTeleu($teleu);
                $existe_tele = $mcextregis->getByTele();
                
                if($existe_tele){
                    $mensaje = "El teléfono ya está registrado.";
                    $tipo_mensaje = "danger";
                } else {
                    // Encriptar contraseña
                    $passHash = password_hash($passusu, PASSWORD_DEFAULT);

                    $mcextregis->setPrinom($prinom);
                    $mcextregis->setSeconom($seconom);
                    $mcextregis->setPriapel($priapel);
                    $mcextregis->setSegapel($segapel);
                    $mcextregis->setDocu($docu);
                    $mcextregis->setTeleu($teleu);
                    $mcextregis->setEmailu($emailu);
                    $mcextregis->setPassusu($passHash);
                    $mcextregis->setEstusr(1); 
                    
                    if($mcextregis->save()){
                        $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al registrar. Intente nuevamente.";
                        $tipo_mensaje = "danger";
                    }
                }
            }
        }
    }

    require_once("views/vextregis.php");
?>