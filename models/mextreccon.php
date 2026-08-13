<?php
require_once 'conexion.php';

class mExtreccon {
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

    // --- CRUD ---

    public function getAll(){
        try {
            // Ahora sí funcionará porque iduser, prinom, etc. existen
            $sql = "SELECT iduser, prinom, priapel, emailu, passusu, claveu FROM usuario ORDER BY iduser DESC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error getAll: " . $e->getMessage();
            return [];
        }
    }

    public function getOne($id){
        try {
            $sql = "SELECT * FROM usuario WHERE iduser = :id";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':id', $id);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save(){
        try {
            $sql = "INSERT INTO usuario (docu, prinom, priapel, emailu, passusu, claveu, estusr) VALUES (:docu, :prinom, :priapel, :emailu, :passusu, :claveu, :estusr)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            // ... (bindParams aquí si los necesitas para registro)
            return $result->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function upd(){
        try {
            $sql = "UPDATE usuario SET prinom=:prinom, priapel=:priapel, emailu=:emailu, passusu=:passusu WHERE iduser=:iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':iduser', $this->getIduser());
            $result->bindParam(':prinom', $this->getPrinom());
            $result->bindParam(':priapel', $this->getPriapel());
            $result->bindParam(':emailu', $this->getEmailu());
            $result->bindParam(':passusu', $this->getPassusu());
            return $result->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function del(){
        try {
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':iduser', $this->getIduser());
            return $result->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // --- RECUPERACIÓN ---

    public function getByEmail(){
        try {
            $sql = "SELECT * FROM usuario WHERE emailu = :emailu AND estusr = 1";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $emailu = $this->getEmailu();
            $result->bindParam(":emailu", $emailu);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updPass(){
        try {
            $sql = "UPDATE usuario SET passusu = :passusu, claveu = :claveu WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(":iduser", $this->getIduser());
            $result->bindParam(":passusu", $this->getPassusu());
            $result->bindParam(":claveu", $this->getClaveu());
            return $result->execute();
        } catch (PDOException $e) {
            echo "Error updPass: " . $e->getMessage();
            return false;
        }
    }
}
?>