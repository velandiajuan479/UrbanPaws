<?php
class mCofraz
{
    public function getAll()
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->query("SELECT r.idraz, r.nomraz, r.actraz, v.codval AS estado
                                         FROM raza_mascota r
                                         LEFT JOIN valor v ON v.iddom = 1 AND v.idval = CASE WHEN r.actraz = 1 THEN 1 ELSE 2 END
                                         ORDER BY r.nomraz ASC");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('mCofraz::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public function save($nomraz, $actraz)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->prepare("INSERT INTO raza_mascota (nomraz, actraz) VALUES (:nomraz, :actraz)");
            return $result->execute([':nomraz' => $nomraz, ':actraz' => $actraz]);
        } catch (PDOException $e) {
            error_log('mCofraz::save - ' . $e->getMessage());
            return false;
        }
    }

    public function getOne($idraz)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->prepare("SELECT idraz, nomraz, actraz FROM raza_mascota WHERE idraz = :idraz");
            $result->execute([':idraz' => (int) $idraz]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('mCofraz::getOne - ' . $e->getMessage());
            return false;
        }
    }

    public function update($idraz, $nomraz, $actraz)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->prepare("UPDATE raza_mascota SET nomraz = :nomraz, actraz = :actraz WHERE idraz = :idraz");
            return $result->execute([':idraz' => (int) $idraz, ':nomraz' => $nomraz, ':actraz' => $actraz]);
        } catch (PDOException $e) {
            error_log('mCofraz::update - ' . $e->getMessage());
            return false;
        }
    }

    public function toggle($idraz)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->prepare("UPDATE raza_mascota SET actraz = CASE WHEN actraz = 1 THEN 0 ELSE 1 END WHERE idraz = :idraz");
            $result->execute([':idraz' => (int) $idraz]);
            return $result->rowCount() > 0;
        } catch (Exception $e) {
            error_log('mCofraz::toggle - ' . $e->getMessage());
            return false;
        }
    }

    public function delete($idraz)
    {
        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $conexion->prepare("DELETE FROM raza_mascota WHERE idraz = :idraz");
            $result->execute([':idraz' => (int) $idraz]);
            return $result->rowCount() > 0;
        } catch (Exception $e) {
            error_log('mCofraz::delete - ' . $e->getMessage());
            return false;
        }
    }
}
?>
