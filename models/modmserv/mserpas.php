<?php

require_once __DIR__ . '/../conexion.php';

class mServPas
{
    const MULTA_BASE = 50000;
    const ESTADOS = ['Solicitado', 'Aceptado', 'Rechazado', 'Cancelado', 'Terminado'];
    const ESTADOS_SANCION = ['Pendiente', 'Aplicada', 'Pagada', 'Anulada'];

    private $idpas;
    private $estapas;
    private $idmasc;
    private $idrut;
    private $iduser;
    private $descserv;
    private $servtipo;
    private $inicio_programado;
    private $fin_programado;
    private $idpaseador;
    private $precio_pactado;
    private $direccion_pactada;
    private $referencia_pactada;
    private $fecha_cancelacion;
    private $motivo_cancelacion;
    private $cancelado_por;
    private $cancelacion_tardia;

    public function getIdpas()               { return $this->idpas; }
    public function getEstapas()             { return $this->estapas; }
    public function getIdmasc()              { return $this->idmasc; }
    public function getIdrut()               { return $this->idrut; }
    public function getIduser()              { return $this->iduser; }
    public function getDescserv()            { return $this->descserv; }
    public function getServtipo()            { return $this->servtipo; }
    public function getInicioProgramado()    { return $this->inicio_programado; }
    public function getFinProgramado()       { return $this->fin_programado; }
    public function getIdpaseador()          { return $this->idpaseador; }
    public function getPrecioPactado()       { return $this->precio_pactado; }
    public function getDireccionPactada()    { return $this->direccion_pactada; }
    public function getReferenciaPactada()   { return $this->referencia_pactada; }
    public function getFechaCancelacion()    { return $this->fecha_cancelacion; }
    public function getMotivoCancelacion()   { return $this->motivo_cancelacion; }
    public function getCanceladoPor()        { return $this->cancelado_por; }
    public function getCancelacionTardia()   { return $this->cancelacion_tardia; }

    public function setIdpas($idpas)                         { $this->idpas = $idpas; }
    public function setEstapas($estapas)                     { $this->estapas = $estapas; }
    public function setIdmasc($idmasc)                       { $this->idmasc = $idmasc; }
    public function setIdrut($idrut)                         { $this->idrut = $idrut; }
    public function setIduser($iduser)                       { $this->iduser = $iduser; }
    public function setDescserv($descserv)                   { $this->descserv = $descserv; }
    public function setServtipo($servtipo)                   { $this->servtipo = $servtipo; }
    public function setInicioProgramado($inicio_programado)  { $this->inicio_programado = $inicio_programado; }
    public function setFinProgramado($fin_programado)        { $this->fin_programado = $fin_programado; }
    public function setIdpaseador($idpaseador)               { $this->idpaseador = $idpaseador; }
    public function setPrecioPactado($precio_pactado)        { $this->precio_pactado = $precio_pactado; }
    public function setDireccionPactada($direccion_pactada)  { $this->direccion_pactada = $direccion_pactada; }
    public function setReferenciaPactada($referencia_pactada){ $this->referencia_pactada = $referencia_pactada; }
    public function setFechaCancelacion($fecha_cancelacion)  { $this->fecha_cancelacion = $fecha_cancelacion; }
    public function setMotivoCancelacion($motivo_cancelacion){ $this->motivo_cancelacion = $motivo_cancelacion; }
    public function setCanceladoPor($cancelado_por)          { $this->cancelado_por = $cancelado_por; }
    public function setCancelacionTardia($cancelacion_tardia){ $this->cancelacion_tardia = $cancelacion_tardia; }

