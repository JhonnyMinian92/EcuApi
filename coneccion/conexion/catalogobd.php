<?php
//llamar clase postgres
require_once (dirname(__FILE__).'./conectarpg.php');
//llamar clase mysql
require_once (dirname(__FILE__).'./conectarsql.php');
//llamar clase propiedades
require_once(dirname(__FILE__)."/propiedades.php");

class CATALOGOBD {

    //variable para clase postgres
    private $conexionpg;
    //variable para clase mysql
    private $conexionmysql;
    //nombre de la base principal seleccionada
    private string $bd;
    
    //constructor por defecto
    public function __construct() {
        $this->bd = "mysql";
        $this->conexionmysql = new CONECTARMYSQL();
        $this->conexionpg = new CONECTARPG();
    }
    
    //funcion para returnar respuesta de si la base esta ok
    public function Response(){
        $respuesta = "false";
        //llamar a la conexion de la base principal
        if($this->bd == "mysql"){
            //validar con mysql
            $this->conexion = mysqli_connect($this->conexionmysql->host, $this->conexionmysql->usuario, $this->conexionmysql->contrasena, $this->conexionmysql->baseDatos);
            if($this->conexion){ $respuesta = "true"; } else { $respuesta = "false"; }
            mysqli_close($this->conexion);
        }
        if($this->bd == "postgres"){
            //validar con postgres
            $this->conexion = pg_connect("host={$this->conexionpg->host} port={$this->conexionpg->port} dbname={$this->conexionpg->database} user={$this->conexionpg->user} password={$this->conexionpg->password}");
            if($this->conexion){ $respuesta = "true"; } else { $respuesta = "false"; }
            pg_close($this->conexion);
        }
        return $respuesta;
    }
    
    //funcion para obtener el token de los servicios
    public function TokenServicios() {
        $token = "";
        //obtener la fecha actual formato (2023-04-13)
        date_default_timezone_set('America/Guayaquil');
        $fecha_actual = date("Y-m-d");
        //obtener el token diario el ultimo registro
        $sql = "SELECT token FROM tokendia WHERE fecha_hora LIKE '".$fecha_actual."%' ORDER BY fecha_hora DESC LIMIT 1";
        if($this->bd == "mysql"){
            $con = mysqli_connect($this->conexionmysql->host, $this->conexionmysql->usuario, $this->conexionmysql->contrasena, $this->conexionmysql->baseDatos);
            $resultado = mysqli_query($con, $sql);
            $token = mysqli_fetch_assoc($resultado)['token'];
            mysqli_close($con);
        }
        if($this->bd == "postgres"){
            $con = pg_connect("host={$this->conexionpg->host} port={$this->conexionpg->port} dbname={$this->conexionpg->database} user={$this->conexionpg->user} password={$this->conexionpg->password}");
            $resultado = pg_query($con, $sql);
            $token = pg_fetch_assoc($resultado)['token'];
            pg_free_result($resultado);
            pg_close($con);
        }
        return $token;
    }
    
    //Getter de la clase propiedades
    public function getPropiedades() { return $this->propiedades; }
    //Getter de la clase postgres
    public function getConexionpg() { return $this->conexionpg; }
    //Getter de la clase mysql
    public function getConexionmysql() { return $this->conexionmysql; }


    
}
