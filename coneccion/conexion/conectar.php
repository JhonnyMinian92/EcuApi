<?php
//llamar clase propiedades
require_once(dirname(__FILE__)."/propiedades.php");

class CONECTAR {
    //constantes para conexion
    private string $host = "localhost";
    private string $usuario = "root";
    private string $contrasena = "EcuaP@ss2023";
    private string $baseDatos = "ecuabd";
    
    //varible conexion
    private $conexion;
    
    //llamar a propiedades
    private $propiedades;

    public function __construct() {
        //obtener todos los datos de clase propiedades
        $this->propiedades = new PROPIEDADESCLASS();
    }

    //Conexion a la base de datos
    public function ConectarBD() {
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        return $this->conexion;
    }

    //Desconectar de la base de datos
    public function Desconectar($conexion) {
        mysqli_close($conexion);
    }
    
    //funcion para returnar respuesta de si la base esta ok
    public function Response(){
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        if($this->conexion){ $respuesta = "true"; } else { $respuesta = "false"; }
        mysqli_close($this->conexion);
        return $respuesta;
    }
    
    //funcion para obtener el token de los servicios
    public function TokenServicios() {
        $con = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
        //obtener la fecha actual formato (2023-04-13)
        date_default_timezone_set('America/Guayaquil');
        $fecha_actual = date("Y-m-d");
        //obtener el token diario el ultimo registro
        $sql = "SELECT token FROM tokendia WHERE fecha_hora LIKE '".$fecha_actual."%' ORDER BY fecha_hora DESC LIMIT 1";
        $resultado = mysqli_query($con, $sql);
        $token = mysqli_fetch_assoc($resultado)['token'];
        mysqli_close($con);
        return $token;
    }
    
    //Getter de la clase propiedades
    public function getPropiedades() { return $this->propiedades; }

}

?>