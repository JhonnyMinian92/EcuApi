<?php
//colocar seguridad que solo se pueda conectar desde navegador
if (empty($_SERVER['HTTP_USER_AGENT'])) {
    //colocar seguridad por metodo post
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        include './error/404.php';
        exit;
    } else {
            //que a este archivo solo pueda acceder el front
            require_once './coneccion/conexion/conectar.php';
            try{
                $con = new CONECTAR();
                if($con->ConectarBD()){ echo json_encode("true"); } else { echo json_encode("false"); }
            } catch (Exception $e) { echo "false"; }
    }
} else {
    include './error/405.php';
    exit();
}




?>