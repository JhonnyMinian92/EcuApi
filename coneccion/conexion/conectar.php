<?php

class CONECTAR {
    private string $host = "localhost";
    private string $usuario = "root";
    private string $contrasena = "EcuaP@ss2023";
    private string $baseDatos = "ecuabd";
    private $conexion;
    //ruta para los servicios
    private string $patch = "http://localhost/EcuApi/microservicios/ApiRest/";
    //usuario y clave de los servicios
    private string $usuarioservice = "3Cu4ppServ1c3";
    private string $claveservicio = "R3st3cu4pp";

    public function __construct() { }

    public function ConectarBD() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        return $this->conexion;
    }

    public function Desconectar($conexion) {
        mysqli_close($conexion);
    }

    //Getter
    public function getPatch() { return $this->patch; }
    public function getUserservice() { return $this->usuarioservice; }
    public function getPasservice() { return $this->claveservicio; }
}

?>