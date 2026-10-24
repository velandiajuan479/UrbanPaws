<?php

if (!function_exists('ManejoError')) {
    function ManejoError($e) {
        error_log("UrbanPaws Error: " . $e->getMessage());
    }
}

class mUsuAdmin
{
    private $iduser;
    private $docu;
    private $prinom;
    private $seconom;
    private $priapel;
    private $segapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $passusu;
    private $estusr;
    private $ECMusr;
    private $idperf;
    private $error;

    public function getIduser(){return $this->iduser;}
    public function getDocu(){return $this->docu;}
    public function getPrinom(){return $this->prinom;}
    public function getSeconom(){return $this->seconom;}
    public function getPriapel(){return $this->priapel;}
    public function getSegapel(){return $this->segapel;}
    public function getEmailu(){return $this->emailu;}
    public function getTeleu(){return $this->teleu;}
    public function getFoto(){return $this->foto;}
    public function getPassusu(){return $this->passusu;}
    public function getEstusr(){return $this->estusr;}
    public function getECMusr(){return $this->ECMusr;}
    public function getIdperf(){return $this->idperf;}
    public function getError(){return $this->error;}

    public function setIduser($iduser){$this->iduser=$iduser;}
    public function setDocu($docu){$this->docu=$docu;}
    public function setPrinom($prinom){$this->prinom=$prinom;}
    public function setSeconom($seconom){$this->seconom=$seconom;}
    public function setPriapel($priapel){$this->priapel=$priapel;}
    public function setSegapel($segapel){$this->segapel=$segapel;}
    public function setEmailu($emailu){$this->emailu=$emailu;}
    public function setTeleu($teleu){$this->teleu=$teleu;}
    public function setFoto($foto){$this->foto=$foto;}
    public function setPassusu($passusu){$this->passusu=$passusu;}
    public function setEstusr($estusr){$this->estusr=$estusr;}
    public function setECMusr($ECMusr){$this->ECMusr=$ECMusr;}
    public function setIdperf($idperf){$this->idperf=$idperf;}

