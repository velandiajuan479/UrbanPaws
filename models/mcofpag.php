<?php
class mCofpag
{
private $idpag;
private $nompag;
private $mostpag;
private $ordpag;
private $descpag;

    //Metodos Get
function getIdpag(){ return $this->idpag;}
function getNompag(){ return $this->nompag;}
function getMostpag(){ return $this->mostpag;}
function getOrdpag(){ return $this->ordpag;}
function getDescpag(){ return $this->descpag;}
    //Metodo Set
function setIdpag($idpag ){ return $this->idpag = $idpag;}
function setNompag($nompag){ return $this->nompag  = $nompag;}
function setMostpag($mostpag){ return $this->mostpag = $mostpag;}
function setOrdpag($ordpag){ return $this->ordpag = $ordpag;}
function setDescpag($descpag){ return $this->descpag = $descpag;}

//Metodo getAll

public function getAll(){
    try{
        $sql = "SELECT idpag, nompag, mostpag, ordpag, descpag FROM pagina";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "Error 1" . $e;
    }
}

public function getOne(){
    try{
        $sql = "SELECT idpag, nompag, mostpag, ordpag, descpag FROM pagina WHERE idpag=:idpag";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $idpag = $this->getIdpag();
        $result->bindParam(":idpag", $idpag);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "Error 2" . $e;
    }
}

public function save(){
    try{
        $sql = "INSERT INTO pagina(nompag, mostpag, ordpag, descpag) VALUES(:nompag, :mostpag, :ordpag, :descpag";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $nompag = $this->getNompag();
        $result->bindParam(":nompag", $nompag);
        $mostpag = $this->getMostpag();
        $result->bindParam(":mostpag", $mostpag);
        $ordpag = $this->getOrdpag();
        $result->bindParam(":ordpag", $ordpag);
        $descpag = $this->getDescpag();
        $result->bindParam(":descpag", $descpag);
        $result->execute();
    }catch(Exception $e){
        echo "Error 3" . $e;
    }
}
public function upd(){
    try{
        $sql = "UPDATE pagina SET
            nompag=:nompag,
            mostpag=:mostpag,
            ordpag=:ordpag,
            descpag=:descpag,
            WHERE idpag=:idpag";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $nompag = $this->getNompag();
        $result->bindParam(":nompag", $nompag);
        $mostpag = $this->getMostpag();
        $result->bindParam(":mostpag", $mostpag);
        $ordpag = $this->getOrdpag();
        $result->bindParam(":ordpag", $ordpag);
        $descpag = $this->getDescpag();
        $result->bindParam(":descpag", $descpag);
        $result->execute();
    }catch(Exception $e){
        echo "Error 4" . $e;
    }
}

public function del(){
    try{
        $sql = "DELETE FROM pagina WHERE idpag=:idpag";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $idpag = $this->getIdpag();
        $result->bindParam("idpag", $idpag);
        $result->execute();
    }catch(Exception $e){
        echo "Error 4" . $e;
    }
}
}
?>