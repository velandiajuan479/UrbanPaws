
<?php
class mExtini {
    // Atributos
    private $iduser;
    private $docu;
    private $emailu;
    private $passusu;

    // GETTERS
    function getIduser(){ return $this->iduser; }
    function getDocu(){ return $this->docu; }
    function getEmailu(){ return $this->emailu; }
    function getPassusu(){ return $this->passusu; }

    // SETTERS
    function setIduser($iduser){ $this->iduser = $iduser; }
    function setDocu($docu){ $this->docu = $docu; }
    function setEmailu($emailu){ $this->emailu = $emailu; }
    function setPassusu($passusu){ $this->passusu = $passusu; }

    
    public function login(){
        $sql = "SELECT * FROM usuario 
                WHERE (docu = :docu OR emailu = :emailu) 
                AND estusr = 1";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $docu = $this->getDocu();
        $emailu = $this->getEmailu();
        $result->bindParam(":docu", $docu);
        $result->bindParam(":emailu", $emailu);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
?>
