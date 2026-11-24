
<?php
class mExtini {
    // Atributos
    private $iduser;
    private $docu;
    private $emailu;
    private $teleu;
    private $passusu;
    
    // GETTERS
    function getIduser(){ return $this->iduser; }
    function getDocu(){ return $this->docu; }
    function getEmailu(){ return $this->emailu; }
    function getTeleu(){ return $this->teleu; }
    function getPassusu(){ return $this->passusu; }

    // SETTERS
    function setIduser($iduser){ $this->iduser = $iduser; }
    function setDocu($docu){ $this->docu = $docu; }
    function setEmailu($emailu){ $this->emailu = $emailu; }
    function setTeleu($teleu){ $this->teleu = $teleu; }
    function setPassusu($passusu){ $this->passusu = $passusu; }

    
    public function login(){
        $sql = "SELECT u.*,
                       GROUP_CONCAT(DISTINCT p.idperf ORDER BY p.idperf SEPARATOR ',') AS idperf_lista,
                       GROUP_CONCAT(DISTINCT p.nomperf ORDER BY p.idperf SEPARATOR ', ') AS nomperf
                FROM usuario u
                LEFT JOIN userxper ux ON u.iduser = ux.iduser
                LEFT JOIN perfil p ON ux.idperf = p.idperf
                WHERE (u.docu = :docu OR u.emailu = :emailu OR u.teleu = :teleu)
                AND u.estusr = 1
                GROUP BY u.iduser";
        $modelo = new Conexion();
        $conexion = $modelo->get_conexion();
        $result = $conexion->prepare($sql);
        $docu = $this->getDocu();
        $emailu = $this->getEmailu();
        $teleu = $this->getTeleu();
        $result->bindParam(":docu", $docu);
        $result->bindParam(":emailu", $emailu);
        $result->bindParam(":teleu", $teleu);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
?>

