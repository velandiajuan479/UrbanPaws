<?php
class mExtregis {
    // Atributos (solo los necesarios para el registro simple)
    private $iduser;
    private $prinom;
    private $priapel;
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
    function getPriapel(){
        return $this->priapel;
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
    function setPriapel($priapel){
        $this->priapel = $priapel;
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
                (prinom, priapel, emailu, passusu, estusr)
                VALUES
                (:prinom, :priapel, :emailu, :passusu, :estusr)";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $prinom = $this->getPrinom();
        $priapel = $this->getPriapel();
        $emailu = $this->getEmailu();
        $passusu = $this->getPassusu();
        $estusr = $this->getEstusr();
        $result->bindParam(":prinom", $prinom);
        $result->bindParam(":priapel", $priapel);
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
}
?>