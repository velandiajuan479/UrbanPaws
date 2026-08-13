<?php

class mcofdom{

    private $iddom;
    private $nomdom;

    public function getIddom(){ return $this->iddom;}
    public function getNomdom(){ return $this->nomdom;}

    public function setNomdom($nomdom){ $this->nomdom = $nomdom;}

    public function getAll(){

        $sql = "SELECT * FROM dominio ORDER BY iddom ASC";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // CONSULTAR UN REGISTRO
    public function getOne(){

        $sql = "SELECT * FROM dominio
                WHERE iddom = :iddom";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $iddom = $this->getIddom();

        $result->bindParam(":iddom", $iddom);

        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // GUARDAR
    public function save(){

        $sql = "INSERT INTO dominio(nomdom)
                VALUES(:nomdom)";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $nomdom = $this->getNomdom();

        $result->bindParam(":nomdom",$nomdom);

        return $result->execute();
    }

    // ACTUALIZAR
    public function upd(){

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
    }

    // ELIMINAR
    public function del(){

        $sql = "DELETE FROM dominio
                WHERE iddom = :iddom";

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();

        $result = $conexion->prepare($sql);

        $iddom = $this->getIddom();

        $result->bindParam(":iddom",$iddom);

        return $result->execute();
    }
}
?>