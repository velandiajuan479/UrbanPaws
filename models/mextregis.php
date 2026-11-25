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
    private $error;
    
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
    function getError(){
        return $this->error;
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
        $conexion = NULL;
        $sql = "INSERT INTO usuario
                (prinom, seconom, priapel, segapel, docu, teleu, emailu, passusu, estusr)
                VALUES
                (:prinom, :seconom, :priapel, :segapel, :docu, :teleu, :emailu, :passusu, :estusr)";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->beginTransaction();

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
            $result->execute();

            // Todo registro público nace con el perfil Cliente (idperf = 2).
            $iduser = (int) $conexion->lastInsertId();
            $rol = $conexion->prepare("INSERT INTO userxper (iduser, idperf) VALUES (:iduser, :idperf)");
            $rol->bindValue(":iduser", $iduser, PDO::PARAM_INT);
            $rol->bindValue(":idperf", 2, PDO::PARAM_INT);
            $rol->execute();

            $conexion->commit();
            $this->setIduser($iduser);
            return true;
        } catch (Exception $e) {
            if ($conexion && $conexion->inTransaction()) {
                $conexion->rollBack();
            }
            error_log('UrbanPaws Registro Error: ' . $e->getMessage());
            $this->error = 'No fue posible completar el registro. Verifica que el documento, correo y teléfono no estén en uso.';
            return false;
        }
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