    private function baseSelect()
    {
        return "SELECT p.idpas, p.estapas, p.servtipo, p.idmasc, p.idrut, p.iduser,
                       p.descserv, p.inicio_programado, p.fin_programado,
                       DATE_FORMAT(p.inicio_programado, '%Y-%m-%d %H:%i') AS inicio_fmt,
                       DATE_FORMAT(p.fin_programado, '%Y-%m-%d %H:%i') AS fin_fmt,
                       p.idpaseador, COALESCE(p.idpaseador, r.iduser) AS idpaseador_real,
                       COALESCE(p.precio_pactado, r.precioini) AS precio,
                       COALESCE(p.direccion_pactada, r.direccion_rut) AS direccion,
                       COALESCE(p.referencia_pactada, r.referencia_rut) AS referencia,
                       p.fecha_cancelacion, p.motivo_cancelacion, p.cancelado_por, p.cancelacion_tardia,
                       r.nomrut, r.distrut,
                       TIME_FORMAT(r.horaini, '%H:%i') AS horaini_fmt,
                       TIME_FORMAT(r.horafin, '%H:%i') AS horafin_fmt,
                       m.nommasc,
                       u.prinom, u.priapel,
                       ps.prinom AS prinomps, ps.priapel AS priapelps
                FROM paseo p
                LEFT JOIN ruta r ON p.idrut = r.idrut
                LEFT JOIN mascotas m ON p.idmasc = m.idmasc
                LEFT JOIN usuario u ON p.iduser = u.iduser
                LEFT JOIN usuario ps ON ps.iduser = COALESCE(p.idpaseador, r.iduser)";
    }

