<?php

class CONECTAR {
    private string $host = "localhost";
    private string $usuario = "root";
    private string $contrasena = "EcuaP@ss2023";
    private string $baseDatos = "ecuabd";
    private $conexion;
    //ruta para los servicios
    private string $patch = "http://localhost/EcuApi/microservicios/ApiRest/";
    private string $soporte = "http://localhost/EcuApi/microservicios/Soporte/";
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
    
    //funcion para obtener el token de los servicios
    public function TokenServicios() {
        $con = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        //obtener la fecha actual formato (2023-04-13)
        date_default_timezone_set('America/Guayaquil');
        $fecha_actual = date("Y-m-d");
        //obtener el token diario
        $sql = "SELECT token FROM tokendia WHERE fecha_hora LIKE '".$fecha_actual."%' ORDER BY fecha_hora DESC LIMIT 1";
        $resultado = mysqli_query($con, $sql);
        $token = mysqli_fetch_assoc($resultado)['token'];
        mysqli_close($con);
        return $token;
    }

    //Getter
    public function getPatch() { return $this->patch; }
    public function getSoporte() { return $this->soporte; }
    public function getUserservice() { return $this->usuarioservice; }
    public function getPasservice() { return $this->claveservicio; }
}

?>