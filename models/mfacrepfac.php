<?php

class mfacrepfac
{
    private $fechaInicio;
    private $fechaFin;
    private $estado;
    private $iduser;

    function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    function getFechaFin()
    {
        return $this->fechaFin;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function getIduser()
    {
        return $this->iduser;
    }

    function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    public function getResumen()
    {
        try {
            $sql = "SELECT
                        COUNT(f.idfac) AS total_facturas,
                        COALESCE(SUM(f.preciolin), 0) AS total_facturado,
                        COALESCE(SUM(
                            CASE
                                WHEN f.estafac = 1 THEN f.preciolin
                                ELSE 0
                            END
                        ), 0) AS total_pagado,
                        COALESCE(SUM(
                            CASE
                                WHEN f.estafac = 0 THEN f.preciolin
                                ELSE 0
                            END
                        ), 0) AS total_pendiente
                    FROM factura f
                    WHERE 1 = 1";

            $params = [];

            if ($this->fechaInicio !== null && $this->fechaInicio !== '') {
                $sql .= " AND f.fechfac >= :fechaInicio";
                $params[':fechaInicio'] = $this->fechaInicio;
            }

            if ($this->fechaFin !== null && $this->fechaFin !== '') {
                $sql .= " AND f.fechfac <= :fechaFin";
                $params[':fechaFin'] = $this->fechaFin;
            }

            if ($this->iduser !== null && $this->iduser !== '') {
                $sql .= " AND f.iduser = :iduser";
                $params[':iduser'] = $this->iduser;
            }

            if ($this->estado !== null && $this->estado !== '') {
                if (strtolower($this->estado) === 'pagada') {
                    $sql .= " AND f.estafac = 1";
                } elseif (
                    strtolower($this->estado) === 'pendiente' ||
                    strtolower($this->estado) === 'vencida'
                ) {
                    $sql .= " AND f.estafac = 0";
                }
            }

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            foreach ($params as $param => $value) {
                $result->bindValue($param, $value);
            }

            $result->execute();

            return $result->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function getPorPeriodo()
    {
        try {
            $sql = "SELECT
                        DATE_FORMAT(f.fechfac, '%Y-%m') AS periodo,
                        COUNT(f.idfac) AS cantidad_facturas,
                        COALESCE(SUM(f.preciolin), 0) AS total_facturado,
                        COALESCE(SUM(
                            CASE
                                WHEN f.estafac = 1 THEN f.preciolin
                                ELSE 0
                            END
                        ), 0) AS total_pagado,
                        COALESCE(SUM(
                            CASE
                                WHEN f.estafac = 0 THEN f.preciolin
                                ELSE 0
                            END
                        ), 0) AS total_pendiente
                    FROM factura f
                    WHERE 1 = 1";

            $params = [];

            if ($this->fechaInicio !== null && $this->fechaInicio !== '') {
                $sql .= " AND f.fechfac >= :fechaInicio";
                $params[':fechaInicio'] = $this->fechaInicio;
            }

            if ($this->fechaFin !== null && $this->fechaFin !== '') {
                $sql .= " AND f.fechfac <= :fechaFin";
                $params[':fechaFin'] = $this->fechaFin;
            }

            if ($this->iduser !== null && $this->iduser !== '') {
                $sql .= " AND f.iduser = :iduser";
                $params[':iduser'] = $this->iduser;
            }

            if ($this->estado !== null && $this->estado !== '') {
                if (strtolower($this->estado) === 'pagada') {
                    $sql .= " AND f.estafac = 1";
                } elseif (
                    strtolower($this->estado) === 'pendiente' ||
                    strtolower($this->estado) === 'vencida'
                ) {
                    $sql .= " AND f.estafac = 0";
                }
            }

            $sql .= " GROUP BY DATE_FORMAT(f.fechfac, '%Y-%m')
                      ORDER BY periodo ASC";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            foreach ($params as $param => $value) {
                $result->bindValue($param, $value);
            }

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function getPorEstado()
    {
        try {
            $sql = "SELECT
                        CASE
                            WHEN f.estafac = 1 THEN 'Pagada'
                            ELSE 'Pendiente'
                        END AS estado,
                        COUNT(f.idfac) AS cantidad,
                        COALESCE(SUM(f.preciolin), 0) AS total
                    FROM factura f
                    WHERE 1 = 1";

            $params = [];

            if ($this->fechaInicio !== null && $this->fechaInicio !== '') {
                $sql .= " AND f.fechfac >= :fechaInicio";
                $params[':fechaInicio'] = $this->fechaInicio;
            }

            if ($this->fechaFin !== null && $this->fechaFin !== '') {
                $sql .= " AND f.fechfac <= :fechaFin";
                $params[':fechaFin'] = $this->fechaFin;
            }

            if ($this->iduser !== null && $this->iduser !== '') {
                $sql .= " AND f.iduser = :iduser";
                $params[':iduser'] = $this->iduser;
            }

            $sql .= " GROUP BY f.estafac
                      ORDER BY f.estafac DESC";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            foreach ($params as $param => $value) {
                $result->bindValue($param, $value);
            }

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }

    public function getFacturasReporte()
    {
        try {
            $sql = "SELECT
                        f.idfac,
                        f.fechfac,
                        f.preciolin,
                        f.estafac,
                        f.comenfac,
                        f.iduser,
                        CONCAT(u.prinom, ' ', u.priapel) AS cliente
                    FROM factura f
                    INNER JOIN usuario u ON f.iduser = u.iduser
                    WHERE 1 = 1";

            $params = [];

            if ($this->fechaInicio !== null && $this->fechaInicio !== '') {
                $sql .= " AND f.fechfac >= :fechaInicio";
                $params[':fechaInicio'] = $this->fechaInicio;
            }

            if ($this->fechaFin !== null && $this->fechaFin !== '') {
                $sql .= " AND f.fechfac <= :fechaFin";
                $params[':fechaFin'] = $this->fechaFin;
            }

            if ($this->iduser !== null && $this->iduser !== '') {
                $sql .= " AND f.iduser = :iduser";
                $params[':iduser'] = $this->iduser;
            }

            if ($this->estado !== null && $this->estado !== '') {
                if (strtolower($this->estado) === 'pagada') {
                    $sql .= " AND f.estafac = 1";
                } elseif (
                    strtolower($this->estado) === 'pendiente' ||
                    strtolower($this->estado) === 'vencida'
                ) {
                    $sql .= " AND f.estafac = 0";
                }
            }

            $sql .= " ORDER BY f.fechfac DESC, f.idfac DESC";

            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            foreach ($params as $param => $value) {
                $result->bindValue($param, $value);
            }

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $misfun = new misFun();
            $misfun->ManejoError($e);
        }
    }
}

?>