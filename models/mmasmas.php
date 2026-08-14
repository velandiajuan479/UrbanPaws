<?php
class mCofmas
{
    private $idmasc;
    private $nommasc;
    private $sexmasc;
    private $fotovacu;
    private $fotomasc;
    private $razamasc;
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
    function setDescmasc($descmasc){ return $this->descmasc = $descmasc; }
    function setEnfermasc($enfermasc){ return $this->enfermasc = $enfermasc; }
    function setIduser($iduser){ return $this->iduser = $iduser; }

    // Método getAll (JOIN con usuario para mostrar el dueño)
    public function getAll(){
        try{
            $sql = "SELECT m.idmasc, m.nommasc, m.sexmasc, m.fotovacu, m.fotomasc,
                           m.razamasc, m.descmasc, m.enfermasc, m.iduser,
                           CONCAT(u.prinom, ' ', u.priapel) AS nomdueno
                    FROM mascotas m
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

    // Método getOne
    public function getOne(){
        try{
            $sql = "SELECT m.idmasc, m.nommasc, m.sexmasc, m.fotovacu, m.fotomasc,
                           m.razamasc, m.descmasc, m.enfermasc, m.iduser,
                           CONCAT(u.prinom, ' ', u.priapel) AS nomdueno
                    FROM mascotas m
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
            $sql = "INSERT INTO mascotas(nommasc, sexmasc, fotovacu, fotomasc, razamasc, descmasc, enfermasc, iduser)
                    VALUES(:nommasc, :sexmasc, :fotovacu, :fotomasc, :razamasc, :descmasc, :enfermasc, :iduser)";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $nommasc  = $this->getNommasc();
            $sexmasc  = $this->getSexmasc();
            $fotovacu = $this->getFotovacu();
            $fotomasc = $this->getFotomasc();
            $razamasc = $this->getRazamasc();
            $descmasc = $this->getDescmasc();
            $enfermasc= $this->getEnfermasc();
            $iduser   = $this->getIduser();

            $result->bindParam(":nommasc",  $nommasc);
            $result->bindParam(":sexmasc",  $sexmasc);
            $result->bindParam(":fotovacu", $fotovacu);
            $result->bindParam(":fotomasc", $fotomasc);
            $result->bindParam(":razamasc", $razamasc);
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
    public function upd(){
        try{
            $sql = "UPDATE mascotas SET
                        nommasc  = :nommasc,
                        sexmasc  = :sexmasc,
                        fotovacu = :fotovacu,
                        fotomasc = :fotomasc,
                        razamasc = :razamasc,
                        descmasc = :descmasc,
                        enfermasc= :enfermasc,
                        iduser   = :iduser
                    WHERE idmasc = :idmasc";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idmasc   = $this->getIdmasc();
            $nommasc  = $this->getNommasc();
            $sexmasc  = $this->getSexmasc();
            $fotovacu = $this->getFotovacu();
            $fotomasc = $this->getFotomasc();
            $razamasc = $this->getRazamasc();
            $descmasc = $this->getDescmasc();
            $enfermasc= $this->getEnfermasc();
            $iduser   = $this->getIduser();

            $result->bindParam(":idmasc",   $idmasc);
            $result->bindParam(":nommasc",  $nommasc);
            $result->bindParam(":sexmasc",  $sexmasc);
            $result->bindParam(":fotovacu", $fotovacu);
            $result->bindParam(":fotomasc", $fotomasc);
            $result->bindParam(":razamasc", $razamasc);
            $result->bindParam(":descmasc", $descmasc);
            $result->bindParam(":enfermasc",$enfermasc);
            $result->bindParam(":iduser",   $iduser);
            $result->execute();
        }catch(Exception $e){
            echo "Error 4: " . $e->getMessage();
        }
    }

    // Método del
    public function del(){
        try{
            $sql = "DELETE FROM mascotas WHERE idmasc = :idmasc";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idmasc = $this->getIdmasc();
            $result->bindParam(":idmasc", $idmasc);
            $result->execute();
        }catch(Exception $e){
            echo "Error 5: " . $e->getMessage();
        }
    }
}
?>