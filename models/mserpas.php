<?php

require_once 'conexion.php';

class mServPas
{
    private $idpas;
    private $estapas;
    private $idmasc;
    private $idrut;
    private $iduser;
    private $descserv;
    private $servtipo;

    /* ========================= GETTERS ========================= */
    public function getIdpas()    { return $this->idpas; }
    public function getEstapas()  { return $this->estapas; }
    public function getIdmasc()   { return $this->idmasc; }
    public function getIdrut()    { return $this->idrut; }
    public function getIduser()   { return $this->iduser; }
    public function getDescserv() { return $this->descserv; }
    public function getServtipo() { return $this->servtipo; }

    /* ========================= SETTERS ========================= */
    public function setIdpas($idpas)      { $this->idpas = $idpas; }
    public function setEstapas($estapas)  { $this->estapas = $estapas; }
    public function setIdmasc($idmasc)    { $this->idmasc = $idmasc; }
    public function setIdrut($idrut)      { $this->idrut = $idrut; }
    public function setIduser($iduser)    { $this->iduser = $iduser; }
    public function setDescserv($descserv){ $this->descserv = $descserv; }
    public function setServtipo($servtipo){ $this->servtipo = $servtipo; }

    /* ========================= TODOS LOS PASEOS ========================= */
    public function getAll()
    {
        try {
            $sql = "SELECT p.idpas, p.estapas, p.idmasc, p.idrut, p.iduser,
                           p.descserv, p.servtipo,
                           r.nomrut, r.precioini, r.horaini, r.horafin,
                           m.nommasc,
                           u.prinom, u.priapel,
                           ps.prinom AS prinomps, ps.priapel AS priapelps
                    FROM paseo p
                    LEFT JOIN ruta r      ON p.idrut  = r.idrut
                    LEFT JOIN mascotas m  ON p.idmasc = m.idmasc
                    LEFT JOIN usuario u   ON p.iduser = u.iduser
                    LEFT JOIN usuario ps  ON r.iduser = ps.iduser
                    ORDER BY p.idpas DESC";

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

    /* ========================= UN PASE0 ========================= */
    public function getOne()
    {
        try {
            $sql = "SELECT p.idpas, p.estapas, p.idmasc, p.idrut, p.iduser,
                           p.descserv, p.servtipo,
                           r.nomrut, r.precioini, r.horaini, r.horafin,
                           m.nommasc,
                           u.prinom, u.priapel,
                           ps.prinom AS prinomps, ps.priapel AS priapelps
                    FROM paseo p
                    LEFT JOIN ruta r      ON p.idrut  = r.idrut
                    LEFT JOIN mascotas m  ON p.idmasc = m.idmasc
                    LEFT JOIN usuario u   ON p.iduser = u.iduser
                    LEFT JOIN usuario ps  ON r.iduser = ps.iduser
                    WHERE p.idpas = :idpas";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idpas = $this->getIdpas();
            $result->bindParam(":idpas", $idpas);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= PASEOS DE UN CLIENTE ========================= */
    public function getByCliente()
    {
        try {
            $sql = "SELECT p.idpas, p.estapas, p.idmasc, p.idrut, p.iduser,
                           p.descserv, p.servtipo,
                           r.nomrut, r.precioini, r.horaini, r.horafin, r.distrut,
                           m.nommasc,
                           ps.prinom, ps.priapel
                    FROM paseo p
                    LEFT JOIN ruta r      ON p.idrut  = r.idrut
                    LEFT JOIN mascotas m  ON p.idmasc = m.idmasc
                    LEFT JOIN usuario ps  ON r.iduser = ps.iduser
                    WHERE p.iduser = :iduser
                    ORDER BY p.idpas DESC";

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

    /* ========================= PASEOS DE LAS RUTAS DE UN PASEADOR ========================= */
    public function getByPaseador()
    {
        try {
            $sql = "SELECT p.idpas, p.estapas, p.idmasc, p.idrut, p.iduser,
                           p.descserv, p.servtipo,
                           r.nomrut, r.precioini, r.horaini, r.horafin, r.distrut,
                           m.nommasc,
                           u.prinom, u.priapel
                    FROM paseo p
                    INNER JOIN ruta r     ON p.idrut  = r.idrut
                    LEFT JOIN mascotas m  ON p.idmasc = m.idmasc
                    LEFT JOIN usuario u   ON p.iduser = u.iduser
                    WHERE r.iduser = :iduser
                    ORDER BY p.idpas DESC";

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

    /* ========================= MASCOTAS DE UN CLIENTE (para el select del form) ========================= */
    public function getMascotasByUser()
    {
        try {
            $sql = "SELECT idmasc, nommasc, razamasc
                    FROM mascotas
                    WHERE iduser = :iduser
                    ORDER BY nommasc ASC";

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

    /* ========================= GUARDAR NUEVO PASE0 (solicitud) ========================= */
    public function save()
    {
        try {
            $sql = "INSERT INTO paseo (estapas, idmasc, idrut, iduser, descserv, servtipo)
                    VALUES (:estapas, :idmasc, :idrut, :iduser, :descserv, :servtipo)";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $estapas  = $this->getEstapas();
            $idmasc   = $this->getIdmasc();
            $idrut    = $this->getIdrut();
            $iduser   = $this->getIduser();
            $descserv = $this->getDescserv();
            $servtipo = $this->getServtipo();

            $result->bindParam(":estapas",  $estapas);
            $result->bindParam(":idmasc",   $idmasc);
            $result->bindParam(":idrut",    $idrut);
            $result->bindParam(":iduser",   $iduser);
            $result->bindParam(":descserv", $descserv);
            $result->bindParam(":servtipo", $servtipo);

            $result->execute();

            return $conexion->lastInsertId();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= ACTUALIZAR PASE0 (estado, descripcion, etc.) ========================= */
    public function upd()
    {
        try {
            $sql = "UPDATE paseo SET
                        estapas  = :estapas,
                        idmasc   = :idmasc,
                        idrut    = :idrut,
                        iduser   = :iduser,
                        descserv = :descserv,
                        servtipo = :servtipo
                    WHERE idpas = :idpas";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idpas    = $this->getIdpas();
            $estapas  = $this->getEstapas();
            $idmasc   = $this->getIdmasc();
            $idrut    = $this->getIdrut();
            $iduser   = $this->getIduser();
            $descserv = $this->getDescserv();
            $servtipo = $this->getServtipo();

            $result->bindParam(":idpas",    $idpas);
            $result->bindParam(":estapas",  $estapas);
            $result->bindParam(":idmasc",   $idmasc);
            $result->bindParam(":idrut",    $idrut);
            $result->bindParam(":iduser",   $iduser);
            $result->bindParam(":descserv", $descserv);
            $result->bindParam(":servtipo", $servtipo);

            return $result->execute();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= ACTUALIZAR SOLO EL ESTADO (aceptar/rechazar) ========================= */
    public function updEstado()
    {
        try {
            $sql = "UPDATE paseo SET estapas = :estapas WHERE idpas = :idpas";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idpas   = $this->getIdpas();
            $estapas = $this->getEstapas();

            $result->bindParam(":idpas",   $idpas);
            $result->bindParam(":estapas", $estapas);

            return $result->execute();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }

    /* ========================= ELIMINAR PASE0 ========================= */
    public function del()
    {
        try {
            $sql = "DELETE FROM paseo WHERE idpas = :idpas";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $idpas = $this->getIdpas();
            $result->bindParam(":idpas", $idpas);

            return $result->execute();
        } catch (Exception $e) {
            echo "Error del sistema: " . $e->getMessage();
            return false;
        }
    }
}
?>