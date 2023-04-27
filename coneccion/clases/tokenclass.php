<?php

class TOKENCLASS {
    
    private int $id_token;
    private string $token;
    private DateTime $fecha;
    
    public function __construct() {}
    
    public function getId_token() {
        return $this->id_token;
    }

    public function getToken() {
        return $this->token;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setId_token(int $id_token) {
        $this->id_token = $id_token;
    }

    public function setToken(string $token) {
        $this->token = $token;
    }

    public function setFecha(DateTime $fecha) {
        $this->fecha = $fecha;
    }
    
}
