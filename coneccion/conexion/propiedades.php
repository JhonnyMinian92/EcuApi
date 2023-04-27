<?php

class PROPIEDADESCLASS {
    
    //ruta del dominio
    private string $dominio = "http://localhost/EcuApi/";
    
    //ruta para los servicios (directorio)
    private string $patch = "";
    private string $soporte = "";
    
    //usuario y clave de los servicios (autorization)
    private string $usuarioservice = "3Cu4ppServ1c3";
    private string $claveservicio = "R3st3cu4pp";
    
    //clave de acceso para intermediario
    private string $claveacceso = "3Cu4pp#C0n3c72023";

    public function __construct() { 
        $this->patch = $this->dominio."microservicios/ApiRest/";
        $this->soporte = $this->dominio. "microservicios/Soporte/";
    }
    
    public function getPatch(){ return $this->patch; }

    public function getSoporte(){ return $this->soporte; }

    public function getUsuarioservice(){ return $this->usuarioservice; }

    public function getClaveservicio() { return $this->claveservicio; }

    public function getClaveacceso(){ return $this->claveacceso; }
    
    public function getDominio(){ return $this->dominio; }
    
}
