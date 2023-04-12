<?php
//que a este archivo solo pueda acceder el front
require_once './coneccion/conexion/conectar.php';
$con = new CONECTAR();
if($con->ConectarBD()){
    echo "true";
} else { echo "false"; }
?>