<?php

if (!function_exists('ManejoError')) {
    function ManejoError($e) {
        error_log("UrbanPaws Error: " . $e->getMessage());
    }
}

class mUsuPef
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
    private $idubi;
    private $nomubi;
    private $depaubi;
    private $nomperf;
    private $idperf;   // ✅ Agregado para getAll()

    /* ========================= GETTERS ========================= */
    public function getIduser()  { return $this->iduser; }
    public function getDocu()    { return $this->docu; }
    public function getPrinom()  { return $this->prinom; }
    public function getSeconom() { return $this->seconom; }
    public function getPriapel() { return $this->priapel; }
    public function getEmailu()  { return $this->emailu; }
    public function getTeleu()   { return $this->teleu; }
    public function getFoto()    { return $this->foto; }
    public function getEstusr()  { return $this->estusr; }
    public function getECMusr()  { return $this->ECMusr; }
    public function getIdubi()   { return $this->idubi; }
    public function getNomubi()  { return $this->nomubi; }
    public function getDepaubi() { return $this->depaubi; }
    public function getNomperf() { return $this->nomperf; }
    public function getIdperf()  { return $this->idperf; }

    /* ========================= SETTERS ========================= */
    public function setIduser($iduser)   { $this->iduser = $iduser; }
    public function setDocu($docu)       { $this->docu = $docu; }
    public function setPrinom($prinom)   { $this->prinom = $prinom; }
    public function setSeconom($seconom) { $this->seconom = $seconom; }
    public function setPriapel($priapel) { $this->priapel = $priapel; }
    public function setEmailu($emailu)   { $this->emailu = $emailu; }
    public function setTeleu($teleu)     { $this->teleu = $teleu; }
    public function setFoto($foto)       { $this->foto = $foto; }
    public function setEstusr($estusr)   { $this->estusr = $estusr; }
    public function setECMusr($ECMusr)   { $this->ECMusr = $ECMusr; }
    public function setIdubi($idubi)     { $this->idubi = $idubi; }
    public function setNomubi($nomubi)   { $this->nomubi = $nomubi; }
    public function setDepaubi($depaubi) { $this->depaubi = $depaubi; }
    public function setNomperf($nomperf) { $this->nomperf = $nomperf; }
    public function setIdperf($idperf)   { $this->idperf = $idperf; }

    /* ========================= CONSULTAR UN USUARIO ========================= */
    public function getOne()
    {
        try {
            $sql = "SELECT
                        u.iduser, u.docu, u.prinom, u.seconom, u.priapel,
                        u.emailu, u.teleu, u.foto, u.estusr, u.ECMusr,
                        ub.idubi, ub.nomubi, ub.depaubi,
                        GROUP_CONCAT(p.nomperf SEPARATOR ', ') AS nomperf
                    FROM usuario u
                    LEFT JOIN ubicacion ub ON u.idubi = ub.idubi
                    LEFT JOIN userxper ux ON u.iduser = ux.iduser
                    LEFT JOIN perfil p ON ux.idperf = p.idperf
                    WHERE u.iduser = :iduser
                    GROUP BY
                        u.iduser, u.docu, u.prinom, u.seconom, u.priapel,
                        u.emailu, u.teleu, u.foto, u.estusr, u.ECMusr,
                        ub.idubi, ub.nomubi, ub.depaubi";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            ManejoError($e);
            return false;
        }
    }

    /* ========================= GUARDAR NUEVO USUARIO ========================= */
    public function save()
    {
        try {
            $sql = "INSERT INTO usuario
                        (docu, prinom, seconom, priapel, emailu, teleu, foto, estusr, ECMusr, idubi)
                    VALUES
                        (:docu, :prinom, :seconom, :priapel, :emailu, :teleu, :foto, :estusr, :ECMusr, :idubi)";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $docu    = $this->getDocu();
            $prinom  = $this->getPrinom();
            $seconom = $this->getSeconom();
            $priapel = $this->getPriapel();
            $emailu  = $this->getEmailu();
            $teleu   = $this->getTeleu();
            $foto    = $this->getFoto();
            $estusr  = $this->getEstusr();
            $ECMusr  = $this->getECMusr();
            $idubi   = $this->getIdubi();

            $result->bindParam(":docu",    $docu);
            $result->bindParam(":prinom",  $prinom);
            $result->bindParam(":seconom", $seconom);
            $result->bindParam(":priapel", $priapel);
            $result->bindParam(":emailu",  $emailu);
            $result->bindParam(":teleu",   $teleu);
            $result->bindParam(":foto",    $foto);
            $result->bindParam(":estusr",  $estusr);
            $result->bindParam(":ECMusr",  $ECMusr);
            $result->bindParam(":idubi",   $idubi);

            return $result->execute();
        } catch (Exception $e) {
            ManejoError($e);
            return false;
        }
    }

    /* ========================= ACTUALIZAR USUARIO ========================= */
    public function upd()
    {
        try {
            $sql = "UPDATE usuario SET
                        prinom  = :prinom,
                        priapel = :priapel,
                        emailu  = :emailu,
                        teleu   = :teleu,
                        foto    = :foto
                    WHERE iduser = :iduser";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $iduser  = $this->getIduser();
            $prinom  = $this->getPrinom();
            $priapel = $this->getPriapel();
            $emailu  = $this->getEmailu();
            $teleu   = $this->getTeleu();
            $foto    = $this->getFoto();

            $result->bindParam(":iduser",  $iduser);
            $result->bindParam(":prinom",  $prinom);
            $result->bindParam(":priapel", $priapel);
            $result->bindParam(":emailu",  $emailu);
            $result->bindParam(":teleu",   $teleu);
            $result->bindParam(":foto",    $foto);

            return $result->execute();
        } catch (Exception $e) {
            ManejoError($e);
            return false;
        }
    }

    /* ========================= ELIMINAR USUARIO ========================= */
    public function del()
    {
        try {
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);

            return $result->execute();
        } catch (Exception $e) {
            ManejoError($e);
            return false;
        }
    }

    /* ========================= ACTUALIZAR UBICACIÓN ========================= */
    public function updUbicacion()
    {
        try {
            $sql = "UPDATE ubicacion SET
                        nomubi  = :nomubi,
                        depaubi = :depaubi
                    WHERE idubi = :idubi";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idubi   = $this->getIdubi();
            $nomubi  = $this->getNomubi();
            $depaubi = $this->getDepaubi();

            $result->bindParam(":idubi",   $idubi);
            $result->bindParam(":nomubi",  $nomubi);
            $result->bindParam(":depaubi", $depaubi);

            return $result->execute();
        } catch (Exception $e) {
            ManejoError($e);
            return false;
        }
    }

    /* ========================= LISTAR USUARIOS POR PERFIL ========================= */
    public function getAll()
    {
        try {
            $sql = "SELECT
                        u.iduser, u.docu, u.prinom, u.seconom, u.priapel,
                        u.emailu, u.teleu, u.foto, u.estusr
                    FROM usuario u
                    INNER JOIN userxper ux ON u.iduser = ux.iduser
                    WHERE ux.idperf = :idperf
                    ORDER BY u.iduser";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idperf = $this->getIdperf();
            $result->bindParam(":idperf", $idperf);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            ManejoError($e);
            return [];
        }
    }
}
?>