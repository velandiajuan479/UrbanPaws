<?php

require_once 'conexion.php';

class mServRut
{
    private $idrut;
    private $nomrut;
    private $distrut;
    private $iduser;
    private $idubi;
    private $estarut;
    private $horaini;
    private $horafin;
    private $precioini;

    /* ========================= GETTERS ========================= */
    public function getIdrut()    { return $this->idrut; }
    public function getNomrut()   { return $this->nomrut; }
    public function getDistrut()  { return $this->distrut; }
    public function getIduser()   { return $this->iduser; }
    public function getIdubi()    { return $this->idubi; }
    public function getEstarut()  { return $this->estarut; }
    public function getHoraini()  { return $this->horaini; }
    public function getHorafin()  { return $this->horafin; }
    public function getPrecioini(){ return $this->precioini; }

    /* ========================= SETTERS ========================= */
    public function setIdrut($idrut)      { $this->idrut = $idrut; }
    public function setNomrut($nomrut)    { $this->nomrut = $nomrut; }
    public function setDistrut($distrut)  { $this->distrut = $distrut; }
    public function setIduser($iduser)    { $this->iduser = $iduser; }
    public function setIdubi($idubi)      { $this->idubi = $idubi; }
    public function setEstarut($estarut)  { $this->estarut = $estarut; }
    public function setHoraini($horaini)  { $this->horaini = $horaini; }
    public function setHorafin($horafin)  { $this->horafin = $horafin; }
    public function setPrecioini($precioini) { $this->precioini = $precioini; }

    /* ========================= TODAS LAS RUTAS ========================= */
    public function getAll()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           r.horaini, r.horafin, r.precioini,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel
                    FROM ruta r
                    LEFT JOIN usuario u   ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    ORDER BY r.idrut ASC";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return [];
        }
    }

    /* ========================= UNA RUTA (con datos del paseador) ========================= */
    public function getOne()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           r.horaini, r.horafin, r.precioini,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel,
                           u.foto, u.emailu, u.teleu, u.docu
                    FROM ruta r
                    LEFT JOIN usuario u   ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.idrut = :idrut";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idrut = $this->getIdrut();
            $result->bindParam(":idrut", $idrut);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= RUTAS DE UN PASEADOR ========================= */
    public function getByUser()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           r.horaini, r.horafin, r.precioini,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel
                    FROM ruta r
                    LEFT JOIN usuario u   ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.iduser = :iduser
                    ORDER BY r.idrut ASC";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $iduser = $this->getIduser();
            $result->bindParam(":iduser", $iduser);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return [];
        }
    }

    /* ========================= RUTAS ACTIVAS SEGÚN LA UBICACIÓN DEL CLIENTE ========================= */
    public function getActivas()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           r.horaini, r.horafin, r.precioini,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel,
                           u.foto
                    FROM ruta r
                    LEFT JOIN usuario u   ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.estarut = 1
                      AND (:idubi IS NULL OR r.idubi = :idubi)
                    ORDER BY r.nomrut ASC";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idubi = $this->getIdubi();
            $result->bindParam(":idubi", $idubi);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return [];
        }
    }

    /* ========================= GUARDAR NUEVA RUTA ========================= */
    public function save()
    {
        try {
            $sql = "INSERT INTO ruta (nomrut, distrut, iduser, idubi, estarut, horaini, horafin, precioini)
                    VALUES (:nomrut, :distrut, :iduser, :idubi, :estarut, :horaini, :horafin, :precioini)";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $nomrut    = $this->getNomrut();
            $distrut   = $this->getDistrut();
            $iduser    = $this->getIduser();
            $idubi     = $this->getIdubi();
            $estarut   = $this->getEstarut();
            $horaini   = $this->getHoraini();
            $horafin   = $this->getHorafin();
            $precioini = $this->getPrecioini();

            $result->bindParam(":nomrut",    $nomrut);
            $result->bindParam(":distrut",   $distrut);
            $result->bindParam(":iduser",    $iduser);
            $result->bindParam(":idubi",     $idubi);
            $result->bindParam(":estarut",   $estarut);
            $result->bindParam(":horaini",   $horaini);
            $result->bindParam(":horafin",   $horafin);
            $result->bindParam(":precioini", $precioini);

            $result->execute();

            return $conexion->lastInsertId();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= ACTUALIZAR RUTA ========================= */
    public function upd()
    {
        try {
            $sql = "UPDATE ruta SET
                        nomrut    = :nomrut,
                        distrut   = :distrut,
                        iduser    = :iduser,
                        idubi     = :idubi,
                        estarut   = :estarut,
                        horaini   = :horaini,
                        horafin   = :horafin,
                        precioini = :precioini
                    WHERE idrut = :idrut";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idrut     = $this->getIdrut();
            $nomrut    = $this->getNomrut();
            $distrut   = $this->getDistrut();
            $iduser    = $this->getIduser();
            $idubi     = $this->getIdubi();
            $estarut   = $this->getEstarut();
            $horaini   = $this->getHoraini();
            $horafin   = $this->getHorafin();
            $precioini = $this->getPrecioini();

            $result->bindParam(":idrut",     $idrut);
            $result->bindParam(":nomrut",    $nomrut);
            $result->bindParam(":distrut",   $distrut);
            $result->bindParam(":iduser",    $iduser);
            $result->bindParam(":idubi",     $idubi);
            $result->bindParam(":estarut",   $estarut);
            $result->bindParam(":horaini",   $horaini);
            $result->bindParam(":horafin",   $horafin);
            $result->bindParam(":precioini", $precioini);

            return $result->execute();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= ELIMINAR RUTA ========================= */
    public function del()
    {
        try {
            $sql = "DELETE FROM ruta WHERE idrut = :idrut";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idrut = $this->getIdrut();
            $result->bindParam(":idrut", $idrut);

            return $result->execute();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }
}
?>