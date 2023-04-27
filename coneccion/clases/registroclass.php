<?php

class REGISTROCLASS {
    
    private int $id_registro;
    private string $registrofecha;
    private string $geolocalizacion;
    private int $idusuario;
    
    public function __construct() {}
    
    //Getter
    public function getId_registro() { return $this->id_registro; }

    public function getRegistrofecha() { return $this->registrofecha; }

    public function getGeolocalizacion() { return $this->geolocalizacion; }

    public function getIdusuario() { return $this->idusuario; }
    
    //Setter
    public function setId_registro(int $id_registro) {  $this->id_registro = $id_registro; }

    public function setRegistrofecha(string $registrofecha) { $this->registrofecha = $registrofecha; }

    public function setGeolocalizacion(string $geolocalizacion) { $this->geolocalizacion = $geolocalizacion; }

    public function setIdusuario(int $idusuario) { $this->idusuario = $idusuario; }
    
}
