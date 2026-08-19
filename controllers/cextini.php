<?php
    require_once("models/mextini.php");

    // Captura de POST según vextini.php (Usuario/Email + Contraseña)
    $usuario   = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "";
    $ope       = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "";

    $mcextini = new mExtini();
    $error_login = "";

    if($ope == "login"){
        // El campo "usuario" puede ser documento, email o teléfono
        $mcextini->setDocu($usuario);
        $mcextini->setEmailu($usuario);
        $mcextini->setTeleu($usuario);
        
        $user = $mcextini->login();

        if($user && password_verify($contrasena, $user['passusu'])){
            session_start();
            $_SESSION['iduser'] = $user['iduser'];
            $_SESSION['emailu'] = $user['emailu'];
            $_SESSION['prinom'] = $user['prinom'];
            $_SESSION['nomperf'] = $user['nomperf'];
            header("Location: home.php");
            exit;
        } else {
            $error_login = "Usuario o contraseña incorrectos";
        }
    }
    
    // Incluir la vista del formulario de login
    include("views/vextini.php");
?>
