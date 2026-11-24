<?php
/**
 * Datos del panel del paseador.
 * Solo usa columnas existentes en el esquema activo (db/urbanpaws.sql).
 */
if (!function_exists('ManejoErrorPas')) {
    function ManejoErrorPas($e)
    {
        error_log('UrbanPaws Paseador Error: ' . $e->getMessage());
    }
}

class mUsuPas
{
    private $iduser;
    private $error;

    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = (int) $iduser;
    }

    public function getError()
    {
        return $this->error;
    }

    private function setError($mensaje)
    {
        $this->error = $mensaje;
    }

    private function conexion()
    {
        require_once __DIR__ . '/conexion.php';
        $modelo = new Conexion();
        return $modelo->get_conexion();
    }

    public function getResumen()
    {
        $resumen = array(
            'rutas' => 0,
            'total' => 0,
            'pendientes' => 0,
            'aceptados' => 0,
            'terminados' => 0,
            'proximos' => 0,
            'calificaciones' => 0,
            'promedio' => NULL,
        );

        try {
            $conexion = $this->conexion();

            $sqlRutas = "SELECT COUNT(*) AS total FROM ruta WHERE iduser = :iduser";
            $result = $conexion->prepare($sqlRutas);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->execute();
            $resumen['rutas'] = (int) $result->fetchColumn();

            $sqlPaseos = "SELECT COUNT(*) AS total,
                                 SUM(CASE WHEN UPPER(COALESCE(p.estapas, '')) IN ('SOLICITADO', 'PENDIENTE') THEN 1 ELSE 0 END) AS pendientes,
                                 SUM(CASE WHEN UPPER(COALESCE(p.estapas, '')) IN ('ACEPTADO', 'APROBADO') THEN 1 ELSE 0 END) AS aceptados,
                                 SUM(CASE WHEN UPPER(COALESCE(p.estapas, '')) IN ('TERMINADO', 'FINALIZADO', 'COMPLETADO') THEN 1 ELSE 0 END) AS terminados,
                                 SUM(CASE WHEN p.inicio_programado IS NOT NULL
                                               AND p.inicio_programado >= NOW()
                                               AND UPPER(COALESCE(p.estapas, '')) IN ('ACEPTADO', 'APROBADO')
                                          THEN 1 ELSE 0 END) AS proximos
                          FROM paseo p
                          INNER JOIN ruta r ON p.idrut = r.idrut
                          WHERE r.iduser = :iduser";
            $result = $conexion->prepare($sqlPaseos);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->execute();
            $fila = $result->fetch(PDO::FETCH_ASSOC);
            if ($fila) {
                $resumen['total'] = (int) $fila['total'];
                $resumen['pendientes'] = (int) $fila['pendientes'];
                $resumen['aceptados'] = (int) $fila['aceptados'];
                $resumen['terminados'] = (int) $fila['terminados'];
                $resumen['proximos'] = (int) $fila['proximos'];
            }

            $sqlCal = "SELECT COUNT(*) AS total, ROUND(AVG(puntuacion), 1) AS promedio
                       FROM calificacion
                       WHERE idpaseador = :iduser";
            $result = $conexion->prepare($sqlCal);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->execute();
            $fila = $result->fetch(PDO::FETCH_ASSOC);
            if ($fila) {
                $resumen['calificaciones'] = (int) $fila['total'];
                $resumen['promedio'] = $fila['promedio'] !== NULL ? (string) $fila['promedio'] : NULL;
            }

            return $resumen;
        } catch (Exception $e) {
            ManejoErrorPas($e);
            $this->setError('No fue posible cargar el resumen de tu panel.');
            return $resumen;
        }
    }

    public function getSolicitudes($limite = 6)
    {
        $limite = max(1, min(50, (int) $limite));
        $sql = "SELECT p.idpas, p.estapas, p.servtipo, p.inicio_programado, p.fin_programado,
                       p.descserv, r.nomrut, m.nommasc,
                       u.prinom, u.priapel
                FROM paseo p
                INNER JOIN ruta r      ON p.idrut = r.idrut
                LEFT JOIN mascotas m   ON p.idmasc = m.idmasc
                LEFT JOIN usuario u    ON p.iduser = u.iduser
                WHERE r.iduser = :iduser
                ORDER BY CASE WHEN UPPER(COALESCE(p.estapas, '')) IN ('SOLICITADO', 'PENDIENTE') THEN 0 ELSE 1 END,
                         p.inicio_programado IS NULL,
                         p.inicio_programado ASC,
                         p.idpas DESC
                LIMIT :limite";
        try {
            $result = $this->conexion()->prepare($sql);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->bindValue(':limite', $limite, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            ManejoErrorPas($e);
            $this->setError('No fue posible cargar tus solicitudes.');
            return array();
        }
    }

    public function getRutas($limite = 6)
    {
        $limite = max(1, min(50, (int) $limite));
        $sql = "SELECT r.idrut, r.nomrut, r.distrut,
                       (SELECT COUNT(*) FROM paseo p WHERE p.idrut = r.idrut) AS total_paseos,
                       (SELECT COUNT(*) FROM paseo p
                         WHERE p.idrut = r.idrut
                           AND UPPER(COALESCE(p.estapas, '')) IN ('SOLICITADO', 'PENDIENTE')) AS pendientes
                FROM ruta r
                WHERE r.iduser = :iduser
                ORDER BY r.nomrut ASC
                LIMIT :limite";
        try {
            $result = $this->conexion()->prepare($sql);
            $result->bindParam(':iduser', $this->iduser, PDO::PARAM_INT);
            $result->bindValue(':limite', $limite, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            ManejoErrorPas($e);
            $this->setError('No fue posible cargar tus rutas.');
            return array();
        }
    }
}
?>
