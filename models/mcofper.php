<?php

if (!function_exists('ManejoError')) {
    function ManejoError($e) {
        error_log("UrbanPaws Error: " . $e->getMessage());
    }
}

class mCofPer
{
    private $idperf;
    private $idsPaginas;
    private $error;

    public function getIdperf(){return $this->idperf;}
    public function getIdsPaginas(){return $this->idsPaginas;}
    public function getError(){return $this->error;}

    public function setIdperf($idperf){$this->idperf=$idperf;}
    public function setIdsPaginas($idsPaginas){$this->idsPaginas=$idsPaginas;}

    private function setError($mensaje){$this->error=$mensaje;}

    public function getPaginas()
    {
        try{
            $sql = "SELECT idpag, titpag, nompag, mostpag, icopag, rutpag, ordpag, descpag
                    FROM pagina ORDER BY ordpag ASC, idpag ASC";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($e->getMessage());
            return NULL;
        }
    }

    public function getMatriz()
    {
        try{
            $sql = "SELECT idperf, idpag FROM pagxper ORDER BY idperf, idpag";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $filas = $result->fetchAll(PDO::FETCH_ASSOC);

            $matriz = array();
            foreach($filas as $f){
                $matriz[(int) $f["idperf"]][] = (int) $f["idpag"];
            }
            return $matriz;
        }catch(Exception $e){
            ManejoError($e);
            $this->setError($e->getMessage());
            return array();
        }
    }

    public function asignarPaginas()
    {
        $idperf = $this->getIdperf();
        if(!$idperf){
            $this->setError("Perfil no identificado para asignar páginas.");
            return NULL;
        }

        $ids = is_array($this->getIdsPaginas()) ? $this->getIdsPaginas() : array();

        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        try{
            $conexion->beginTransaction();

            $sql = "DELETE FROM pagxper WHERE idperf = :idperf";
            $result = $conexion->prepare($sql);
            $result->bindParam(":idperf", $idperf);
            $result->execute();

            if(count($ids) > 0){
                $sql = "INSERT INTO pagxper (idpag, idperf) VALUES (:idpag, :idperf)";
                $result = $conexion->prepare($sql);
                foreach($ids as $idpag){
                    $idpag = (int) $idpag;
                    $result->bindParam(":idpag", $idpag);
                    $result->bindParam(":idperf", $idperf);
                    $result->execute();
                }
            }

            $conexion->commit();
            return TRUE;
        }catch(Exception $e){
            $conexion->rollBack();
            ManejoError($e);
            $this->setError($e->getMessage());
            return NULL;
        }
    }
}
?>
