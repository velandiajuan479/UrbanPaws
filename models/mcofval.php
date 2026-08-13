<?php
class mCofVal{
    private $idval;
    private $codval;
    private $PARAVAL;
    private $estaval;
    private $iddom; // Agregado para manejar la relación con la tabla dominio

    // Metodos Get
    function getIdval(){ return $this->idval;}
    function getCodval(){ return $this->codval;}
    function getPARAVAL(){ return $this->PARAVAL;}
    function getEstaval(){ return $this->estaval;}
    function getIddom(){ return $this->iddom;}

    // Metodos Set
    function setIdval($idval){ return $this->idval = $idval;}
    function setCodval($codval){ return $this->codval = $codval;}
    function setPARAVAL($PARAVAL){ return $this->PARAVAL = $PARAVAL;}
    function setEstaval($estaval){ return $this->estaval = $estaval;}
    function setIddom($iddom){ return $this->iddom = $iddom;}

    public function getAll(){
        try{
            $sql = "SELECT v.idval, v.codval, v.PARAVAL, v.estaval, v.iddom, d.nomdom 
                    FROM valor v 
                    INNER JOIN dominio d ON v.iddom = d.iddom";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 1: " . $e->getMessage();
        }
    }

    public function getOne(){
        try{
            $sql = "SELECT v.idval, v.codval, v.PARAVAL, v.estaval, v.iddom, d.nomdom 
                    FROM valor v 
                    INNER JOIN dominio d ON v.iddom = d.iddom 
                    WHERE v.idval = :idval";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idval = $this->getIdval();
            $result->bindParam(":idval", $idval);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    public function save(){
        try{
            $sql = "INSERT INTO valor (codval, PARAVAL, estaval, iddom) VALUES (:codval, :PARAVAL, :estaval, :iddom)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            
            $codval = $this->getCodval();
            $result->bindParam(":codval", $codval);
            $PARAVAL = $this->getPARAVAL();
            $result->bindParam(":PARAVAL", $PARAVAL);
            $estaval = $this->getEstaval();
            $result->bindParam(":estaval", $estaval);
            $iddom = $this->getIddom();
            $result->bindParam(":iddom", $iddom);
            
            $result->execute();
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Metodo upd
    public function upd(){
        try{
            $sql = "UPDATE valor SET
                codval = :codval,
                PARAVAL = :PARAVAL,
                estaval = :estaval,
                iddom = :iddom
                WHERE idval = :idval";
                
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            
            $codval = $this->getCodval();
            $result->bindParam(":codval", $codval);
            $PARAVAL = $this->getPARAVAL();
            $result->bindParam(":PARAVAL", $PARAVAL);
            $estaval = $this->getEstaval();
            $result->bindParam(":estaval", $estaval);
            $iddom = $this->getIddom();
            $result->bindParam(":iddom", $iddom);
            $idval = $this->getIdval();
            $result->bindParam(":idval", $idval);
            
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Metodo del
    public function del(){
        try{
            $sql = "DELETE FROM valor WHERE idval = :idval";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idval = $this->getIdval();
            // Se agregaron los dos puntos (:) a ":idval" que faltaban en el bindParam
            $result->bindParam(":idval", $idval);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }
}
?>