<?php

class CONECTARPG {
  //constantes para la conexion
  private string $host = "localhost";
  private string $port = "5432";
  private string $database = "ecuapp-market";
  private string $user = "postgres";
  private string $password = "root";
  //variable conexion
  private $conexion;

  public function __construct() {}

  //Conexion a postgres
  public function ConectarPG() {
    $this->conexion = pg_connect("host={$this->host} port={$this->port} dbname={$this->database} user={$this->user} password={$this->password}");
    return $this->conexion;
  }
  
  //Desconectar de postgres
  public function DesconectarPG($conexion) { pg_close($conexion); }
  
}

?>