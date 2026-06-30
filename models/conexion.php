<?php
class Conexion{
    public function get_conexion(){
        include("config.php");
        $conexion = new PDO("mysql:host=$host:dbname=$bd;", $user, $pass);
        return $conexion;
    }
} 
?>