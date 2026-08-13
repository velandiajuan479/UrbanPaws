<?php
require_once 'conexion.php';

class mUsuUbi
{
    private $idubi;
    private $nomubi;
    private $depaubi;

    function getIdubi(){return $this->idubi;}
    function getNomubi(){return $this->nomubi;}
    function getDepaubi(){return $this->depaubi;}

    function setIdubi($idubi){return $this->idubi = $idubi;}
    function setNomubi($nomubi){return $this->nomubi = $nomubi;}
    function setDepaubi($depaubi){return $this->depaubi = $depaubi;}

    public function getAll(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT idubi, nomubi, depaubi FROM ubicacion ORDER BY nomubi ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error al consultar ubicaciones: " . $e->getMessage();
            return false;
        }
    }

    public function save(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "INSERT INTO ubicacion (nomubi, depaubi) VALUES (:nomubi, :depaubi)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nomubi', $this->nomubi);
            $stmt->bindParam(':depaubi', $this->depaubi);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al guardar ubicación: " . $e->getMessage();
            return false;
        }
    }

    public function upd(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE ubicacion SET nomubi = :nomubi, depaubi = :depaubi WHERE idubi = :idubi";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nomubi', $this->nomubi);
            $stmt->bindParam(':depaubi', $this->depaubi);
            $stmt->bindParam(':idubi', $this->idubi);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al actualizar ubicación: " . $e->getMessage();
            return false;
        }
    }

    public function del($idubi){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "DELETE FROM ubicacion WHERE idubi = :idubi";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idubi', $idubi);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al eliminar ubicación: " . $e->getMessage();
            return false;
        }
    }
}
?>