<?php
require_once 'conexion.php';

class mUsuDatPer
{
    private $iduser;
    private $prinom;
    private $seconom;
    private $priapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $idubi;

    function getIduser(){return $this->iduser;}
    function getPrinom(){return $this->prinom;}
    function getSeconom(){return $this->seconom;}
    function getPriapel(){return $this->priapel;}
    function getEmailu(){return $this->emailu;}
    function getTeleu(){return $this->teleu;}
    function getFoto(){return $this->foto;}
    function getIdubi(){return $this->idubi;}

    function setIduser($iduser){return $this->iduser = $iduser;}
    function setPrinom($prinom){return $this->prinom = $prinom;}
    function setSeconom($seconom){return $this->seconom = $seconom;}
    function setPriapel($priapel){return $this->priapel = $priapel;}
    function setEmailu($emailu){return $this->emailu = $emailu;}
    function setTeleu($teleu){return $this->teleu = $teleu;}
    function setFoto($foto){return $this->foto = $foto;}
    function setIdubi($idubi){return $this->idubi = $idubi;}

    public function getAll(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu, u.foto, u.idubi, b.nomubi
                    FROM usuario u
                    LEFT JOIN ubicacion b ON u.idubi = b.idubi
                    ORDER BY u.prinom ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error al consultar usuarios: " . $e->getMessage();
            return false;
        }
    }

    public function getOne($iduser){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT iduser, prinom, seconom, priapel, emailu, teleu, foto, idubi
                    FROM usuario WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':iduser', $iduser);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error al consultar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function upd(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET
                        prinom = :prinom,
                        seconom = :seconom,
                        priapel = :priapel,
                        emailu = :emailu,
                        teleu = :teleu,
                        idubi = :idubi
                    WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':prinom', $this->prinom);
            $stmt->bindParam(':seconom', $this->seconom);
            $stmt->bindParam(':priapel', $this->priapel);
            $stmt->bindParam(':emailu', $this->emailu);
            $stmt->bindParam(':teleu', $this->teleu);
            $stmt->bindParam(':idubi', $this->idubi);
            $stmt->bindParam(':iduser', $this->iduser);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al actualizar datos personales: " . $e->getMessage();
            return false;
        }
    }
}
?>