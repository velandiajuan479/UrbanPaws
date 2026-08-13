<?php

class mfacfac
{
    private $idfac;
    private $fechfac;
    private $preciolin;
    private $estafac;
    private $comenfac;
    private $iduser;
    private $iddetfac;

    function getIdfac()
    {
        return $this->idfac;
    }

    function getFechfac()
    {
        return $this->fechfac;
    }

    function getPreciolin()
    {
        return $this->preciolin;
    }

    function getEstafac()
    {
        return $this->estafac;
    }

    function getComenfac()
    {
        return $this->comenfac;
    }

    function getIduser()
    {
        return $this->iduser;
    }

    function getIddetfac()
    {
        return $this->iddetfac;
    }

    function setIdfac($idfac)
    {
        $this->idfac = $idfac;
    }

    function setFechfac($fechfac)
    {
        $this->fechfac = $fechfac;
    }

    function setPreciolin($preciolin)
    {
        $this->preciolin = $preciolin;
    }

    function setEstafac($estafac)
    {
        $this->estafac = $estafac;
    }

    function setComenfac($comenfac)
    {
        $this->comenfac = $comenfac;
    }

    function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    function setIddetfac($iddetfac)
    {
        $this->iddetfac = $iddetfac;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT
                        f.idfac,
                        f.fechfac,
                        f.preciolin,
                        f.estafac,
                        f.comenfac,
                        f.iduser,
                        f.iddetfac,
                        u.docu,
                        CONCAT(u.prinom, ' ', u.priapel) AS cliente
                    FROM factura f
                    INNER JOIN usuario u ON f.iduser = u.iduser
                    ORDER BY f.idfac DESC";

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

    public function getOne()
    {
        try {
            $sql = "SELECT
                        f.idfac,
                        f.fechfac,
                        f.preciolin,
                        f.estafac,
                        f.comenfac,
                        f.iduser,
                        f.iddetfac,
                        u.docu,
                        CONCAT(u.prinom, ' ', u.priapel) AS cliente
                    FROM factura f
                    INNER JOIN usuario u ON f.iduser = u.iduser
                    WHERE f.idfac = :idfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':idfac', $this->idfac, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO factura
                    (
                        fechfac,
                        preciolin,
                        estafac,
                        comenfac,
                        iduser,
                        iddetfac
                    )
                    VALUES
                    (
                        :fechfac,
                        :preciolin,
                        :estafac,
                        :comenfac,
                        :iduser,
                        :iddetfac
                    )";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':fechfac', $this->fechfac, PDO::PARAM_STR);
            $result->bindParam(':preciolin', $this->preciolin, PDO::PARAM_STR);
            $result->bindParam(':estafac', $this->estafac, PDO::PARAM_INT);
            $result->bindParam(':comenfac', $this->comenfac, PDO::PARAM_STR);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->bindParam(':iddetfac', $this->iddetfac, PDO::PARAM_INT);

            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function upd()
    {
        try {
            $sql = "UPDATE factura
                    SET
                        fechfac = :fechfac,
                        preciolin = :preciolin,
                        estafac = :estafac,
                        comenfac = :comenfac,
                        iduser = :iduser,
                        iddetfac = :iddetfac
                    WHERE idfac = :idfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':idfac', $this->idfac, PDO::PARAM_INT);
            $result->bindParam(':fechfac', $this->fechfac, PDO::PARAM_STR);
            $result->bindParam(':preciolin', $this->preciolin, PDO::PARAM_STR);
            $result->bindParam(':estafac', $this->estafac, PDO::PARAM_INT);
            $result->bindParam(':comenfac', $this->comenfac, PDO::PARAM_STR);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->bindParam(':iddetfac', $this->iddetfac, PDO::PARAM_INT);

            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function del()
    {
        try {
            $sql = "DELETE FROM factura WHERE idfac = :idfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':idfac', $this->idfac, PDO::PARAM_INT);
            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }
}

?>