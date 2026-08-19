<?php
class mCofpag
{
    private $idpag;
    private $nompag;
    private $titpag;
    private $mostpag;
    private $icopag;
    private $rutpag;
    private $ordpag;
    private $descpag;

    // Getters
    function getIdpag()  { return $this->idpag; }
    function getNompag() { return $this->nompag; }
    function getTitpag() { return $this->titpag; }
    function getMostpag(){ return $this->mostpag; }
    function getIcopag() { return $this->icopag; }
    function getRutpag() { return $this->rutpag; }
    function getOrdpag() { return $this->ordpag; }
    function getDescpag(){ return $this->descpag; }

    // Setters
    function setIdpag($v)  { return $this->idpag  = $v; }
    function setNompag($v) { return $this->nompag = $v; }
    function setTitpag($v) { return $this->titpag = $v; }
    function setMostpag($v){ return $this->mostpag= $v; }
    function setIcopag($v) { return $this->icopag = $v; }
    function setRutpag($v) { return $this->rutpag = $v; }
    function setOrdpag($v) { return $this->ordpag = $v; }
    function setDescpag($v){ return $this->descpag= $v; }

    public function getAll(){
        try{
            $sql = "SELECT idpag, nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag
                    FROM pagina ORDER BY ordpag ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ echo "Error 1: " . $e; }
    }

    public function getOne(){
        try{
            $sql = "SELECT idpag, nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag
                    FROM pagina WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(":idpag", $idpag);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){ echo "Error 2: " . $e; }
    }

    public function save(){
        try{
            $sql = "INSERT INTO pagina(nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag)
                    VALUES(:nompag, :titpag, :mostpag, :icopag, :rutpag, :ordpag, :descpag)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $nompag  = $this->getNompag();  $result->bindParam(":nompag",  $nompag);
            $titpag  = $this->getTitpag();  $result->bindParam(":titpag",  $titpag);
            $mostpag = $this->getMostpag(); $result->bindParam(":mostpag", $mostpag);
            $icopag  = $this->getIcopag();  $result->bindParam(":icopag",  $icopag);
            $rutpag  = $this->getRutpag();  $result->bindParam(":rutpag",  $rutpag);
            $ordpag  = $this->getOrdpag();  $result->bindParam(":ordpag",  $ordpag);
            $descpag = $this->getDescpag(); $result->bindParam(":descpag", $descpag);
            $result->execute();
        }catch(Exception $e){ echo "Error 3: " . $e; }
    }

    public function upd(){
        try{
            $sql = "UPDATE pagina SET
                    nompag=:nompag, titpag=:titpag, mostpag=:mostpag,
                    icopag=:icopag, rutpag=:rutpag, ordpag=:ordpag, descpag=:descpag
                    WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $nompag  = $this->getNompag();  $result->bindParam(":nompag",  $nompag);
            $titpag  = $this->getTitpag();  $result->bindParam(":titpag",  $titpag);
            $mostpag = $this->getMostpag(); $result->bindParam(":mostpag", $mostpag);
            $icopag  = $this->getIcopag();  $result->bindParam(":icopag",  $icopag);
            $rutpag  = $this->getRutpag();  $result->bindParam(":rutpag",  $rutpag);
            $ordpag  = $this->getOrdpag();  $result->bindParam(":ordpag",  $ordpag);
            $descpag = $this->getDescpag(); $result->bindParam(":descpag", $descpag);
            $idpag   = $this->getIdpag();   $result->bindParam(":idpag",   $idpag);
            $result->execute();
        }catch(Exception $e){ echo "Error 4: " . $e; }
    }

    public function del(){
        try{
            $sql = "DELETE FROM pagina WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(":idpag", $idpag);
            $result->execute();
        }catch(Exception $e){ echo "Error 5: " . $e; }
    }
}
?>