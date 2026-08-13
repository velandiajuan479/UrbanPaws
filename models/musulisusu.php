<?php
require_once 'conexion.php';

class mUsuLisUsu
{
    private $iduser;
    private $estusr;

    function getIduser(){return $this->iduser;}
    function getEstusr(){return $this->estusr;}

    function setIduser($iduser){return $this->iduser = $iduser;}
    function setEstusr($estusr){return $this->estusr = $estusr;}

    public function getAll(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu,
                           u.estusr, b.nomubi,
                           GROUP_CONCAT(p.nomperf SEPARATOR ', ') AS perfiles
                    FROM usuario u
                    LEFT JOIN ubicacion b ON u.idubi = b.idubi
                    LEFT JOIN userxper up ON u.iduser = up.iduser
                    LEFT JOIN perfil p ON up.idperf = p.idperf
                    GROUP BY u.iduser
                    ORDER BY u.prinom ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error al consultar usuarios: " . $e->getMessage();
            return false;
        }
    }

    public function updEstado($iduser, $estusr){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET estusr = :estusr WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':estusr', $estusr);
            $stmt->bindParam(':iduser', $iduser);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al actualizar estado del usuario: " . $e->getMessage();
            return false;
        }
    }

    public function del($iduser){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "DELETE FROM usuario WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':iduser', $iduser);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false;
        }
    }
}
?>