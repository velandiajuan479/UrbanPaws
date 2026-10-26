<?php

class mCofdom{

    private $iddom;
    private $nomdom;
    private $actdom;

    // Conexión cacheada: se abre una sola vez por instancia (antes se abría una nueva en cada método)
    private $conexion = null;

    public function getIddom(){ return $this->iddom;}
    public function getNomdom(){ return $this->nomdom;}
    public function getActdom(){ return $this->actdom;}

    public function setIddom($iddom){ $this->iddom = $iddom;}
    public function setNomdom($nomdom){ $this->nomdom = $nomdom;}
    public function setActdom($actdom){ $this->actdom = $actdom;}

    // Obtiene (y reutiliza) la conexión PDO con el modo de excepciones activado,
    // para que los try/catch realmente detecten errores SQL
    private function getConexion(){
        if($this->conexion === null){
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            // Fix 2.2 / 3.6.2: sin esto, PDO devolvía "false" silenciosamente y los catch no se disparaban
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion = $conexion;
        }
        return $this->conexion;
    }

    // LISTAR
    public function getAll(){
        try{
            $sql = "SELECT d.iddom, d.nomdom, d.actdom,
                        v.codval AS estado
                FROM dominio d
                LEFT JOIN valor v ON d.actdom = v.idval
                ORDER BY d.iddom ASC";
            $result = $this->getConexion()->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            // Fix 3.1.1 / 3.1.2: numeración única por método y getMessage() (antes imprimía el objeto Exception completo)
            error_log("mCofdom::getAll - Error 1: " . $e->getMessage());
            return false;
        }
    }

    // OBTENER UNO
    public function getOne(){
        try{
            $sql = "SELECT d.iddom, d.nomdom, d.actdom,
                        v.codval AS estado
                FROM dominio d
                LEFT JOIN valor v ON d.actdom = v.idval
                WHERE d.iddom = :iddom";
            $result = $this->getConexion()->prepare($sql);
            $iddom = $this->getIddom();
            $result->bindParam(":iddom", $iddom);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            error_log("mCofdom::getOne - Error 2: " . $e->getMessage());
            return false;
        }
    }

    // GUARDAR
    public function save(){
        try{
            $sql = "INSERT INTO dominio(nomdom, actdom)
                VALUES(:nomdom, :actdom)";

            $result = $this->getConexion()->prepare($sql);

            $nomdom = $this->getNomdom();
            $actdom = $this->getActdom();
            $result->bindParam(":nomdom", $nomdom);
            $result->bindParam(":actdom", $actdom);

            // Fix 3.1.3: consolidado — los métodos de escritura SIEMPRE devuelven bool,
            // así el controlador puede distinguir éxito de fracaso
            return $result->execute();
        }catch(Exception $e){
            error_log("mCofdom::save - Error 3: " . $e->getMessage());
            return false;
        }
    }

    // ACTUALIZAR
    public function upd(){
        try{
            $sql = "UPDATE dominio
                SET nomdom = :nomdom,
                    actdom = :actdom
                WHERE iddom = :iddom";

            $result = $this->getConexion()->prepare($sql);

            $iddom = $this->getIddom();
            $nomdom = $this->getNomdom();
            $actdom = $this->getActdom();

            $result->bindParam(":iddom", $iddom);
            $result->bindParam(":nomdom", $nomdom);
            $result->bindParam(":actdom", $actdom);

            return $result->execute();
        }catch(Exception $e){
            error_log("mCofdom::upd - Error 4: " . $e->getMessage());
            return false;
        }
    }

    // ELIMINAR
    public function del(){
        try{
            $sql = "DELETE FROM dominio
                WHERE iddom = :iddom";

            $result = $this->getConexion()->prepare($sql);

            $iddom = $this->getIddom();

            $result->bindParam(":iddom", $iddom);

            // Fix 3.1.1: el catch repetía "Error 1" (mismo número que getAll); ahora es "Error 5"
            return $result->execute();
        }catch(Exception $e){
            error_log("mCofdom::del - Error 5: " . $e->getMessage());
            return false;
        }
    }

    public function toggleActdom(){
        try{
            $sql = "UPDATE dominio SET actdom=CASE WHEN actdom='1' THEN '2' ELSE '1' END WHERE iddom=:iddom";
            $result = $this->getConexion()->prepare($sql);
            $iddom = $this->getIddom();
            $result->bindParam(":iddom", $iddom);
            return $result->execute();
        }catch(Exception $e){
            error_log("mCofdom::toggleActdom - Error 6: " . $e->getMessage());
            return false;
        }
    }
}
?>
