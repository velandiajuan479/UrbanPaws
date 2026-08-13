<?php

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


    /* =========================
       GETTERS
       ========================= */

    public function getIduser()
    {
        return $this->iduser;
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

    public function getEstusr()
    {
        return $this->estusr;
    }

    public function getECMusr()
    {
        return $this->ECMusr;
    }

    public function getIdubi()
    {
        return $this->idubi;
    }

    public function getNomubi()
    {
        return $this->nomubi;
    }

    public function getDepaubi()
    {
        return $this->depaubi;
    }

    public function getNomperf()
    {
        return $this->nomperf;
    }


    /* =========================
       SETTERS
       ========================= */

    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
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

    public function setEstusr($estusr)
    {
        $this->estusr = $estusr;
    }

    public function setECMusr($ECMusr)
    {
        $this->ECMusr = $ECMusr;
    }

    public function setIdubi($idubi)
    {
        $this->idubi = $idubi;
    }

    public function setNomubi($nomubi)
    {
        $this->nomubi = $nomubi;
    }

    public function setDepaubi($depaubi)
    {
        $this->depaubi = $depaubi;
    }

    public function setNomperf($nomperf)
    {
        $this->nomperf = $nomperf;
    }


    /* =========================
       CONSULTAR UN USUARIO
       ========================= */

    public function getOne()
    {
        try {

            $sql = "SELECT 
                        u.iduser,
                        u.docu,
                        u.prinom,
                        u.seconom,
                        u.priapel,
                        u.emailu,
                        u.teleu,
                        u.foto,
                        u.estusr,
                        u.ECMusr,
                        ub.idubi,
                        ub.nomubi,
                        ub.depaubi,
                        GROUP_CONCAT(
                            p.nomperf 
                            SEPARATOR ', '
                        ) AS nomperf

                    FROM usuario u

                    LEFT JOIN ubicacion ub
                        ON u.idubi = ub.idubi

                    LEFT JOIN userxper ux
                        ON u.iduser = ux.iduser

                    LEFT JOIN perfil p
                        ON ux.idperf = p.idperf

                    WHERE u.iduser = :iduser

                    GROUP BY
                        u.iduser,
                        u.docu,
                        u.prinom,
                        u.seconom,
                        u.priapel,
                        u.emailu,
                        u.teleu,
                        u.foto,
                        u.estusr,
                        u.ECMusr,
                        ub.idubi,
                        ub.nomubi,
                        ub.depaubi";


            $modelo = new Conexion();

            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);


            $iduser = $this->getIduser();

            $result->bindParam(":iduser", $iduser);


            $result->execute();


            return $result->fetch(PDO::FETCH_ASSOC);


        } catch (Exception $e) {

            ManejoError($e);

        }
    }


    /* =========================
       ACTUALIZAR USUARIO
       ========================= */

    public function upd()
    {
        try {

            $sql = "UPDATE usuario SET
                        prinom = :prinom,
                        priapel = :priapel,
                        emailu = :emailu,
                        teleu = :teleu,
                        foto = :foto

                    WHERE iduser = :iduser";


            $modelo = new Conexion();

            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);


            $iduser = $this->getIduser();
            $prinom = $this->getPrinom();
            $priapel = $this->getPriapel();
            $emailu = $this->getEmailu();
            $teleu = $this->getTeleu();
            $foto = $this->getFoto();


            $result->bindParam(":iduser", $iduser);
            $result->bindParam(":prinom", $prinom);
            $result->bindParam(":priapel", $priapel);
            $result->bindParam(":emailu", $emailu);
            $result->bindParam(":teleu", $teleu);
            $result->bindParam(":foto", $foto);


            return $result->execute();


        } catch (Exception $e) {

            ManejoError($e);

        }
    }


    /* =========================
       ACTUALIZAR UBICACION
       ========================= */

    public function updUbicacion()
    {
        try {

            $sql = "UPDATE ubicacion SET
                        nomubi = :nomubi,
                        depaubi = :depaubi

                    WHERE idubi = :idubi";


            $modelo = new Conexion();

            $conexion = $modelo->get_conexion();

            $result = $conexion->prepare($sql);


            $idubi = $this->getIdubi();
            $nomubi = $this->getNomubi();
            $depaubi = $this->getDepaubi();


            $result->bindParam(":idubi", $idubi);
            $result->bindParam(":nomubi", $nomubi);
            $result->bindParam(":depaubi", $depaubi);


            return $result->execute();


        } catch (Exception $e) {

            ManejoError($e);

        }
    }
}

?>