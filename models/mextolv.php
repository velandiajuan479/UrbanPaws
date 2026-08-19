<?php
class mExtolv {
    // Atributos
    private $iduser;
    private $emailu;
    private $claveu;

    // GETTERS
    function getIduser(){ return $this->iduser; }
    function getEmailu(){ return $this->emailu; }
    function getClaveu(){ return $this->claveu; }

    // SETTERS
    function setIduser($iduser){ $this->iduser = $iduser; }
    function setEmailu($emailu){ $this->emailu = $emailu; }
    function setClaveu($claveu){ $this->claveu = $claveu; }

    // BUSCAR POR EMAIL
    public function getByEmail(){
        $sql = "SELECT * FROM usuario 
                WHERE emailu = :emailu 
                AND estusr = 1";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $emailu = $this->getEmailu();
        $result->bindParam(":emailu", $emailu);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // GUARDAR CLAVE TEMPORAL
    public function saveClave(){
        $sql = "UPDATE usuario 
                SET claveu = :claveu 
                WHERE iduser = :iduser";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $iduser = $this->getIduser();
        $claveu = $this->getClaveu();
        $result->bindParam(":iduser", $iduser);
        $result->bindParam(":claveu", $claveu);
        return $result->execute();
    }
}
?>
