<?php
    require_once("models/mextreccon.php");

    $iduser = isset($_POST["iduser"]) ? $_POST["iduser"] : "NULL";
    $emailu = isset($_POST["emailu"]) ? $_POST["emailu"] : "NULL";
    $passusu = isset($_POST["passusu"]) ? $_POST["passusu"] : "NULL";
    $claveu = isset($_POST["claveu"]) ? $_POST["claveu"] : "NULL";
    $prinom = isset($_POST["prinom"]) ? $_POST["prinom"] : "NULL";
    $priapel = isset($_POST["priapel"]) ? $_POST["priapel"] : "NULL";
    $emailu  = isset($_POST["emailu"]) ? $_POST["emailu"] : "NULL";
    $nueva_pass  = isset($_POST["nueva_pass"]) ? $_POST["nueva_pass"] : "NULL";
    $confirm_pass = isset($_POST["confirm_pass"]) ? $_POST["confirm_pass"] : "NULL";
    $ope  = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextreccon = new mExtreccon();
    $datAll = $mcextreccon->getAll(); 

    if($ope == "save"){
        if($nueva_pass === $confirm_pass){
            $mcextreccon->setEmailu($emailu);
            $user = $mcextreccon->getByEmail(); 

            if($user){
                $hash = password_hash($nueva_pass, PASSWORD_DEFAULT);
                $mcextreccon->setIduser($user['iduser']);
                $mcextreccon->setPassusu($hash);
                $mcextreccon->setClaveu(''); // Limpiar clave temporal
                $mcextreccon->updPass();
                $mensaje = "Contraseña actualizada.";
                $datAll = $mcextreccon->getAll(); // Recargar tabla
            } else {
                $mensaje = "Correo no encontrado.";
            }
        } else {
            $mensaje = "Las contraseñas no coinciden.";
        }
    }
?>



