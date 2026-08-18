<?php
    require_once('models/mextini.php');

    // Captura de POST según vextini.php (Usuario/Email + Contraseña)
    $usuario   = isset($_POST["usuario"]) ? $_POST["usuario"] : "NULL";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "NULL";
    $ope       = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextini = new mExtini();

    if($ope == "login"){
        // El campo "usuario" puede ser documento o email
        $mcextini->setDocu($usuario);
        $mcextini->setEmailu($usuario);
        
        $user = $mcextini->login();

        if($user && password_verify($contrasena, $user['passusu'])){
            session_start();
            $_SESSION['iduser'] = $user['iduser'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Datos incorrectos";
        }
    }
?>
