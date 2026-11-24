<?php
require_once 'conexion.php';

class mUsuLisUsu
{
    private $errcod = 0;
    function getErrcod(){return $this->errcod;}

    public function getAll(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu,
                           u.estusr, b.nomubi,
                           GROUP_CONCAT(DISTINCT p.nomperf ORDER BY p.nomperf SEPARATOR ', ') AS perfiles
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
            error_log("mUsuLisUsu::getAll " . $e->getMessage());
            return [];
        }
    }

    // Los paseadores rechazados (estusr = 2) no se reactivan desde aquí: pasan por Validación.
    public function updEstado($iduser, $estusr){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET estusr = :estusr WHERE iduser = :iduser AND estusr <> 2";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':estusr', (int) $estusr, PDO::PARAM_INT);
            $stmt->bindValue(':iduser', (int) $iduser, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);
            error_log("mUsuLisUsu::updEstado " . $e->getMessage());
            return false;
        }
    }

    public function del($iduser){
        try{
            $conexion = (new Conexion())->get_conexion();
            $stmt = $conexion->prepare("DELETE FROM usuario WHERE iduser = :iduser");
            $stmt->bindValue(':iduser', (int) $iduser, PDO::PARAM_INT);
            return $stmt->execute();
        }catch(PDOException $e){
            $this->errcod = (int) ($e->errorInfo[1] ?? 0);   // 1451 = tiene registros relacionados
            error_log("mUsuLisUsu::del " . $e->getMessage());
            return false;
        }
    }
}
?>
