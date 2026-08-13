<?php

class mUsucli
{
    // ATRIBUTOS

    private $idusu;
    private $docu;
    private $prinom;
    private $seconom;
    private $priapel;
    private $seapel;
    private $emailu;
    private $teleu;
    private $foto;
    private $passusu;
    private $claveu;
    private $idperf;
    private $idubi;


    // GETTERS

    public function getIdusu()
    {
        return $this->idusu;
    }

    public function getDocu()
    {
        return $this->docu;
    }

    public function getPrinom()
    {
        return $this->prinom;
    }

    public function getSeconom()
    {
        return $this->seconom;
    }

    public function getPriapel()
    {
        return $this->priapel;
    }

    public function getSeapel()
    {
        return $this->seapel;
    }

    public function getEmailu()
    {
        return $this->emailu;
    }

    public function getTeleu()
    {
        return $this->teleu;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getPassusu()
    {
        return $this->passusu;
    }

    public function getClaveu()
    {
        return $this->claveu;
    }

    public function getIdperf()
    {
        return $this->idperf;
    }

    public function getIdubi()
    {
        return $this->idubi;
    }


    // SETTERS

    public function setIdusu($idusu)
    {
        $this->idusu = $idusu;
    }

    public function setDocu($docu)
    {
        $this->docu = $docu;
    }

    public function setPrinom($prinom)
    {
        $this->prinom = $prinom;
    }

    public function setSeconom($seconom)
    {
        $this->seconom = $seconom;
    }

    public function setPriapel($priapel)
    {
        $this->priapel = $priapel;
    }

    public function setSeapel($seapel)
    {
        $this->seapel = $seapel;
    }

    public function setEmailu($emailu)
    {
        $this->emailu = $emailu;
    }

    public function setTeleu($teleu)
    {
        $this->teleu = $teleu;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function setPassusu($passusu)
    {
        $this->passusu = $passusu;
    }

    public function setClaveu($claveu)
    {
        $this->claveu = $claveu;
    }

    public function setIdperf($idperf)
    {
        $this->idperf = $idperf;
    }

    public function setIdubi($idubi)
    {
        $this->idubi = $idubi;
    }


    // MÉTODOS

    public function getAll()
    {
        try {

            $sql = "SELECT *
                    FROM usuario
                    WHERE idperf = :idperf";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);

            $idperf = $this->getIdperf();

            $result->bindParam(":idperf", $idperf);

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) 
    }


    public function getOne()
    {
        try {

            $sql = "SELECT * FROM usuario WHERE idusu = :idusu";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);

            $idusu = $this->getIdusu();

            $result->bindParam(":idusu", $idusu);

            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {

            ManejoError($e);

        }
    }


    public function save()
    {
        try {

            $sql = "INSERT INTO usuario
                    (docu, prinom, seconom, priapel, seapel,
                     emailu, teleu, foto, passusu,
                     claveu, idperf, idubi)

                    VALUES
                    (:docu, :prinom, :seconom, :priapel, :seapel,
                     :emailu, :teleu, :foto, :passusu,
                     :claveu, :idperf, :idubi)";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);

            $docu = $this->getDocu();
            $prinom = $this->getPrinom();
            $seconom = $this->getSeconom();
            $priapel = $this->getPriapel();
            $seapel = $this->getSeapel();
            $emailu = $this->getEmailu();
            $teleu = $this->getTeleu();
            $foto = $this->getFoto();
            $passusu = $this->getPassusu();
            $claveu = $this->getClaveu();
            $idperf = $this->getIdperf();
            $idubi = $this->getIdubi();

            $result->bindParam(":docu", $docu);
            $result->bindParam(":prinom", $prinom);
            $result->bindParam(":seconom", $seconom);
            $result->bindParam(":priapel", $priapel);
            $result->bindParam(":seapel", $seapel);
            $result->bindParam(":emailu", $emailu);
            $result->bindParam(":teleu", $teleu);
            $result->bindParam(":foto", $foto);
            $result->bindParam(":passusu", $passusu);
            $result->bindParam(":claveu", $claveu);
            $result->bindParam(":idperf", $idperf);
            $result->bindParam(":idubi", $idubi);

            return $result->execute();

        } catch (Exception $e) {

            ManejoError($e);

        }
    }


    public function upd()
    {
        try {

            $sql = "UPDATE usuario SET
                    docu = :docu,
                    prinom = :prinom,
                    seconom = :seconom,
                    priapel = :priapel,
                    seapel = :seapel,
                    emailu = :emailu,
                    teleu = :teleu,
                    foto = :foto,
                    idperf = :idperf,
                    idubi = :idubi

                    WHERE idusu = :idusu";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);

            $idusu = $this->getIdusu();
            $docu = $this->getDocu();
            $prinom = $this->getPrinom();
            $seconom = $this->getSeconom();
            $priapel = $this->getPriapel();
            $seapel = $this->getSeapel();
            $emailu = $this->getEmailu();
            $teleu = $this->getTeleu();
            $foto = $this->getFoto();
            $idperf = $this->getIdperf();
            $idubi = $this->getIdubi();

            $result->bindParam(":idusu", $idusu);
            $result->bindParam(":docu", $docu);
            $result->bindParam(":prinom", $prinom);
            $result->bindParam(":seconom", $seconom);
            $result->bindParam(":priapel", $priapel);
            $result->bindParam(":seapel", $seapel);
            $result->bindParam(":emailu", $emailu);
            $result->bindParam(":teleu", $teleu);
            $result->bindParam(":foto", $foto);
            $result->bindParam(":idperf", $idperf);
            $result->bindParam(":idubi", $idubi);

            return $result->execute();

        } catch (Exception $e) {

            ManejoError($e);

        }
    }


    public function del()
    {
        try {

            $sql = "DELETE FROM usuario
                    WHERE idusu = :idusu";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);

            $idusu = $this->getIdusu();

            $result->bindParam(":idusu", $idusu);

            return $result->execute();

        } catch (Exception $e) {

            ManejoError($e);

        }
    }
}
?>