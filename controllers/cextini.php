<?php
    require_once('models/mextini.php');

    // Captura de POST según vextini.php (Usuario/Email + Contraseña)
    $usuario   = isset($_POST["usuario"]) ? $_POST["usuario"] : "NULL";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "NULL";
    $ope       = isset($_REQUEST["ope"]) ? $_REQUEST["ope"] : "NULL";

    $mcextini = new mExtini();

    $datAll = $mcextini->getAll();
?>
