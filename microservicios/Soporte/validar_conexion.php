<?php
//llamar conexion
require_once '../../coneccion/conexion/conectar.php';
//crear instancia
try {
        $con = new CONECTAR();
        if($con->ConectarBD()){ echo 'true'; } else { echo 'false'; }
} catch (Exception $ex) { echo 'false'; }

?>