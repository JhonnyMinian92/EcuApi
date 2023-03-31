<?php

class ROLCLASS {

    //tabla rolapp
    private int $idrol;
    private string $nomrol;

    public function __construct() {}

    //Getter
    public function getIdrol() { return $this->idrol; }
    public function getNomrol() { return $this->nomrol; }
    
    //Setter
    public function setIdrol($idrol) { $this->idrol = $idrol; }
    public function setNomrol($nomrol) { $this->nomrol = $nomrol; }

}

?>