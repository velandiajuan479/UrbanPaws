<?php
class mExtini
{
    // Atributos basados en tu tabla 'usuario'
    private $iduser;
    private $docu;
    private $prinom;
    private $seconom;
    private $priapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $passusu;
    private $claveu;
    private $estusr;
    private $ECMusr;
    private $idubi;

    // ---------------------------
    // Métodos Getters
    // ---------------------------
    public function getIduser()  { return $this->iduser; }
    public function getDocu()    { return $this->docu; }
    public function getPrinom()  { return $this->prinom; }
    public function getSeconom() { return $this->seconom; }
    public function getPriapel() { return $this->priapel; }
    public function getEmailu()  { return $this->emailu; }
    public function getTeleu()   { return $this->teleu; }
    public function getFoto()    { return $this->foto; }
    public function getPassusu() { return $this->passusu; }
    public function getClaveu()  { return $this->claveu; }
    public function getEstusr()  { return $this->estusr; }
    public function getECMusr()  { return $this->ECMusr; }
    public function getIdubi()   { return $this->idubi; }

    // ---------------------------
    // Métodos Setters
    // ---------------------------
    public function setIduser($iduser)   { $this->iduser = $iduser; }
    public function setDocu($docu)       { $this->docu = $docu; }
    public function setPrinom($prinom)   { $this->prinom = $prinom; }
    public function setSeconom($seconom) { $this->seconom = $seconom; }
    public function setPriapel($priapel) { $this->priapel = $priapel; }
    public function setEmailu($emailu)   { $this->emailu = $emailu; }
    public function setTeleu($teleu)     { $this->teleu = $teleu; }
    public function setFoto($foto)       { $this->foto = $foto; }
    public function setPassusu($passusu) { $this->passusu = $passusu; }
    public function setClaveu($claveu)   { $this->claveu = $claveu; }
    public function setEstusr($estusr)   { $this->estusr = $estusr; }
    public function setECMusr($ECMusr)   { $this->ECMusr = $ECMusr; }
    public function setIdubi($idubi)     { $this->idubi = $idubi; }

    // ---------------------------
    // Métodos generales CRUD
    // ---------------------------
    
    // 1. getAll
    public function getAll(){
        try{
            $sql = "SELECT iduser, docu, prinom, seconom, priapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi FROM usuario ORDER BY iduser DESC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    // 2. getOne
    public function getOne($id) {
        try{
            $sql = "SELECT iduser, docu, prinom, seconom, priapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi FROM usuario WHERE iduser = :id";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(':id', $id);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    // 3. save
    public function save(){
        try{
            $sql = "INSERT INTO usuario (docu, prinom, seconom, priapel, emailu, teleu, foto, passusu, claveu, estusr, ECMusr, idubi) 
                    VALUES (:docu, :prinom, :seconom, :priapel, :emailu, :teleu, :foto, :passusu, :claveu, :estusr, :ECMusr, :idubi)";
            
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            // Usamos variables intermedias para bindValue (evita errores de referencia)
            $docu    = $this->getDocu();
            $prinom  = $this->getPrinom();
            $seconom = $this->getSeconom();
            $priapel = $this->getPriapel();
            $emailu  = $this->getEmailu();
            $teleu   = $this->getTeleu();
            $foto    = $this->getFoto();
            $passusu = $this->getPassusu();
            $claveu  = $this->getClaveu();
            $estusr  = $this->getEstusr();
            $ECMusr  = $this->getECMusr();
            $idubi   = $this->getIdubi();

            $result->bindValue(':docu',    $docu);
            $result->bindValue(':prinom',  $prinom);
            $result->bindValue(':seconom', $seconom);
            $result->bindValue(':priapel', $priapel);
            $result->bindValue(':emailu',  $emailu);
            $result->bindValue(':teleu',   $teleu);
            $result->bindValue(':foto',    $foto);
            $result->bindValue(':passusu', $passusu);
            $result->bindValue(':claveu',  $claveu === null ? null : $claveu, $claveu === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $result->bindValue(':estusr',  $estusr);
            $result->bindValue(':ECMusr',  $ECMusr);
            $result->bindValue(':idubi',   $idubi === null ? null : (int)$idubi, $idubi === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

            return $result->execute();
        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    // 4. upd
    public function upd(){
        try{
            $sql = "UPDATE usuario SET docu=:docu, prinom=:prinom, seconom=:seconom, priapel=:priapel, emailu=:emailu, teleu=:teleu, foto=:foto, passusu=:passusu, claveu=:claveu, estusr=:estusr, ECMusr=:ECMusr, idubi=:idubi WHERE iduser=:iduser";
            
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $iduser  = $this->getIduser();
            $docu    = $this->getDocu();
            $prinom  = $this->getPrinom();
            $seconom = $this->getSeconom();
            $priapel = $this->getPriapel();
            $emailu  = $this->getEmailu();
            $teleu   = $this->getTeleu();
            $foto    = $this->getFoto();
            $passusu = $this->getPassusu();
            $claveu  = $this->getClaveu();
            $estusr  = $this->getEstusr();
            $ECMusr  = $this->getECMusr();
            $idubi   = $this->getIdubi();

            $result->bindValue(':iduser',  $iduser);
            $result->bindValue(':docu',    $docu);
            $result->bindValue(':prinom',  $prinom);
            $result->bindValue(':seconom', $seconom);
            $result->bindValue(':priapel', $priapel);
            $result->bindValue(':emailu',  $emailu);
            $result->bindValue(':teleu',   $teleu);
            $result->bindValue(':foto',    $foto);
            $result->bindValue(':passusu', $passusu);
            $result->bindValue(':claveu',  $claveu, PDO::PARAM_STR);
            $result->bindValue(':estusr',  $estusr);
            $result->bindValue(':ECMusr',  $ECMusr);
            $result->bindValue(':idubi',   $idubi, PDO::PARAM_INT);

            return $result->execute();
        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    // 5. del
    public function del(){
        try{
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $result->bindValue(':iduser', $iduser);
            return $result->execute();
        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }
}
?>