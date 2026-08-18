<?php

class mfatdatfac
{
    private $iddetfac;
    private $timpfin;
    private $subtotal;
    private $idrut;
    private $idserv;
    private $idmasc;

    function getIddetfac()
    {
        return $this->iddetfac;
    }

    function getTimpfin()
    {
        return $this->timpfin;
    }

    function getSubtotal()
    {
        return $this->subtotal;
    }

    function getIdrut()
    {
        return $this->idrut;
    }

    function getIdserv()
    {
        return $this->idserv;
    }

    function getIdmasc()
    {
        return $this->idmasc;
    }

    function setIddetfac($iddetfac)
    {
        $this->iddetfac = $iddetfac;
    }

    function setTimpfin($timpfin)
    {
        $this->timpfin = $timpfin;
    }

    function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    function setIdrut($idrut)
    {
        $this->idrut = $idrut;
    }

    function setIdserv($idserv)
    {
        $this->idserv = $idserv;
    }

    function setIdmasc($idmasc)
    {
        $this->idmasc = $idmasc;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT
                        d.iddetfac,
                        d.timpfin,
                        d.subtotal,
                        d.idrut,
                        d.idserv,
                        d.idmasc,
                        r.nomrut AS ruta,
                        s.tipserv AS servicio,
                        m.nommasc AS mascota
                    FROM detallefac d
                    INNER JOIN ruta r ON d.idrut = r.idrut
                    INNER JOIN servicio s ON d.idserv = s.idserv
                    INNER JOIN mascotas m ON d.idmasc = m.idmasc
                    ORDER BY d.iddetfac DESC";

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
                        d.iddetfac,
                        d.timpfin,
                        d.subtotal,
                        d.idrut,
                        d.idserv,
                        d.idmasc,
                        r.nomrut AS ruta,
                        s.tipserv AS servicio,
                        m.nommasc AS mascota
                    FROM detallefac d
                    INNER JOIN ruta r ON d.idrut = r.idrut
                    INNER JOIN servicio s ON d.idserv = s.idserv
                    INNER JOIN mascotas m ON d.idmasc = m.idmasc
                    WHERE d.iddetfac = :iddetfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':iddetfac', $this->iddetfac, PDO::PARAM_INT);
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
            $sql = "INSERT INTO detallefac
                    (
                        timpfin,
                        subtotal,
                        idrut,
                        idserv,
                        idmasc
                    )
                    VALUES
                    (
                        :timpfin,
                        :subtotal,
                        :idrut,
                        :idserv,
                        :idmasc
                    )";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':timpfin', $this->timpfin, PDO::PARAM_STR);
            $result->bindParam(':subtotal', $this->subtotal, PDO::PARAM_STR);
            $result->bindParam(':idrut', $this->idrut, PDO::PARAM_INT);
            $result->bindParam(':idserv', $this->idserv, PDO::PARAM_INT);
            $result->bindParam(':idmasc', $this->idmasc, PDO::PARAM_INT);

            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function upd()
    {
        try {
            $sql = "UPDATE detallefac
                    SET
                        timpfin = :timpfin,
                        subtotal = :subtotal,
                        idrut = :idrut,
                        idserv = :idserv,
                        idmasc = :idmasc
                    WHERE iddetfac = :iddetfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':iddetfac', $this->iddetfac, PDO::PARAM_INT);
            $result->bindParam(':timpfin', $this->timpfin, PDO::PARAM_STR);
            $result->bindParam(':subtotal', $this->subtotal, PDO::PARAM_STR);
            $result->bindParam(':idrut', $this->idrut, PDO::PARAM_INT);
            $result->bindParam(':idserv', $this->idserv, PDO::PARAM_INT);
            $result->bindParam(':idmasc', $this->idmasc, PDO::PARAM_INT);

            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function del()
    {
        try {
            $sql = "DELETE FROM detallefac WHERE iddetfac = :iddetfac";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindParam(':iddetfac', $this->iddetfac, PDO::PARAM_INT);
            $result->execute();

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }
}

?>