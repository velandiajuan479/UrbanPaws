<?php
include("conexion.php");
date_default_timezone_set('America/Bogota');

$usu = isset($_POST['user']) ? $_POST['user'] : NULL;
$con = isset($_POST['pass']) ? $_POST['pass'] : NULL;

if($usu && $con)
    validar($usu, $con);
else
    echo '<script>window.location="../index.php?error1=ok";</script>';

function validar($usu, $con){
    $res = verdat($usu, $con);
    $res = isset($res) ? $res : NULL;
    
    if($res && count($res) > 0){
        session_start();
        $_SESSION["iduser"]  = $res[0]['iduser'];
        $_SESSION["nomusr"]  = $res[0]['prinom'] . " " . $res[0]['priapel'];
        $_SESSION["emailu"]  = $res[0]['emailu'];
        $_SESSION["aut"]     = "urbanpaws_ok_2024";
        
        echo '<script>window.location="../home.php?pg=1";</script>';
    } else {
        echo '<script>window.location="../index.php?error=ok";</script>';
    }
}

function verdat($usu, $con){
    $res = NULL;
    // Busca por email o documento, y verifica contraseña con password_verify
    $sql = "SELECT iduser, prinom, priapel, emailu, passusu FROM usuario WHERE estusr=1 AND (emailu=:usu OR docu=:usu2)";
    $modelo = new Conexion();
    $conexion = $modelo->get_conexion();
    $result = $conexion->prepare($sql);
    $result->bindParam(":usu", $usu);
    $result->bindParam(":usu2", $usu);
    $result->execute();
    $res = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Verificar contraseña con password_verify (porque usas password_hash)
    if($res && count($res) > 0){
        if(!password_verify($con, $res[0]['passusu'])){
            return NULL; // Contraseña incorrecta
        }
    }
    
    return $res;
}
?>