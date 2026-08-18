<?php
class mCofpag {
    private $idpag;
    private $nompag;
    private $titpag;
    private $mostpag;
    private $ordpag;
    private $icopag;
    private $rutpag;
    private $descpag;

    // GETTERS
    function getIdpag()   { return $this->idpag; }
    function getNompag()  { return $this->nompag; }
    function getTitpag()  { return $this->titpag; }
    function getMostpag() { return $this->mostpag; }
    function getOrdpag()  { return $this->ordpag; }
    function getIcopag()  { return $this->icopag; }
    function getRutpag()  { return $this->rutpag; }
    function getDescpag() { return $this->descpag; }

    // SETTERS
    function setIdpag($idpag)     { $this->idpag = $idpag; }
    function setNompag($nompag)   { $this->nompag = $nompag; }
    function setTitpag($titpag)   { $this->titpag = $titpag; }
    function setMostpag($mostpag) { $this->mostpag = $mostpag; }
    function setOrdpag($ordpag)   { $this->ordpag = $ordpag; }
    function setIcopag($icopag)   { $this->icopag = $icopag; }
    function setRutpag($rutpag)   { $this->rutpag = $rutpag; }
    function setDescpag($descpag) { $this->descpag = $descpag; }

    public function getAll(){
        try{
            $sql = "SELECT idpag, nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag FROM pagina ORDER BY ordpag ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function getOne(){
        try{
            $sql = "SELECT idpag, nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag FROM pagina WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindValue(":idpag", $idpag);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function getMen(){
        try{
            $sql = "SELECT idpag, nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag FROM pagina WHERE mostpag=1 ORDER BY ordpag ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function save(){
        try{
            $sql = "INSERT INTO pagina (nompag, titpag, mostpag, icopag, rutpag, ordpag, descpag) VALUES (:nompag, :titpag, :mostpag, :icopag, :rutpag, :ordpag, :descpag)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":nompag",  $this->getNompag());
            $result->bindValue(":titpag",  $this->getTitpag());
            $result->bindValue(":mostpag", $this->getMostpag());
            $result->bindValue(":icopag",  $this->getIcopag());
            $result->bindValue(":rutpag",  $this->getRutpag());
            $result->bindValue(":ordpag",  $this->getOrdpag());
            $result->bindValue(":descpag", $this->getDescpag());
            return $result->execute();
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function upd(){
        try{
            $sql = "UPDATE pagina SET nompag=:nompag, titpag=:titpag, mostpag=:mostpag, icopag=:icopag, rutpag=:rutpag, ordpag=:ordpag, descpag=:descpag WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idpag",   $this->getIdpag());
            $result->bindValue(":nompag",  $this->getNompag());
            $result->bindValue(":titpag",  $this->getTitpag());
            $result->bindValue(":mostpag", $this->getMostpag());
            $result->bindValue(":icopag",  $this->getIcopag());
            $result->bindValue(":rutpag",  $this->getRutpag());
            $result->bindValue(":ordpag",  $this->getOrdpag());
            $result->bindValue(":descpag", $this->getDescpag());
            return $result->execute();
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function del(){
        try{
            $sql = "DELETE FROM pagina WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idpag", $this->getIdpag());
            return $result->execute();
        }catch(Exception $e){
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }
}
?>