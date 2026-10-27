<?php
require_once(__DIR__ . "/mmasarchivo.php");

class mCofmas
{
    private $idmasc;
    private $nommasc;
    private $sexmasc;
    private $fotovacu;
    private $fotomasc;
    private $razamasc;
    private $sizemasc;
    private $descmasc;
    private $enfermasc;
    private $iduser;

    // Métodos Get
    function getIdmasc(){ return $this->idmasc; }
    function getNommasc(){ return $this->nommasc; }
    function getSexmasc(){ return $this->sexmasc; }
    function getFotovacu(){ return $this->fotovacu; }
    function getFotomasc(){ return $this->fotomasc; }
    function getRazamasc(){ return $this->razamasc; }
    function getSizemasc(){ return $this->sizemasc; }
    function getDescmasc(){ return $this->descmasc; }
    function getEnfermasc(){ return $this->enfermasc; }
    function getIduser(){ return $this->iduser; }

    // Métodos Set
    function setIdmasc($idmasc){ return $this->idmasc = $idmasc; }
    function setNommasc($nommasc){ return $this->nommasc = $nommasc; }
    function setSexmasc($sexmasc){ return $this->sexmasc = $sexmasc; }
    function setFotovacu($fotovacu){ return $this->fotovacu = $fotovacu; }
    function setFotomasc($fotomasc){ return $this->fotomasc = $fotomasc; }
    function setRazamasc($razamasc){ return $this->razamasc = $razamasc; }
    function setSizemasc($sizemasc){ return $this->sizemasc = $sizemasc; }
    function setDescmasc($descmasc){ return $this->descmasc = $descmasc; }
    function setEnfermasc($enfermasc){ return $this->enfermasc = $enfermasc; }
    function setIduser($iduser){ return $this->iduser = $iduser; }

    // Método getAll (JOIN con usuario para mostrar el dueño)
    public function getAll(){
        try{
            $sql = "SELECT m.idmasc, m.nommasc, m.sexmasc, m.fotovacu, m.fotomasc,
                            m.razamasc, m.sizemasc, m.descmasc, m.enfermasc, m.iduser, m.actmasc,
                            v.codval AS estado,
                            CONCAT(u.prinom, ' ', u.priapel) AS nomdueno
                    FROM mascotas m
                    LEFT JOIN valor v ON m.actmasc = v.idval AND v.iddom = 1
                    LEFT JOIN usuario u ON m.iduser = u.iduser
                    ORDER BY m.idmasc ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 1: " . $e->getMessage();
        }
    }

    // Método getAllByUser: solo las mascotas asociadas al usuario autenticado
    public function getAllByUser($iduser){
        try{
            $sql = "SELECT m.idmasc, m.nommasc, m.sexmasc, m.fotovacu, m.fotomasc,
                            m.razamasc, m.sizemasc, m.descmasc, m.enfermasc, m.iduser, m.actmasc,
                            v.codval AS estado,
                            CONCAT(u.prinom, ' ', u.priapel) AS nomdueno
                    FROM mascotas m
                    LEFT JOIN valor v ON m.actmasc = v.idval AND v.iddom = 1
                    LEFT JOIN usuario u ON m.iduser = u.iduser
                    WHERE m.iduser = :iduser
                    ORDER BY m.idmasc ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            error_log("Error al consultar mascotas del usuario: " . $e->getMessage());
            return [];
        }
    }

    // Admin se determina desde la relación de perfiles persistida en la BD.
    public function esAdmin($iduser){
        try{
            $sql = "SELECT 1
                    FROM userxper ux
                    INNER JOIN perfil p ON ux.idperf = p.idperf
                    WHERE ux.iduser = :iduser AND p.nomperf = 'Admin'
                    LIMIT 1";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->execute();
            return (bool) $result->fetchColumn();
        }catch(Exception $e){
            error_log("Error al verificar perfil administrador: " . $e->getMessage());
            return false;
        }
    }

    // Método getOne
    public function getOne(){
        try{
            $sql = "SELECT m.idmasc, m.nommasc, m.sexmasc, m.fotovacu, m.fotomasc,
                            m.razamasc, m.sizemasc, m.descmasc, m.enfermasc, m.iduser, m.actmasc,
                            v.codval AS estado,
                            CONCAT(u.prinom, ' ', u.priapel) AS nomdueno
                    FROM mascotas m
                    LEFT JOIN valor v ON m.actmasc = v.idval AND v.iddom = 1
                    LEFT JOIN usuario u ON m.iduser = u.iduser
                    WHERE m.idmasc = :idmasc";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmasc = $this->getIdmasc();
            $result->bindParam(":idmasc", $idmasc);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error 2: " . $e->getMessage();
        }
    }

    // Método save — DEVUELVE el id de la mascota recién creada (lastInsertId)
    public function save(){
        try{
            $sql = "INSERT INTO mascotas(nommasc, sexmasc, fotovacu, fotomasc, razamasc, sizemasc, descmasc, enfermasc, iduser)
                    VALUES(:nommasc, :sexmasc, :fotovacu, :fotomasc, :razamasc, :sizemasc, :descmasc, :enfermasc, :iduser)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $nommasc  = $this->getNommasc();
            $sexmasc  = $this->getSexmasc();
            $fotovacu = $this->getFotovacu();
            $fotomasc = $this->getFotomasc();
            $razamasc = $this->getRazamasc();
            $sizemasc = $this->getSizemasc();
            $descmasc = $this->getDescmasc();
            $enfermasc= $this->getEnfermasc();
            $iduser   = $this->getIduser();

            $result->bindParam(":nommasc",  $nommasc);
            $result->bindParam(":sexmasc",  $sexmasc);
            $result->bindParam(":fotovacu", $fotovacu);
            $result->bindParam(":fotomasc", $fotomasc);
            $result->bindParam(":razamasc", $razamasc);
            $result->bindParam(":sizemasc", $sizemasc);
            $result->bindParam(":descmasc", $descmasc);
            $result->bindParam(":enfermasc",$enfermasc);
            $result->bindParam(":iduser",   $iduser);
            $result->execute();

            return $conexion->lastInsertId(); // <-- para registrar duenomasc
        }catch(Exception $e){
            echo "Error 3: " . $e->getMessage();
        }
    }

