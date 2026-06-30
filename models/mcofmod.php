<?php
class mCofMod
{
    private $idmod;
    private $nommod;
    private $estamod;
    private $ordmod;
    private $idpag;
    private $idperf;

function getIdMod(){return $this->idmod;}
function getNomMod(){return $this->nommod;}
function getEstaMod(){return $this->estamod;}
function getOrdMod(){return $this->ordmod;}
function getIdPag(){return $this->idpag;}
function getIdPerf(){return $this->idperf;}

function setIdmod ($idmod){return $this->idmod = $idmod;}
function setNommod ($nommod){return $this->nommod = $nommod;}
function setEstamod($estamod){return $this->estamod= $estamod;}
function setOrdmod ($ordmod){return $this->ordmod = $ordmod;}
function setIdpag ($idpag){return $this->idpag = $idpag;}
function setIdperf ($idperf){return $this->idperf = $idperf;}

public function getAll (){
    try{
        $sql = "SELECT m.idmod ,m.nommod ,m.estamo ,m.ordmod ,idpag ,idperf";

    }
}
}
