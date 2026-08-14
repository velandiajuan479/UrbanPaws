<?php
class mCofpag
{
    private $idpag;
    private $titpag;
    private $nompag;
    private $mostpag;
    private $icopag;
    private $rutpag;
    private $ordpag;
    private $descpag;

    // Métodos Get
    function getIdpag(){ return $this->idpag; }
    function getTitpag(){ return $this->titpag; }
    function getNompag(){ return $this->nompag; }
    function getMostpag(){ return $this->mostpag; }
    function getIcopag(){ return $this->icopag; }
    function getRutpag(){ return $this->rutpag; }
    function getOrdpag(){ return $this->ordpag; }
    function getDescpag(){ return $this->descpag; }

    // Métodos Set
    function setIdpag($idpag){ return $this->idpag = $idpag; }
    function setTitpag($titpag){ return $this->titpag = $titpag; }
    function setNompag($nompag){ return $this->nompag = $nompag; }
    function setMostpag($mostpag){ return $this->mostpag = $mostpag; }
    function setIcopag($icopag){ return $this->icopag = $icopag; }
    function setRutpag($rutpag){ return $this->rutpag = $rutpag; }
    function setOrdpag($ordpag){ return $this->ordpag = $ordpag; }
    function setDescpag($descpag){ return $this->descpag = $descpag; }

    // Método getAll (LEFT JOIN con valor para traducir mostpag a Activo/Inactivo)
    public function getAll(){
        try{
            $sql = "SELECT p.idpag, p.titpag, p.nompag, p.mostpag, p.icopag,
                            p.rutpag, p.ordpag, p.descpag, v.codval AS nommost
                    FROM pagina p
                    LEFT JOIN valor v ON p.mostpag = v.idval
                    ORDER BY p.ordpag ASC";
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
            $sql = "SELECT p.idpag, p.titpag, p.nompag, p.mostpag, p.icopag,
                            p.rutpag, p.ordpag, p.descpag, v.codval AS nommost
                    FROM pagina p
                    LEFT JOIN valor v ON p.mostpag = v.idval
                    WHERE p.idpag = :idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(":idpag", $idpag);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    // Método save
    public function save(){
        try{
            $sql = "INSERT INTO pagina(titpag, nompag, mostpag, icopag, rutpag, ordpag, descpag)
                    VALUES(:titpag, :nompag, :mostpag, :icopag, :rutpag, :ordpag, :descpag)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $titpag  = $this->getTitpag();
            $nompag  = $this->getNompag();
            $mostpag = $this->getMostpag();
            $icopag  = $this->getIcopag();
            $rutpag  = $this->getRutpag();
            $ordpag  = $this->getOrdpag();
            $descpag = $this->getDescpag();

            $result->bindParam(":titpag",  $titpag);
            $result->bindParam(":nompag",  $nompag);
            $result->bindParam(":mostpag", $mostpag);
            $result->bindParam(":icopag",  $icopag);
            $result->bindParam(":rutpag",  $rutpag);
            $result->bindParam(":ordpag",  $ordpag);
            $result->bindParam(":descpag", $descpag);
            $result->execute();
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Método upd
    public function upd(){
        try{
            $sql = "UPDATE pagina SET
                        titpag  = :titpag,
                        nompag  = :nompag,
                        mostpag = :mostpag,
                        icopag  = :icopag,
                        rutpag  = :rutpag,
                        ordpag  = :ordpag,
                        descpag = :descpag
                    WHERE idpag = :idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idpag   = $this->getIdpag();
            $titpag  = $this->getTitpag();
            $nompag  = $this->getNompag();
            $mostpag = $this->getMostpag();
            $icopag  = $this->getIcopag();
            $rutpag  = $this->getRutpag();
            $ordpag  = $this->getOrdpag();
            $descpag = $this->getDescpag();

            $result->bindParam(":idpag",   $idpag);
            $result->bindParam(":titpag",  $titpag);
            $result->bindParam(":nompag",  $nompag);
            $result->bindParam(":mostpag", $mostpag);
            $result->bindParam(":icopag",  $icopag);
            $result->bindParam(":rutpag",  $rutpag);
            $result->bindParam(":ordpag",  $ordpag);
            $result->bindParam(":descpag", $descpag);
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Método del
    public function del(){
        try{
            $sql = "DELETE FROM pagina WHERE idpag=:idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idpag = $this->getIdpag();
            $result->bindParam(":idpag", $idpag);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }
}
?>