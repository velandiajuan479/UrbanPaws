<?php
require_once 'conexion.php';

class mUsuUbi
{
    private $idubi;
    private $nomubi;
    private $depaubi;
    private $errcod = 0;

    function getErrcod(){return $this->errcod;}
    function setIdubi($idubi){$this->idubi = (int) $idubi;}
    function setNomubi($nomubi){$this->nomubi = $nomubi;}
    function setDepaubi($depaubi){$this->depaubi = $depaubi;}

    public function getAll(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $stmt = $conexion->prepare("SELECT idubi, nomubi, depaubi FROM ubicacion ORDER BY nomubi ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            error_log("mUsuUbi::getAll " . $e->getMessage());
            return [];
        }
    }

    // ¿Ya existe esa ciudad en ese departamento? (ignora la fila que se está editando)
    public function existe($idubi = 0){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT COUNT(*) FROM ubicacion
                    WHERE LOWER(nomubi) = LOWER(:nomubi) AND LOWER(depaubi) = LOWER(:depaubi) AND idubi <> :idubi";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':nomubi', $this->nomubi);
            $stmt->bindValue(':depaubi', $this->depaubi);
            $stmt->bindValue(':idubi', (int) $idubi, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetchColumn() > 0;
        }catch(PDOException $e){
            error_log("mUsuUbi::existe " . $e->getMessage());
            return false;
        }
    }

    public function save(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $stmt = $conexion->prepare("INSERT INTO ubicacion (nomubi, depaubi) VALUES (:nomubi, :depaubi)");
            $stmt->bindValue(':nomubi', $this->nomubi);
            $stmt->bindValue(':depaubi', $this->depaubi);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);
            error_log("mUsuUbi::save " . $e->getMessage());
            return false;
        }
    }

    public function upd(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $stmt = $conexion->prepare("UPDATE ubicacion SET nomubi = :nomubi, depaubi = :depaubi WHERE idubi = :idubi");
            $stmt->bindValue(':nomubi', $this->nomubi);
            $stmt->bindValue(':depaubi', $this->depaubi);
            $stmt->bindValue(':idubi', $this->idubi, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);
            error_log("mUsuUbi::upd " . $e->getMessage());
            return false;
        }
    }

    public function del($idubi){
        try{
            $conexion = (new Conexion())->get_conexion();
            $stmt = $conexion->prepare("DELETE FROM ubicacion WHERE idubi = :idubi");
            $stmt->bindValue(':idubi', (int) $idubi, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);   // 1451 = hay usuarios en esa ubicación
            error_log("mUsuUbi::del " . $e->getMessage());
            return false;
        }
    }
}
?>
