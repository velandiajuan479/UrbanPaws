<?php
class mExtreccon {
    // Atributos
    private $iduser;
    private $emailu;
    private $passusu;
    private $claveu;
    private $prinom;
    private $priapel;

    // GETTERS
    function getIduser(){ return $this->iduser; }
    function getEmailu(){ return $this->emailu; }
    function getPassusu(){ return $this->passusu; }
    function getClaveu(){ return $this->claveu; }
    function getPrinom(){ return $this->prinom; }
    function getPriapel(){ return $this->priapel; }

    // SETTERS
    function setIduser($iduser){ $this->iduser = $iduser; }
    function setEmailu($emailu){ $this->emailu = $emailu; }
    function setPassusu($passusu){ $this->passusu = $passusu; }
    function setClaveu($claveu){ $this->claveu = $claveu; }
    function setPrinom($prinom){ $this->prinom = $prinom; }
    function setPriapel($priapel){ $this->priapel = $priapel; }

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

    // ACTUALIZAR CONTRASEÑA
    public function updPass(){
        $sql = "UPDATE usuario 
                SET passusu = :passusu, 
                    claveu = :claveu 
                WHERE iduser = :iduser";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $iduser = $this->getIduser();
        $passusu = $this->getPassusu();
        $claveu = $this->getClaveu();
        $result->bindParam(":iduser", $iduser);
        $result->bindParam(":passusu", $passusu);
        $result->bindParam(":claveu", $claveu);
        return $result->execute();
    }

    // LISTAR RECUPERACIONES (para la tabla de vextreccon.php)
    public function getAll(){
        $sql = "SELECT prinom, priapel, emailu, claveu 
                FROM usuario 
                WHERE claveu IS NOT NULL 
                AND claveu != '' 
                ORDER BY iduser DESC";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
