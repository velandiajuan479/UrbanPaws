<?php
class mCofcof
{
    private $idconf;
    private $nomcon;
    private $logocon;
    private $emailcon;
    private $telecon;
    private $estacon;

    // Métodos Get
    function getIdconf(){ return $this->idconf; }
    function getNomcon(){ return $this->nomcon; }
    function getLogocon(){ return $this->logocon; }
    function getEmailcon(){ return $this->emailcon; }
    function getTelecon(){ return $this->telecon; }
    function getEstacon(){ return $this->estacon; }

    // Métodos Set
    function setIdconf($idconf){ return $this->idconf = $idconf; }
    function setNomcon($nomcon){ return $this->nomcon = $nomcon; }
    function setLogocon($logocon){ return $this->logocon = $logocon; }
    function setEmailcon($emailcon){ return $this->emailcon = $emailcon; }
    function setTelecon($telecon){ return $this->telecon = $telecon; }
    function setEstacon($estacon){ return $this->estacon = $estacon; }

    // Método getAll (LEFT JOIN con valor para traducir estacon)
    public function getAll(){
        try{
            $sql = "SELECT c.idconf, c.nomcon, c.logocon, c.emailcon, c.telecon, c.estacon,
                           v.codval AS nomesta
                    FROM config c
                    LEFT JOIN valor v ON c.estacon = v.idval
                    ORDER BY c.idconf ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 1: " . $e->getMessage();
        }
    }

    // Método getOne (mismo JOIN para el formulario de edición)
    public function getOne(){
        try{
            $sql = "SELECT c.idconf, c.nomcon, c.logocon, c.emailcon, c.telecon, c.estacon,
                           v.codval AS nomesta
                    FROM config c
                    LEFT JOIN valor v ON c.estacon = v.idval
                    WHERE c.idconf = :idconf";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idconf = $this->getIdconf();
            $result->bindParam(":idconf", $idconf);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    // Método save
    public function save(){
        try{
            $sql = "INSERT INTO config(nomcon, logocon, emailcon, telecon, estacon)
                    VALUES(:nomcon, :logocon, :emailcon, :telecon, :estacon)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $nomcon  = $this->getNomcon();
            $logocon = $this->getLogocon();
            $emailcon= $this->getEmailcon();
            $telecon = $this->getTelecon();
            $estacon = $this->getEstacon();

            $result->bindParam(":nomcon",  $nomcon);
            $result->bindParam(":logocon", $logocon);
            $result->bindParam(":emailcon",$emailcon);
            $result->bindParam(":telecon", $telecon);
            $result->bindParam(":estacon", $estacon);
            $result->execute();
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Método upd
    public function upd(){
        try{
            $sql = "UPDATE config SET
                        nomcon  = :nomcon,
                        logocon = :logocon,
                        emailcon= :emailcon,
                        telecon = :telecon,
                        estacon = :estacon
                    WHERE idconf = :idconf";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idconf  = $this->getIdconf();
            $nomcon  = $this->getNomcon();
            $logocon = $this->getLogocon();
            $emailcon= $this->getEmailcon();
            $telecon = $this->getTelecon();
            $estacon = $this->getEstacon();

            $result->bindParam(":idconf",  $idconf);
            $result->bindParam(":nomcon",  $nomcon);
            $result->bindParam(":logocon", $logocon);
            $result->bindParam(":emailcon",$emailcon);
            $result->bindParam(":telecon", $telecon);
            $result->bindParam(":estacon", $estacon);
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Método del
    public function del(){
        try{
            $sql = "DELETE FROM config WHERE idconf = :idconf";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idconf = $this->getIdconf();
            $result->bindParam(":idconf", $idconf);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }
}
?>