    public function getAll()
    {
        try {
            $sql = $this->baseSelect() . " ORDER BY p.idpas DESC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar paseos: " . $e->getMessage());
            return [];
        }
    }

    public function getOne()
    {
        try {
            $sql = $this->baseSelect() . " WHERE p.idpas = :idpas";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idpas", (int) $this->getIdpas(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar el paseo: " . $e->getMessage());
            return false;
        }
    }

    public function getByCliente()
    {
        try {
            $sql = $this->baseSelect() . " WHERE p.iduser = :iduser ORDER BY p.idpas DESC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar paseos del cliente: " . $e->getMessage());
            return [];
        }
    }

    public function getByPaseador()
    {
        try {
            $sql = $this->baseSelect() . " WHERE COALESCE(p.idpaseador, r.iduser) = :iduser ORDER BY p.idpas DESC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar paseos del paseador: " . $e->getMessage());
            return [];
        }
    }

    public function getMascotasByUser()
    {
        try {
            $sql = "SELECT m.idmasc, m.nommasc, COALESCE(r.nomraz, m.razamasc) AS razamasc
                    FROM mascotas m
                    LEFT JOIN raza_mascota r ON m.idraz = r.idraz
                    WHERE m.iduser = :iduser
                    ORDER BY m.nommasc ASC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar mascotas del cliente: " . $e->getMessage());
            return [];
        }
    }

    public function mascotaPertenece($idmasc, $iduser)
    {
        try {
            $sql = "SELECT COUNT(*) FROM mascotas WHERE idmasc = :idmasc AND iduser = :iduser";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idmasc", (int) $idmasc, PDO::PARAM_INT);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->execute();

            return (int) $result->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Error al verificar la mascota: " . $e->getMessage());
            return false;
        }
    }

    public function hayCruce($idpaseador, $inicio, $fin, $excluirIdpas = 0)
    {
        try {
            $sql = "SELECT COUNT(*)
                    FROM paseo p
                    LEFT JOIN ruta r ON p.idrut = r.idrut
                    WHERE COALESCE(p.idpaseador, r.iduser) = :idpaseador
                      AND p.estapas IN ('Solicitado', 'Aceptado')
                      AND p.inicio_programado < :fin
                      AND p.fin_programado > :inicio";

            if ((int) $excluirIdpas > 0) {
                $sql .= " AND p.idpas <> :idpas";
            }

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idpaseador", (int) $idpaseador, PDO::PARAM_INT);
            $result->bindValue(":inicio", $inicio);
            $result->bindValue(":fin", $fin);

            if ((int) $excluirIdpas > 0) {
                $result->bindValue(":idpas", (int) $excluirIdpas, PDO::PARAM_INT);
            }

            $result->execute();

            return (int) $result->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Error al verificar cruce de horario: " . $e->getMessage());
            return true;
        }
    }

    public function save()
    {
        try {
            $sql = "INSERT INTO paseo
                        (estapas, servtipo, inicio_programado, fin_programado,
                         idmasc, idrut, iduser, descserv, idpaseador,
                         precio_pactado, direccion_pactada, referencia_pactada)
                    VALUES
                        (:estapas, :servtipo, :inicio, :fin,
                         :idmasc, :idrut, :iduser, :descserv, :idpaseador,
                         :precio, :direccion, :referencia)";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);

            $result->bindValue(":estapas", $this->getEstapas());
            $result->bindValue(":servtipo", $this->getServtipo());
            $result->bindValue(":inicio", $this->getInicioProgramado());
            $result->bindValue(":fin", $this->getFinProgramado());
            $result->bindValue(":idmasc", (int) $this->getIdmasc(), PDO::PARAM_INT);
            $result->bindValue(":idrut", (int) $this->getIdrut(), PDO::PARAM_INT);
            $result->bindValue(":iduser", (int) $this->getIduser(), PDO::PARAM_INT);
            $result->bindValue(":descserv", $this->getDescserv());
            $result->bindValue(":idpaseador", (int) $this->getIdpaseador(), PDO::PARAM_INT);
            $result->bindValue(":precio", $this->getPrecioPactado());
            $result->bindValue(":direccion", $this->getDireccionPactada());
            $result->bindValue(":referencia", $this->getReferenciaPactada() !== '' ? $this->getReferenciaPactada() : null, $this->getReferenciaPactada() !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $result->execute();

            return (int) $conexion->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al guardar el paseo: " . $e->getMessage());
            return false;
        }
    }

    public function updEstado()
    {
        try {
            $sql = "UPDATE paseo SET estapas = :estapas WHERE idpas = :idpas";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":idpas", (int) $this->getIdpas(), PDO::PARAM_INT);
            $result->bindValue(":estapas", $this->getEstapas());

            return $result->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar el estado del paseo: " . $e->getMessage());
            return false;
        }
    }

    public function cancelar($idpas, $canceladoPor, $motivo, $aplicarAdvertencia)
    {
        $conexion = null;

        try {
            $conexion = (new Conexion())->get_conexion();
            $conexion->beginTransaction();

            $sqlPaseo = "SELECT idpas, iduser, inicio_programado, estapas
                         FROM paseo
                         WHERE idpas = :idpas
                           AND estapas IN ('Solicitado', 'Aceptado')
                         FOR UPDATE";
            $stmtPaseo = $conexion->prepare($sqlPaseo);
            $stmtPaseo->bindValue(":idpas", (int) $idpas, PDO::PARAM_INT);
            $stmtPaseo->execute();
            $paseo = $stmtPaseo->fetch(PDO::FETCH_ASSOC);

            if (!$paseo) {
                $conexion->rollBack();
                return false;
            }

            $faltanHoras = ($paseo['inicio_programado'] ? (strtotime($paseo['inicio_programado']) - time()) / 3600 : 0);
            $esTardia = $faltanHoras < 12;

            $sqlUpd = "UPDATE paseo SET
                           estapas = 'Cancelado',
                           fecha_cancelacion = NOW(),
                           motivo_cancelacion = :motivo,
                           cancelado_por = :cancelado_por,
                           cancelacion_tardia = :tardia
                       WHERE idpas = :idpas";
            $stmtUpd = $conexion->prepare($sqlUpd);
            $stmtUpd->bindValue(":motivo", $motivo);
            $stmtUpd->bindValue(":cancelado_por", (int) $canceladoPor, PDO::PARAM_INT);
            $stmtUpd->bindValue(":tardia", $esTardia ? 1 : 0, PDO::PARAM_INT);
            $stmtUpd->bindValue(":idpas", (int) $idpas, PDO::PARAM_INT);
            $stmtUpd->execute();

            $nuevoAdv = null;
            $sancion = null;

            if ($esTardia && $aplicarAdvertencia) {
                $stmtUser = $conexion->prepare("SELECT advusr, sancionusr FROM usuario WHERE iduser = :iduser FOR UPDATE");
                $stmtUser->bindValue(":iduser", (int) $paseo['iduser'], PDO::PARAM_INT);
                $stmtUser->execute();
                $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    $nuevoAdv = (int) $usuario['advusr'] + 1;
                    $sancionActual = $usuario['sancionusr'];
                    $stmtAdv = $conexion->prepare("UPDATE usuario SET advusr = :advusr WHERE iduser = :iduser");
                    $stmtAdv->bindValue(":advusr", $nuevoAdv, PDO::PARAM_INT);
                    $stmtAdv->bindValue(":iduser", (int) $paseo['iduser'], PDO::PARAM_INT);
                    $stmtAdv->execute();

                    $crearSancion = $nuevoAdv >= 3
                        && ($sancionActual === null || $sancionActual === '' || in_array($sancionActual, ['Pagada', 'Anulada'], true));

                    if ($crearSancion) {
                        $sancion = 'Pendiente';
                        $sqlSancion = "UPDATE usuario SET
                                           sancionusr = 'Pendiente',
                                           multausr = :multa,
                                           fecsancion = NOW(),
                                           obssancion = :observacion
                                       WHERE iduser = :iduser";
                        $stmtSancion = $conexion->prepare($sqlSancion);
                        $stmtSancion->bindValue(":multa", self::MULTA_BASE);
                        $stmtSancion->bindValue(":observacion", "Multa automática por 3 cancelaciones tardías");
                        $stmtSancion->bindValue(":iduser", (int) $paseo['iduser'], PDO::PARAM_INT);
                        $stmtSancion->execute();
                    }
                }
            }

            $conexion->commit();

            return [
                'ok' => true,
                'tardia' => $esTardia,
                'advusr' => $nuevoAdv,
                'sancion' => $sancion,
            ];
        } catch (Exception $e) {
            if ($conexion instanceof PDO && $conexion->inTransaction()) {
                $conexion->rollBack();
            }
            error_log("Error al cancelar el paseo: " . $e->getMessage());
            return false;
        }
    }

    public function getSanciones()
    {
        try {
            $sql = "SELECT u.iduser, u.prinom, u.priapel, u.emailu,
                           u.advusr, u.multausr, u.vetousr, u.sancionusr,
                           u.fecsancion, u.obssancion,
                           (SELECT COUNT(*) FROM paseo p
                            WHERE p.iduser = u.iduser AND p.cancelacion_tardia = 1) AS cancelaciones_tardias
                    FROM usuario u
                    WHERE u.advusr > 0 OR u.sancionusr IS NOT NULL OR u.vetousr = 1
                    ORDER BY u.fecsancion DESC, u.advusr DESC, u.iduser ASC";

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar sanciones: " . $e->getMessage());
            return [];
        }
    }

    public function actualizarSancion($iduser, $estado, $multa, $veto)
    {
        try {
            $estado = $estado !== null && $estado !== '' ? $estado : null;

            if ($estado !== null && !in_array($estado, self::ESTADOS_SANCION, true)) {
                return false;
            }

            $multa = max(0, (float) $multa);
            $veto = (int) $veto === 1 ? 1 : 0;

            if ($estado === null) {
                $sql = "UPDATE usuario SET
                            advusr = 0,
                            multausr = 0,
                            vetousr = 0,
                            sancionusr = NULL,
                            fecsancion = NULL,
                            obssancion = NULL
                        WHERE iduser = :iduser";
            } elseif ($estado === 'Anulada') {
                $sql = "UPDATE usuario SET
                            advusr = 0,
                            multausr = 0,
                            vetousr = 0,
                            sancionusr = 'Anulada',
                            fecsancion = NOW()
                        WHERE iduser = :iduser";
            } elseif ($estado === 'Pagada') {
                $sql = "UPDATE usuario SET
                            advusr = 0,
                            multausr = :multa,
                            vetousr = :veto,
                            sancionusr = 'Pagada',
                            fecsancion = NOW()
                        WHERE iduser = :iduser";
            } else {
                $sql = "UPDATE usuario SET
                            multausr = :multa,
                            vetousr = :veto,
                            sancionusr = :estado,
                            fecsancion = NOW()
                        WHERE iduser = :iduser";
            }

            $conexion = (new Conexion())->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);

            if ($estado !== null && $estado !== 'Anulada') {
                $result->bindValue(":multa", $multa);
                $result->bindValue(":veto", $veto, PDO::PARAM_INT);
            }

            if ($estado !== null && $estado !== 'Pagada' && $estado !== 'Anulada') {
                $result->bindValue(":estado", $estado);
            }

            return $result->execute();
        } catch (Exception $e) {
            error_log("Error al actualizar la sanción: " . $e->getMessage());
            return false;
        }
    }
}
?>
