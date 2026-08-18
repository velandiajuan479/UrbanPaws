<?php
class mCofdue
{
    private $iddueno;
    private $iduser;
    private $idmasc;

    // Métodos Get
    function getIddueno(){ return $this->iddueno; }
    function getIduser(){ return $this->iduser; }
    function getIdmasc(){ return $this->idmasc; }

    // Métodos Set
    function setIddueno($iddueno){ return $this->iddueno = $iddueno; }
    function setIduser($iduser){ return $this->iduser = $iduser; }
    function setIdmasc($idmasc){ return $this->idmasc = $idmasc; }

    // Método getAll (JOIN con usuario y mascota)
    public function getAll(){
        try{
            $sql = "SELECT d.iddueno, d.iduser, d.idmasc,
                           CONCAT(u.prinom, ' ', u.priapel) AS nomdueno, u.docu,
                           m.nommasc, m.razamasc
                    FROM duenomasc d
                    LEFT JOIN usuario u ON d.iduser = u.iduser
                    LEFT JOIN mascotas m ON d.idmasc = m.idmasc
                    ORDER BY d.iddueno ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 1: " . $e->getMessage();
        }
    }

    // Método getOne
    public function getOne(){
        try{
            $sql = "SELECT d.iddueno, d.iduser, d.idmasc,
                           CONCAT(u.prinom, ' ', u.priapel) AS nomdueno, u.docu,
                           m.nommasc, m.razamasc
                    FROM duenomasc d
                    LEFT JOIN usuario u ON d.iduser = u.iduser
                    LEFT JOIN mascotas m ON d.idmasc = m.idmasc
                    WHERE d.iddueno = :iddueno";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iddueno = $this->getIddueno();
            $result->bindParam(":iddueno", $iddueno);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    // Método existe: evita registrar dos veces la misma relación dueño-mascota
    public function existe(){
        try{
            $sql = "SELECT iddueno FROM duenomasc WHERE iduser = :iduser AND idmasc = :idmasc";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $idmasc = $this->getIdmasc();
            $result->bindParam(":iduser", $iduser);
            $result->bindParam(":idmasc", $idmasc);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Método save
    public function save(){
        try{
            $sql = "INSERT INTO duenomasc(iduser, idmasc) VALUES(:iduser, :idmasc)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iduser = $this->getIduser();
            $idmasc = $this->getIdmasc();
            $result->bindParam(":iduser", $iduser);
            $result->bindParam(":idmasc", $idmasc);
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Método upd
    public function upd(){
        try{
            $sql = "UPDATE duenomasc SET iduser = :iduser, idmasc = :idmasc
                    WHERE iddueno = :iddueno";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iddueno = $this->getIddueno();
            $iduser  = $this->getIduser();
            $idmasc  = $this->getIdmasc();
            $result->bindParam(":iddueno", $iddueno);
            $result->bindParam(":iduser",  $iduser);
            $result->bindParam(":idmasc",  $idmasc);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }

    // Método del
    public function del(){
        try{
            $sql = "DELETE FROM duenomasc WHERE iddueno = :iddueno";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $iddueno = $this->getIddueno();
            $result->bindParam(":iddueno", $iddueno);
            $result->execute();
        }catch(Exception $e){
            echo "Error 6: " . $e->getMessage();
        }
    }

    // Método delByMasc: borra la relación al eliminar la mascota (evita error de FK)
    public function delByMasc(){
        try{
            $sql = "DELETE FROM duenomasc WHERE idmasc = :idmasc";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmasc = $this->getIdmasc();
            $result->bindParam(":idmasc", $idmasc);
            $result->execute();
        }catch(Exception $e){
            echo "Error 7: " . $e->getMessage();
        }
    }
}
?>