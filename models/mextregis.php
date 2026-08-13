<?php
require_once 'conexion.php';

class mExtregis {
    // Atributos (Tabla usuario)
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

    // --- GETTERS ---
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

    // --- SETTERS ---
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

    // --- FUNCIONES CRUD ---

    // 1. getAll
    public function getAll() {
        try {
            $sql = "SELECT iduser, prinom, priapel, emailu, estusr FROM usuario ORDER BY iduser DESC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // 2. getOne
    public function getOne($id) {
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

    // 3. save
    public function save() {
        try {
            $sql = "INSERT INTO usuario (docu, prinom, seconom, priapel, emailu, teleu, passusu, claveu, estusr, ECMusr, idubi) 
                    VALUES (:docu, :prinom, :seconom, :priapel, :emailu, :teleu, :passusu, :claveu, :estusr, :ECMusr, :idubi)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':docu',    $this->getDocu());
            $result->bindParam(':prinom',  $this->getPrinom());
            $result->bindParam(':seconom', $this->getSeconom());
            $result->bindParam(':priapel', $this->getPriapel());
            $result->bindParam(':emailu',  $this->getEmailu());
            $result->bindParam(':teleu',   $this->getTeleu());
            $result->bindParam(':passusu', $this->getPassusu());
            $result->bindParam(':claveu',  $this->getClaveu());
            $result->bindParam(':estusr',  $this->getEstusr());
            $result->bindParam(':ECMusr',  $this->getECMusr());
            $result->bindParam(':idubi',   $this->getIdubi());
            return $result->execute();
        } catch (PDOException $e) {
            echo "Error al registrar: " . $e->getMessage();
            return false;
        }
    }

    // 4. upd
    public function upd() {
        try {
            $sql = "UPDATE usuario SET docu=:docu, prinom=:prinom, seconom=:seconom, priapel=:priapel, emailu=:emailu, teleu=:teleu, passusu=:passusu, claveu=:claveu, estusr=:estusr, ECMusr=:ECMusr, idubi=:idubi WHERE iduser=:iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':iduser',  $this->getIduser());
            $result->bindParam(':docu',    $this->getDocu());
            $result->bindParam(':prinom',  $this->getPrinom());
            $result->bindParam(':seconom', $this->getSeconom());
            $result->bindParam(':priapel', $this->getPriapel());
            $result->bindParam(':emailu',  $this->getEmailu());
            $result->bindParam(':teleu',   $this->getTeleu());
            $result->bindParam(':passusu', $this->getPassusu());
            $result->bindParam(':claveu',  $this->getClaveu());
            $result->bindParam(':estusr',  $this->getEstusr());
            $result->bindParam(':ECMusr',  $this->getECMusr());
            $result->bindParam(':idubi',   $this->getIdubi());
            return $result->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar: " . $e->getMessage();
            return false;
        }
    }

    // 5. del
    public function del() {
        try {
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':iduser', $this->getIduser());
            return $result->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar: " . $e->getMessage();
            return false;
        }
    }

    // --- FUNCIÓN ESPECÍFICA PARA REGISTRO ---

    // Buscar por Email (para verificar si ya existe)
    public function getByEmail() {
        try {
            $sql = "SELECT * FROM usuario WHERE emailu = :emailu";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $emailu = $this->getEmailu();
            $result->bindParam(':emailu', $emailu);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>