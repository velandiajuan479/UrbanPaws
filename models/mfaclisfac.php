<?php

class mfaclisfac
{
    private $idfac;
    private $iduser;
    private $cliente;
    private $estado;
    private $fechaInicio;
    private $fechaFin;
    private $montoMin;
    private $montoMax;

    function getIdfac()
    {
        return $this->idfac;
    }

    function getIduser()
    {
        return $this->iduser;
    }

    function getCliente()
    {
        return $this->cliente;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    function getFechaFin()
    {
        return $this->fechaFin;
    }

    function getMontoMin()
    {
        return $this->montoMin;
    }

    function getMontoMax()
    {
        return $this->montoMax;
    }

    function setIdfac($idfac)
    {
        $this->idfac = $idfac;
    }

    function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    function setMontoMin($montoMin)
    {
        $this->montoMin = $montoMin;
    }

    function setMontoMax($montoMax)
    {
        $this->montoMax = $montoMax;
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
                        CONCAT(u.prinom, ' ', u.priapel) AS cliente,
                        CONCAT(
                            CASE
                                WHEN f.estafac = 1 THEN 'Pagada'
                                ELSE 'Pendiente'
                            END
                        ) AS estado
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

    public function getFiltered()
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
                        CONCAT(u.prinom, ' ', u.priapel) AS cliente,
                        CASE
                            WHEN f.estafac = 1 THEN 'Pagada'
                            ELSE 'Pendiente'
                        END AS estado
                    FROM factura f
                    INNER JOIN usuario u ON f.iduser = u.iduser
                    WHERE 1 = 1";

            $params = [];

            if ($this->cliente !== null && $this->cliente !== '') {
                $sql .= " AND CONCAT(u.prinom, ' ', u.priapel) LIKE :cliente";
                $params[':cliente'] = '%' . $this->cliente . '%';
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

            if ($this->fechaInicio !== null && $this->fechaInicio !== '') {
                $sql .= " AND f.fechfac >= :fechaInicio";
                $params[':fechaInicio'] = $this->fechaInicio;
            }

            if ($this->fechaFin !== null && $this->fechaFin !== '') {
                $sql .= " AND f.fechfac <= :fechaFin";
                $params[':fechaFin'] = $this->fechaFin;
            }

            if ($this->montoMin !== null && $this->montoMin !== '') {
                $sql .= " AND f.preciolin >= :montoMin";
                $params[':montoMin'] = $this->montoMin;
            }

            if ($this->montoMax !== null && $this->montoMax !== '') {
                $sql .= " AND f.preciolin <= :montoMax";
                $params[':montoMax'] = $this->montoMax;
            }

            $sql .= " ORDER BY f.idfac DESC";

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
}

?>