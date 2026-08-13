<?php
require_once 'conexion.php';

class mUsuVal
{
    private $iduser;
    private $estusr;

    function getIduser(){return $this->iduser;}
    function getEstusr(){return $this->estusr;}

    function setIduser($iduser){return $this->iduser = $iduser;}
    function setEstusr($estusr){return $this->estusr = $estusr;}

    // Trae los usuarios con perfil "Paseador" que están pendientes de validar (estusr = 0)
    public function getPendientes(){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "SELECT u.iduser, u.docu, u.prinom, u.seconom, u.priapel, u.emailu, u.teleu, u.estusr,
                           GROUP_CONCAT(DISTINCT a.tipante SEPARATOR ', ') AS antecedentes
                    FROM usuario u
                    INNER JOIN userxper up ON u.iduser = up.iduser
                    INNER JOIN perfil p ON up.idperf = p.idperf
                    LEFT JOIN userxante ua ON u.iduser = ua.iduser
                    LEFT JOIN antecedente a ON ua.idante = a.idante
                    WHERE p.nomperf = 'Paseador' AND u.estusr = 0
                    GROUP BY u.iduser
                    ORDER BY u.prinom ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error al consultar paseadores pendientes: " . $e->getMessage();
            return false;
        }
    }

    // estusr: 1 = aprobado, 2 = rechazado
    public function validar($iduser, $estusr){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET estusr = :estusr WHERE iduser = :iduser";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':estusr', $estusr);
            $stmt->bindParam(':iduser', $iduser);
            return $stmt->execute();
        }catch(PDOException $e){
            echo "Error al validar paseador: " . $e->getMessage();
            return false;
        }
    }
}
?>