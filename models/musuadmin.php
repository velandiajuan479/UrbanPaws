<?php

class mUsuAdmin
{
    private $iduser;
    private $docu;
    private $prinom;
    private $seconom;
    private $priapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $estusr;
    private $ECMusr;
    private $idperf;

    public function getIduser(){return $this->iduser;}
    public function getDocu(){return $this->docu;}
    public function getPrinom(){return $this->prinom;}
    public function getSeconom(){return $this->seconom;}
    public function getPriapel(){return $this->priapel;}
    public function getEmailu(){return $this->emailu;}
    public function getTeleu(){return $this->teleu;}
    public function getFoto(){return $this->foto;}
    public function getEstusr(){return $this->estusr;}
    public function getECMusr(){return $this->ECMusr;}
    public function getIdperf(){return $this->idperf;}

    public function setIduser($iduser){$this->iduser=$iduser;}
    public function setDocu($docu){$this->docu=$docu;}
    public function setPrinom($prinom){$this->prinom=$prinom;}
    public function setSeconom($seconom){$this->seconom=$seconom;}
    public function setPriapel($priapel){$this->priapel=$priapel;}
    public function setEmailu($emailu){$this->emailu=$emailu;}
    public function setTeleu($teleu){$this->teleu=$teleu;}
    public function setFoto($foto){$this->foto=$foto;}
    public function setEstusr($estusr){$this->estusr=$estusr;}
    public function setECMusr($ECMusr){$this->ECMusr=$ECMusr;}
    public function setIdperf($idperf){$this->idperf=$idperf;}

    public function getAll()
    {
        try{
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom,
                           u.priapel, u.emailu, u.teleu, u.foto,
                           u.estusr, u.ECMusr,
                           GROUP_CONCAT(p.nomperf SEPARATOR ', ') AS nomperf
                    FROM usuario u
                    LEFT JOIN userxper ux ON u.iduser = ux.iduser
                    LEFT JOIN perfil p ON ux.idperf = p.idperf
                    GROUP BY u.iduser, u.docu, u.prinom, u.seconom,
                             u.priapel, u.emailu, u.teleu, u.foto,
                             u.estusr, u.ECMusr
                    ORDER BY u.iduser";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            ManejoError($e);
        }
    }

    public function getOne()
    {
        try{
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom,
                           u.priapel, u.emailu, u.teleu, u.foto,
                           u.estusr, u.ECMusr,
                           GROUP_CONCAT(p.nomperf SEPARATOR ', ') AS nomperf
                    FROM usuario u
                    LEFT JOIN userxper ux ON u.iduser = ux.iduser
                    LEFT JOIN perfil p ON ux.idperf = p.idperf
                    WHERE u.iduser = :iduser
                    GROUP BY u.iduser";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            ManejoError($e);
        }
    }

    public function upd()
    {
        try{
            $sql = "UPDATE usuario SET
                        docu = :docu,
                        prinom = :prinom,
                        seconom = :seconom,
                        priapel = :priapel,
                        emailu = :emailu,
                        teleu = :teleu,
                        foto = :foto,
                        estusr = :estusr,
                        ECMusr = :ECMusr
                    WHERE iduser = :iduser";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $iduser=$this->getIduser();
            $docu=$this->getDocu();
            $prinom=$this->getPrinom();
            $seconom=$this->getSeconom();
            $priapel=$this->getPriapel();
            $emailu=$this->getEmailu();
            $teleu=$this->getTeleu();
            $foto=$this->getFoto();
            $estusr=$this->getEstusr();
            $ECMusr=$this->getECMusr();

            $result->bindParam(":iduser",$iduser);
            $result->bindParam(":docu",$docu);
            $result->bindParam(":prinom",$prinom);
            $result->bindParam(":seconom",$seconom);
            $result->bindParam(":priapel",$priapel);
            $result->bindParam(":emailu",$emailu);
            $result->bindParam(":teleu",$teleu);
            $result->bindParam(":foto",$foto);
            $result->bindParam(":estusr",$estusr);
            $result->bindParam(":ECMusr",$ECMusr);

            return $result->execute();
        }catch(Exception $e){
            ManejoError($e);
        }
    }

    public function del()
    {
        try{
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser=$this->getIduser();
            $result->bindParam(":iduser",$iduser);
            return $result->execute();
        }catch(Exception $e){
            ManejoError($e);
        }
    }
}
?>