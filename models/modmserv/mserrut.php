<?php

require_once __DIR__ . '/../conexion.php';

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
    private $direccion_rut;
    private $referencia_rut;

    public function getIdrut()        { return $this->idrut; }
    public function getNomrut()       { return $this->nomrut; }
    public function getDistrut()      { return $this->distrut; }
    public function getIduser()       { return $this->iduser; }
    public function getIdubi()        { return $this->idubi; }
    public function getEstarut()      { return $this->estarut; }
    public function getHoraini()      { return $this->horaini; }
    public function getHorafin()      { return $this->horafin; }
    public function getPrecioini()    { return $this->precioini; }
    public function getDireccionRut() { return $this->direccion_rut; }
    public function getReferenciaRut(){ return $this->referencia_rut; }

    public function setIdrut($idrut)               { $this->idrut = $idrut; }
    public function setNomrut($nomrut)             { $this->nomrut = $nomrut; }
    public function setDistrut($distrut)           { $this->distrut = $distrut; }
    public function setIduser($iduser)             { $this->iduser = $iduser; }
    public function setIdubi($idubi)               { $this->idubi = $idubi; }
    public function setEstarut($estarut)           { $this->estarut = $estarut; }
    public function setHoraini($horaini)           { $this->horaini = $horaini; }
    public function setHorafin($horafin)           { $this->horafin = $horafin; }
    public function setPrecioini($precioini)       { $this->precioini = $precioini; }
    public function setDireccionRut($direccion_rut){ $this->direccion_rut = $direccion_rut; }
    public function setReferenciaRut($referencia_rut){ $this->referencia_rut = $referencia_rut; }

    public function getAll()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           TIME_FORMAT(r.horaini, '%H:%i') AS horaini_fmt,
                           TIME_FORMAT(r.horafin, '%H:%i') AS horafin_fmt,
                           r.precioini, r.direccion_rut, r.referencia_rut,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel
                    FROM ruta r
                    LEFT JOIN usuario u ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    ORDER BY r.idrut ASC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar rutas: " . $e->getMessage());
            return [];
        }
    }

    public function getOne()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           TIME_FORMAT(r.horaini, '%H:%i') AS horaini_fmt,
                           TIME_FORMAT(r.horafin, '%H:%i') AS horafin_fmt,
                           r.precioini, r.direccion_rut, r.referencia_rut,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel, u.foto, u.emailu, u.teleu, u.docu
                    FROM ruta r
                    LEFT JOIN usuario u ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.idrut = :idrut";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idrut", (int) $this->getIdrut(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar la ruta: " . $e->getMessage());
            return false;
        }
    }

    public function getByUser()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           TIME_FORMAT(r.horaini, '%H:%i') AS horaini_fmt,
                           TIME_FORMAT(r.horafin, '%H:%i') AS horafin_fmt,
                           r.precioini, r.direccion_rut, r.referencia_rut,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel
                    FROM ruta r
                    LEFT JOIN usuario u ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.iduser = :iduser
                    ORDER BY r.idrut ASC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar rutas del paseador: " . $e->getMessage());
            return [];
        }
    }

    public function getActivas()
    {
        try {
            $sql = "SELECT r.idrut, r.nomrut, r.distrut, r.iduser, r.idubi, r.estarut,
                           TIME_FORMAT(r.horaini, '%H:%i') AS horaini_fmt,
                           TIME_FORMAT(r.horafin, '%H:%i') AS horafin_fmt,
                           r.precioini, r.direccion_rut, r.referencia_rut,
                           ub.nomubi, ub.depaubi,
                           u.prinom, u.priapel, u.foto
                    FROM ruta r
                    LEFT JOIN usuario u ON r.iduser = u.iduser
                    LEFT JOIN ubicacion ub ON r.idubi = ub.idubi
                    WHERE r.estarut = 1";

            $idubi = $this->getIdubi();
            if ($idubi !== null && $idubi !== '' && (int) $idubi > 0) {
                $sql .= " AND r.idubi = :idubi";
            }

            $sql .= " ORDER BY r.nomrut ASC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);

            if ($idubi !== null && $idubi !== '' && (int) $idubi > 0) {
                $result->bindValue(":idubi", (int) $idubi, PDO::PARAM_INT);
            }

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar rutas disponibles: " . $e->getMessage());
            return [];
        }
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO ruta
                        (nomrut, distrut, iduser, idubi, estarut, horaini, horafin, precioini, direccion_rut, referencia_rut)
                    VALUES
                        (:nomrut, :distrut, :iduser, :idubi, :estarut, :horaini, :horafin, :precioini, :direccion_rut, :referencia_rut)";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindValue(":nomrut", $this->getNomrut());
            $result->bindValue(":distrut", $this->getDistrut() !== null && $this->getDistrut() !== '' ? $this->getDistrut() : null);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $idubi = $this->getIdubi();
            $idubi = ($idubi !== null && $idubi !== '' && (int) $idubi > 0) ? (int) $idubi : null;
            $result->bindValue(":idubi", $idubi, $idubi !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $result->bindValue(":estarut", (int) $this->getEstarut(), PDO::PARAM_INT);
            $result->bindValue(":horaini", $this->getHoraini());
            $result->bindValue(":horafin", $this->getHorafin());
            $result->bindValue(":precioini", $this->getPrecioini());
            $result->bindValue(":direccion_rut", $this->getDireccionRut());
            $result->bindValue(":referencia_rut", $this->getReferenciaRut() !== '' ? $this->getReferenciaRut() : null, $this->getReferenciaRut() !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $result->execute();

            return (int) $conexion->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al guardar la ruta: " . $e->getMessage());
            return false;
        }
    }

    public function upd()
    {
        try {
            $sql = "UPDATE ruta SET
                        nomrut = :nomrut,
                        distrut = :distrut,
                        idubi = :idubi,
                        estarut = :estarut,
                        horaini = :horaini,
                        horafin = :horafin,
                        precioini = :precioini,
                        direccion_rut = :direccion_rut,
                        referencia_rut = :referencia_rut
                    WHERE idrut = :idrut";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindValue(":idrut", (int) $this->getIdrut(), PDO::PARAM_INT);
            $result->bindValue(":nomrut", $this->getNomrut());
            $result->bindValue(":distrut", $this->getDistrut() !== null && $this->getDistrut() !== '' ? $this->getDistrut() : null);
            $idubi = $this->getIdubi();
            $idubi = ($idubi !== null && $idubi !== '' && (int) $idubi > 0) ? (int) $idubi : null;
            $result->bindValue(":idubi", $idubi, $idubi !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $result->bindValue(":estarut", (int) $this->getEstarut(), PDO::PARAM_INT);
            $result->bindValue(":horaini", $this->getHoraini());
            $result->bindValue(":horafin", $this->getHorafin());
            $result->bindValue(":precioini", $this->getPrecioini());
            $result->bindValue(":direccion_rut", $this->getDireccionRut());
            $result->bindValue(":referencia_rut", $this->getReferenciaRut() !== '' ? $this->getReferenciaRut() : null, $this->getReferenciaRut() !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);

            return $result->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar la ruta: " . $e->getMessage());
            return false;
        }
    }

    public function del()
    {
        try {
            $sql = "DELETE FROM ruta WHERE idrut = :idrut";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idrut", (int) $this->getIdrut(), PDO::PARAM_INT);

            return $result->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar la ruta: " . $e->getMessage());
            return false;
        }
    }

    public function tienePaseos()
    {
        try {
            $sql = "SELECT COUNT(*) FROM paseo WHERE idrut = :idrut";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idrut", (int) $this->getIdrut(), PDO::PARAM_INT);
            $result->execute();

            return (int) $result->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Error al verificar paseos de la ruta: " . $e->getMessage());
            return true;
        }
    }
}
?>
