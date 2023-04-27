<?php
//colocar seguridad que solo se pueda conectar desde navegador
if (empty($_SERVER['HTTP_USER_AGENT'])) {
    //colocar seguridad por metodo post
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        include './error/404.php';
        exit;
    } else {
            //llamar la clase
            require_once './coneccion/conexion/conectar.php';
            try{
                //generar conexion
                $con = new CONECTAR();
                //enviar respuesta
                echo json_encode($con->Response());
            } catch (Exception $e) { echo "false"; }
    }   
} else {
    include './error/405.php';
    exit();
}

?>