<?php

require_once __DIR__ . '/../conexion.php';

class mPqr
{
    private $idpqr;
    private $tippqr;
    private $descpqr;
    private $fechpqr;
    private $iduser;

    public function getIdpqr() { return $this->idpqr; }
    public function getTippqr() { return $this->tippqr; }
    public function getDescpqr() { return $this->descpqr; }
    public function getFechpqr() { return $this->fechpqr; }
    public function getIduser() { return $this->iduser; }

    public function setIdpqr($idpqr) { $this->idpqr = $idpqr; }
    public function setTippqr($tippqr) { $this->tippqr = $tippqr; }
    public function setDescpqr($descpqr) { $this->descpqr = $descpqr; }
    public function setFechpqr($fechpqr) { $this->fechpqr = $fechpqr; }
    public function setIduser($iduser) { $this->iduser = $iduser; }

    public function save()
    {
        try {
            $sql = "INSERT INTO pqrsf (tippqr, descpqr, fechpqr, iduser)
                    VALUES (:tippqr, :descpqr, :fechpqr, :iduser)";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);

            $result->bindValue(":tippqr",  $this->getTippqr(),  PDO::PARAM_STR);
            $result->bindValue(":descpqr", $this->getDescpqr(), PDO::PARAM_STR);
            $result->bindValue(":fechpqr", $this->getFechpqr(), PDO::PARAM_STR);
            $result->bindValue(":iduser",  (int) $this->getIduser(), PDO::PARAM_INT);

            $result->execute();

            return $conexion->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al guardar PQRSF: " . $e->getMessage());
            return false;
        }
    }

    public function getByUser($iduser)
    {
        try {
            $sql = "SELECT idpqr, tippqr, descpqr, fechpqr
                    FROM pqrsf
                    WHERE iduser = :iduser
                    ORDER BY fechpqr DESC, idpqr DESC";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar PQRSF del usuario: " . $e->getMessage());
            return [];
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT pq.idpqr, pq.tippqr, pq.descpqr, pq.fechpqr, pq.iduser,
                           u.prinom, u.priapel, u.docu, u.emailu, u.teleu,
                           COALESCE(GROUP_CONCAT(DISTINCT p.nomperf ORDER BY p.nomperf SEPARATOR ', '), '-') AS nomperf
                    FROM pqrsf pq
                    INNER JOIN usuario u ON pq.iduser = u.iduser
                    LEFT JOIN userxper ux ON u.iduser = ux.iduser
                    LEFT JOIN perfil p ON ux.idperf = p.idperf
                    GROUP BY pq.idpqr, pq.tippqr, pq.descpqr, pq.fechpqr, pq.iduser,
                             u.prinom, u.priapel, u.docu, u.emailu, u.teleu
                    ORDER BY pq.fechpqr DESC, pq.idpqr DESC";

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar todas las PQRSF: " . $e->getMessage());
            return [];
        }
    }

    public function tienePerfil($iduser, $perfiles)
    {
        $perfiles = array_values(array_unique(array_map('strval', (array) $perfiles)));
        if (empty($perfiles)) {
            return false;
        }

        try {
            $placeholders = implode(',', array_fill(0, count($perfiles), '?'));
            $sql = "SELECT 1
                    FROM userxper ux
                    INNER JOIN perfil p ON ux.idperf = p.idperf
                    WHERE ux.iduser = ? AND p.nomperf IN ($placeholders)
                    LIMIT 1";

            $params = array_merge([(int) $iduser], $perfiles);

            $modelo   = new Conexion();
            $conexion = $modelo->get_conexion();
            $result   = $conexion->prepare($sql);
            $result->execute($params);

            return (bool) $result->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar perfil PQRSF: " . $e->getMessage());
            return false;
        }
    }

    public function esAdmin($iduser)
    {
        return $this->tienePerfil($iduser, ['Admin']);
    }
}
