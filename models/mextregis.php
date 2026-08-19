<?php
class mExtregis {
    // Atributos (todos los necesarios para el registro completo)
    private $iduser;
    private $prinom;
    private $seconom;
    private $priapel;
    private $segapel;
    private $docu;
    private $teleu;
    private $emailu;
    private $passusu;
    private $estusr;
    
    // GETTERS
    function getIduser(){
        return $this->iduser;
    }
    function getPrinom(){
        return $this->prinom;
    }
    function getSeconom(){
        return $this->seconom;
    }
    function getPriapel(){
        return $this->priapel;
    }
    function getSegapel(){
        return $this->segapel;
    }
    function getDocu(){
        return $this->docu;
    }
    function getTeleu(){
        return $this->teleu;
    }
    function getEmailu(){
        return $this->emailu;
    }
    function getPassusu(){
        return $this->passusu;
    }
    function getEstusr(){
        return $this->estusr;
    }

    // SETTERS
    function setIduser($iduser){
        $this->iduser = $iduser;
    }
    function setPrinom($prinom){
        $this->prinom = $prinom;
    }
    function setSeconom($seconom){
        $this->seconom = $seconom;
    }
    function setPriapel($priapel){
        $this->priapel = $priapel;
    }
    function setSegapel($segapel){
        $this->segapel = $segapel;
    }
    function setDocu($docu){
        $this->docu = $docu;
    }
    function setTeleu($teleu){
        $this->teleu = $teleu;
    }
    function setEmailu($emailu){
        $this->emailu = $emailu;
    }
    function setPassusu($passusu){
        $this->passusu = $passusu;
    }
    function setEstusr($estusr){
        $this->estusr = $estusr;
    }

    public function save(){
        $sql = "INSERT INTO usuario
                (prinom, seconom, priapel, segapel, docu, teleu, emailu, passusu, estusr)
                VALUES
                (:prinom, :seconom, :priapel, :segapel, :docu, :teleu, :emailu, :passusu, :estusr)";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $prinom = $this->getPrinom();
        $seconom = $this->getSeconom();
        $priapel = $this->getPriapel();
        $segapel = $this->getSegapel();
        $docu = $this->getDocu();
        $teleu = $this->getTeleu();
        $emailu = $this->getEmailu();
        $passusu = $this->getPassusu();
        $estusr = $this->getEstusr();
        $result->bindParam(":prinom", $prinom);
        $result->bindParam(":seconom", $seconom);
        $result->bindParam(":priapel", $priapel);
        $result->bindParam(":segapel", $segapel);
        $result->bindParam(":docu", $docu);
        $result->bindParam(":teleu", $teleu);
        $result->bindParam(":emailu", $emailu);
        $result->bindParam(":passusu", $passusu);
        $result->bindParam(":estusr", $estusr);
        return $result->execute();
    }

    public function getByEmail(){
        $sql = "SELECT * FROM usuario
                WHERE emailu = :emailu";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $emailu = $this->getEmailu();
        $result->bindParam(":emailu", $emailu);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getByTele(){
        $sql = "SELECT * FROM usuario
                WHERE teleu = :teleu";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $teleu = $this->getTeleu();
        $result->bindParam(":teleu", $teleu);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
?>