    private function setError($mensaje){$this->error=$mensaje;}

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
            $this->setError($e->getMessage());
            return NULL;
        }
    }

    public function getOne()
    {
        try{
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom,
                           u.priapel, u.segapel, u.emailu, u.teleu, u.foto,
                           u.estusr, u.ECMusr
                    FROM usuario u
                    WHERE u.iduser = :iduser";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($e->getMessage());
            return NULL;
        }
    }

    public function ins()
    {
        try{
            $sql = "INSERT INTO usuario
                        (docu, prinom, seconom, priapel, segapel,
                         emailu, teleu, foto, passusu, estusr, ECMusr)
                    VALUES
                        (:docu, :prinom, :seconom, :priapel, :segapel,
                         :emailu, :teleu, :foto, :passusu, :estusr, :ECMusr)";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $docu=$this->getDocu();
            $prinom=$this->getPrinom();
            $seconom=$this->getSeconom();
            $priapel=$this->getPriapel();
            $segapel=$this->getSegapel();
            $emailu=$this->getEmailu();
            $teleu=$this->getTeleu();
            $foto=$this->getFoto();
            $passusu=$this->getPassusu();
            if($passusu !== NULL AND $passusu !== ""){
                $passusu = password_hash($passusu, PASSWORD_DEFAULT);
            }
            $estusr=$this->getEstusr();
            $ECMusr=$this->getECMusr();

            $result->bindParam(":docu",$docu);
            $result->bindParam(":prinom",$prinom);
            $result->bindParam(":seconom",$seconom);
            $result->bindParam(":priapel",$priapel);
            $result->bindParam(":segapel",$segapel);
            $result->bindParam(":emailu",$emailu);
            $result->bindParam(":teleu",$teleu);
            $result->bindParam(":foto",$foto);
            $result->bindParam(":passusu",$passusu);
            $result->bindParam(":estusr",$estusr);
            $result->bindParam(":ECMusr",$ECMusr);

            $result->execute();
            $this->setIduser($conexion->lastInsertId());
            return $this->getIduser();
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($this->mensajeLegible($e));
            return NULL;
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
                        segapel = :segapel,
                        emailu = :emailu,
                        teleu = :teleu,
                        estusr = :estusr
                    WHERE iduser = :iduser";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $iduser=$this->getIduser();
            $docu=$this->getDocu();
            $prinom=$this->getPrinom();
            $seconom=$this->getSeconom();
            $priapel=$this->getPriapel();
            $segapel=$this->getSegapel();
            $emailu=$this->getEmailu();
            $teleu=$this->getTeleu();
            $estusr=$this->getEstusr();

            $result->bindParam(":iduser",$iduser);
            $result->bindParam(":docu",$docu);
            $result->bindParam(":prinom",$prinom);
            $result->bindParam(":seconom",$seconom);
            $result->bindParam(":priapel",$priapel);
            $result->bindParam(":segapel",$segapel);
            $result->bindParam(":emailu",$emailu);
            $result->bindParam(":teleu",$teleu);
            $result->bindParam(":estusr",$estusr);

            $resultado = $result->execute();

            $pass = $this->getPassusu();
            if($pass !== NULL AND $pass !== ""){
                $resultado = $this->updPass($pass);
            }

            return $resultado;
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($this->mensajeLegible($e));
            return NULL;
        }
    }

    private function updPass($passusu)
    {
        try{
            $sql = "UPDATE usuario SET passusu = :passusu WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $hash = password_hash($passusu, PASSWORD_DEFAULT);
            $iduser = $this->getIduser();
            $result->bindParam(":passusu", $hash);
            $result->bindParam(":iduser", $iduser);
            return $result->execute();
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($this->mensajeLegible($e));
            return NULL;
        }
    }

    public function del()
    {
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        try{
            $conexion->beginTransaction();

            $sql = "DELETE FROM userxper WHERE iduser = :iduser";
            $result = $conexion->prepare($sql);
            $iduser=$this->getIduser();
            $result->bindParam(":iduser",$iduser);
            $result->execute();

            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $result = $conexion->prepare($sql);
            $result->bindParam(":iduser",$iduser);
            $resultado = $result->execute();

            $conexion->commit();
            return $resultado;
        }catch(Exception $e){
            $conexion->rollBack();
            ManejoError($e);
            $this->setError($this->mensajeLegible($e));
            return NULL;
        }
    }

    public function getPerfiles()
    {
        try{
            $sql = "SELECT idperf, nomperf FROM perfil ORDER BY idperf";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($e->getMessage());
            return NULL;
        }
    }

    public function getRolesUsuario()
    {
        try{
            $sql = "SELECT idperf FROM userxper WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);
            $result->execute();
            $filas = $result->fetchAll(PDO::FETCH_ASSOC);
            $ids = array();
            foreach($filas as $f){
                $ids[] = (int) $f["idperf"];
            }
            return $ids;
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($e->getMessage());
            return array();
        }
    }

    public function asignarRoles()
    {
        $idperf = $this->getIdperf();
        if(!$idperf){
            $this->setError("Debe seleccionar un rol (perfil).");
            return NULL;
        }
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        try{
            $iduser = $this->getIduser();
            if(!$iduser){
                $this->setError("Usuario no identificado para asignar el rol.");
                return NULL;
            }

            $conexion->beginTransaction();

            $sql = "DELETE FROM userxper WHERE iduser = :iduser";
            $result = $conexion->prepare($sql);
            $result->bindParam(":iduser", $iduser);
            $result->execute();

            $sql = "INSERT INTO userxper (iduser, idperf) VALUES (:iduser, :idperf)";
            $result = $conexion->prepare($sql);
            $result->bindParam(":iduser", $iduser);
            $result->bindParam(":idperf", $idperf);
            $resultado = $result->execute();

            $conexion->commit();
            return $resultado;
        }catch(Exception $e){
            $conexion->rollBack();
            ManejoError($e);
            $this->setError($this->mensajeLegible($e));
            return NULL;
        }
    }

    private function mensajeLegible($e)
    {
        if($e instanceof PDOException AND isset($e->errorInfo[1]) AND (int) $e->errorInfo[1] == 1062){
            return "Ya existe un registro con esos datos (valor duplicado).";
        }
        if($e instanceof PDOException AND isset($e->errorInfo[1]) AND (int) $e->errorInfo[1] == 1451){
            return "No se puede eliminar: el registro tiene datos relacionados.";
        }
        return "No fue posible completar la operación. Verifica los datos ingresados.";
    }
}
?>
