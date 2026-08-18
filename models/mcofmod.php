<?php 
class mCofmod
{
    private $idmod;
    private $nommod;
    private $icomod;
    private $estamod;
    private $ordmod;
    private $idperf;

    // Métodos Get
    function getIdmod(){ return $this->idmod; }
    function getNommod(){ return $this->nommod; }
    function getIcomod(){ return $this->icomod; }
    function getEstamod(){ return $this->estamod; }
    function getOrdmod(){ return $this->ordmod; }
    function getIdperf(){ return $this->idperf; }

    // Métodos Set
    function setIdmod($idmod){ return $this->idmod = $idmod; }
    function setNommod($nommod){ return $this->nommod = $nommod; }
    function setIcomod($icomod){ return $this->icomod = $icomod; }
    function setEstamod($estamod){ return $this->estamod = $estamod; }
    function setOrdmod($ordmod){ return $this->ordmod = $ordmod; }
    function setIdperf($idperf){ return $this->idperf = $idperf; }

    // Método getAll (JOIN con valor = estado, JOIN con perfil = acceso)
    public function getAll(){
        try{
            $sql = "SELECT m.idmod, m.nommod, m.icomod, m.estamod, m.ordmod, m.idperf,
                            v.codval AS nomesta, p.nomperf
                    FROM modulo m
                    LEFT JOIN valor v ON m.estamod = v.idval
                    LEFT JOIN perfil p ON m.idperf = p.idperf
                    ORDER BY m.ordmod ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 1: " . $e->getMessage();
        }
    }

    // Método getOne (mismos JOIN para el formulario de edición)
    public function getOne(){
        try{
            $sql = "SELECT m.idmod, m.nommod, m.icomod, m.estamod, m.ordmod, m.idperf,
                            v.codval AS nomesta, p.nomperf
                    FROM modulo m
                    LEFT JOIN valor v ON m.estamod = v.idval
                    LEFT JOIN perfil p ON m.idperf = p.idperf
                    WHERE m.idmod = :idmod";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmod = $this->getIdmod();
            $result->bindParam(":idmod", $idmod);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    // Método save
    public function save(){
        try{
            $sql = "INSERT INTO modulo(nommod, icomod, estamod, ordmod, idperf)
                    VALUES(:nommod, :icomod, :estamod, :ordmod, :idperf)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $nommod  = $this->getNommod();
            $icomod  = $this->getIcomod();
            $estamod = $this->getEstamod();
            $ordmod  = $this->getOrdmod();
            $idperf  = $this->getIdperf();

            $result->bindParam(":nommod",  $nommod);
            $result->bindParam(":icomod",  $icomod);
            $result->bindParam(":estamod", $estamod);
            $result->bindParam(":ordmod",  $ordmod);
            $result->bindParam(":idperf",  $idperf);
            $result->execute();
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Método upd
    public function upd(){
        try{
            $sql = "UPDATE modulo SET
                        nommod  = :nommod,
                        icomod  = :icomod,
                        estamod = :estamod,
                        ordmod  = :ordmod,
                        idperf  = :idperf
                    WHERE idmod = :idmod";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idmod   = $this->getIdmod();
            $nommod  = $this->getNommod();
            $icomod  = $this->getIcomod();
            $estamod = $this->getEstamod();
            $ordmod  = $this->getOrdmod();
            $idperf  = $this->getIdperf();

            $result->bindParam(":idmod",   $idmod);
            $result->bindParam(":nommod",  $nommod);
            $result->bindParam(":icomod",  $icomod);
            $result->bindParam(":estamod", $estamod);
            $result->bindParam(":ordmod",  $ordmod);
            $result->bindParam(":idperf",  $idperf);
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Método del
    public function del(){
        try{
            $sql = "DELETE FROM modulo WHERE idmod = :idmod";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmod = $this->getIdmod();
            $result->bindParam(":idmod", $idmod);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }

    // Método getPerfiles: llena el select "Usuarios con acceso"
    public function getPerfiles(){
        try{
            $sql = "SELECT idperf, nomperf FROM perfil ORDER BY idperf ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 6: " . $e->getMessage();
        }
    }
}
?>
