<?php

class CONECTARMYSQL {
    //constantes para conexion
    private string $host = "localhost";
    private string $usuario = "root";
    private string $contrasena = "EcuaP@ss2023";
    private string $baseDatos = "ecuabd";
    //varible conexion
    private $conexion;

    public function __construct() {}

    //Conexion a la base de datos
    public function ConectarMysql() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        return $this->conexion;
    }

    //Desconectar de la base de datos
    public function DesconectarMysql($conexion) { mysqli_close($conexion); }
    
}

?>