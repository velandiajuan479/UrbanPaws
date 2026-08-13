<?php

class mCofdom{

    private $iddom;
    private $nomdom;

    public function getIddom(){ return $this->iddom;}
    public function getNomdom(){ return $this->nomdom;}

    public function setIddom($iddom){ $this->iddom = $iddom;}
    public function setNomdom($nomdom){ $this->nomdom = $nomdom;}

    public function getAll(){
    try{
        $sql = "SELECT iddom, nomdom FROM dominio";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "Error 1" . $e;
    }
    }

    // CONSULTAR UN REGISTRO
    public function getOne(){
    try{
        $sql = "SELECT iddom, nomdom FROM dominio WHERE iddom=:iddom";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $iddom = $this->getIddom();
        $result->bindParam(":iddom", $iddom);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "Error 2" . $e;
    }
    }

    // GUARDAR
    public function save(){
    try{
        $sql = "INSERT INTO dominio(nomdom)
                VALUES(:nomdom)";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $nomdom = $this->getNomdom();

        $result->bindParam(":nomdom",$nomdom);

        return $result->execute();
    }catch(Exception $e){
        echo "Error 3" . $e;
    }
    }

    // ACTUALIZAR
    public function upd(){
    try{
        $sql = "UPDATE dominio
                SET nomdom = :nomdom
                WHERE iddom = :iddom";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $iddom = $this->getIddom();
        $nomdom = $this->getNomdom();

        $result->bindParam(":iddom",$iddom);
        $result->bindParam(":nomdom",$nomdom);

        return $result->execute();
    }catch(Exception $e){
        echo "Error 4" . $e;
    }
    }

    // ELIMINAR
    public function del(){
    try{
        $sql = "DELETE FROM dominio
                WHERE iddom = :iddom";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $iddom = $this->getIddom();

        $result->bindParam(":iddom",$iddom);

        return $result->execute();
    }catch(Exception $e){
        echo "Error 1" . $e;
    }
    }
}
?>