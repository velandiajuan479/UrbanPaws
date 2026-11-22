<?php
require_once 'conexion.php';

class mUsuVal
{
    // Paseadores pendientes de validar (estusr = 0)
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
            error_log("mUsuVal::getPendientes " . $e->getMessage());
            return [];
        }
    }

    // estusr: 1 = aprobado, 2 = rechazado. Solo cambia paseadores que sigan pendientes.
    // Devuelve true únicamente si se modificó una fila.
    public function validar($iduser, $estusr){
        try{
            $conexion = (new Conexion())->get_conexion();
            $sql = "UPDATE usuario SET estusr = :estusr
                    WHERE iduser = :iduser AND estusr = 0
                      AND iduser IN (SELECT up.iduser FROM userxper up
                                     INNER JOIN perfil p ON up.idperf = p.idperf
                                     WHERE p.nomperf = 'Paseador')";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(':estusr', (int) $estusr, PDO::PARAM_INT);
            $stmt->bindValue(':iduser', (int) $iduser, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        }catch(PDOException $e){
            error_log("mUsuVal::validar " . $e->getMessage());
            return false;
        }
    }
}
?>
