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
    private $idubi;
    private $errcod = 0;

    function getErrcod(){return $this->errcod;}
    function setIduser($iduser){$this->iduser = (int) $iduser;}
    function setPrinom($prinom){$this->prinom = $prinom;}
    function setSeconom($seconom){$this->seconom = $seconom;}
    function setPriapel($priapel){$this->priapel = $priapel;}
    function setEmailu($emailu){$this->emailu = $emailu;}
    function setTeleu($teleu){$this->teleu = $teleu;}
    function setIdubi($idubi){$this->idubi = (int) $idubi;}

    public function getOne($iduser){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu, u.foto, u.idubi,
                           b.nomubi, b.depaubi
                    FROM usuario u LEFT JOIN ubicacion b ON u.idubi = b.idubi
                    WHERE u.iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':iduser', (int) $iduser, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            error_log("mUsuDatPer::getOne " . $e->getMessage());
            return false;
        }
    }

    public function upd(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET prinom = :prinom, seconom = :seconom, priapel = :priapel,
                                       emailu = :emailu, teleu = :teleu, idubi = :idubi
                    WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':prinom', $this->prinom);
            $stmt->bindValue(':seconom', $this->seconom);
            $stmt->bindValue(':priapel', $this->priapel);
            $stmt->bindValue(':emailu', $this->emailu);
            $stmt->bindValue(':teleu', $this->teleu);
            $stmt->bindValue(':idubi', $this->idubi, PDO::PARAM_INT);
            $stmt->bindValue(':iduser', $this->iduser, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);   // 1062 = correo o teléfono repetido
            error_log("mUsuDatPer::upd " . $e->getMessage());
            return false;
        }
    }
}
?>
