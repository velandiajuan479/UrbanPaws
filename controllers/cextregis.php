<?php
    require_once("models/mextregis.php");

    $prinom   = isset($_POST["prinom"]) ? $_POST["prinom"] : "NULL";
    $priapel  = isset($_POST["priapel"]) ? $_POST["priapel"] : "NULL";
    $emailu   = isset($_POST["emailu"]) ? $_POST["emailu"] : "NULL";
    $passusu  = isset($_POST["passusu"]) ? $_POST["passusu"] : "NULL";
    $ope      = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextregis = new mExtregis();
    $mensaje = "";

    if($ope == "save"){
        $mcextregis->setEmailu($emailu);
        $existe = $mcextregis->getByEmail();

        if($existe){
            $mensaje = "El correo ya está registrado.";
        } else {
            
            $passHash = password_hash($passusu, PASSWORD_DEFAULT);

            $mcextregis->setPrinom($prinom);
            $mcextregis->setPriapel($priapel);
            $mcextregis->setEmailu($emailu);
            $mcextregis->setPassusu($passHash);
            $mcextregis->setEstusr(1); 
            
            $mcextregis->save();
            $mensaje = "Registro exitoso.";
        }
    }

    require_once("views/vextregis.php");
?>