    // Método upd
    public function upd($iduser, $esAdmin = false){
        try{
            $sql = "UPDATE mascotas SET
                        nommasc  = :nommasc,
                        sexmasc  = :sexmasc,
                        fotovacu = :fotovacu,
                        fotomasc = :fotomasc,
                        razamasc = :razamasc,
                        sizemasc = :sizemasc,
                        descmasc = :descmasc,
                        enfermasc= :enfermasc
                    WHERE idmasc = :idmasc
                      AND (:esAdmin = 1 OR iduser = :iduser)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idmasc   = $this->getIdmasc();
            $nommasc  = $this->getNommasc();
            $sexmasc  = $this->getSexmasc();
            $fotovacu = $this->getFotovacu();
            $fotomasc = $this->getFotomasc();
            $razamasc = $this->getRazamasc();
            $sizemasc = $this->getSizemasc();
            $descmasc = $this->getDescmasc();
            $enfermasc= $this->getEnfermasc();

            $result->bindParam(":idmasc",   $idmasc);
            $result->bindParam(":nommasc",  $nommasc);
            $result->bindParam(":sexmasc",  $sexmasc);
            $result->bindParam(":fotovacu", $fotovacu);
            $result->bindParam(":fotomasc", $fotomasc);
            $result->bindParam(":razamasc", $razamasc);
            $result->bindParam(":sizemasc", $sizemasc);
            $result->bindParam(":descmasc", $descmasc);
            $result->bindParam(":enfermasc",$enfermasc);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->bindValue(":esAdmin", $esAdmin ? 1 : 0, PDO::PARAM_INT);
            $result->execute();
            return true;
        }catch(Exception $e){
            error_log("Error al actualizar mascota: " . $e->getMessage());
            return false;
        }
    }

    public function toggleActiva($iduser, $esAdmin = false){
        try{
            $sql = "UPDATE mascotas
                    SET actmasc = CASE WHEN actmasc = 1 THEN 2 ELSE 1 END
                    WHERE idmasc = :idmasc
                      AND (:esAdmin = 1 OR iduser = :iduser)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmasc = $this->getIdmasc();
            $result->bindValue(":idmasc", (int) $idmasc, PDO::PARAM_INT);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->bindValue(":esAdmin", $esAdmin ? 1 : 0, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount() > 0;
        }catch(Exception $e){
            error_log("Error al cambiar el estado de la mascota: " . $e->getMessage());
            return false;
        }
    }

    // Método del
    public function del($iduser = null, $esAdmin = false){
        if ($iduser === null) {
            return false;
        }
        return $this->delOwned($iduser, $esAdmin);
    }

    // El borrado valida propiedad también en la consulta, no solo en el controller.
    public function delOwned($iduser, $esAdmin = false){
        $conexion = null;
        try{
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $idmasc = $this->getIdmasc();
            $conexion->beginTransaction();

            // Rutas de los archivos para borrarlos del disco tras el commit
            $fotomasc = NULL;
            $fotovacu = NULL;
            $archivos = $conexion->prepare("SELECT fotomasc, fotovacu FROM mascotas WHERE idmasc = :idmasc");
            $archivos->bindValue(":idmasc", (int) $idmasc, PDO::PARAM_INT);
            $archivos->execute();
            $rutaArchivos = $archivos->fetch(PDO::FETCH_ASSOC);
            if ($rutaArchivos) {
                $fotomasc = $rutaArchivos['fotomasc'];
                $fotovacu = $rutaArchivos['fotovacu'];
            }

            $relaciones = $conexion->prepare("DELETE FROM duenomasc WHERE idmasc = :idmasc");
            $relaciones->bindParam(":idmasc", $idmasc);
            $relaciones->execute();

            $sql = "DELETE FROM mascotas
                    WHERE idmasc = :idmasc
                      AND (:esAdmin = 1 OR iduser = :iduser)";
            $result = $conexion->prepare($sql);
            $result->bindParam(":idmasc", $idmasc);
            $result->bindValue(":iduser", (int) $iduser, PDO::PARAM_INT);
            $result->bindValue(":esAdmin", $esAdmin ? 1 : 0, PDO::PARAM_INT);
            $result->execute();

            if ($result->rowCount() < 1) {
                $conexion->rollBack();
                return false;
            }

            $conexion->commit();

            // La foto y el carnet dejan de existir en el disco
            if (!empty($fotomasc)) { mMasArchivo::eliminar($fotomasc); }
            if (!empty($fotovacu)) { mMasArchivo::eliminar($fotovacu); }

            return true;
        }catch(Exception $e){
            if ($conexion && $conexion->inTransaction()) {
                $conexion->rollBack();
            }
            error_log("Error al eliminar mascota: " . $e->getMessage());
            return false;
        }
    }
}
?>
