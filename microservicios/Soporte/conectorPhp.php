<?php

// Verificar que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include '../../error/404.php';
    exit;
}
else {
        //obtener clase de control con funciones
        require_once("../../coneccion/conexion/conectar.php");
        //instaciar la clase con las funciones
        $con = new CONECTAR();

        // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
        if ($_SERVER['PHP_AUTH_USER'] !== $con->getUserservice() || $_SERVER['PHP_AUTH_PW'] !== $con->getPasservice()) {
            include '../../error/405.php';
            exit;
        } 
        else {
                //obtener una codigo aleatorio para conectar (front a back)
                $conector = password_hash("3Cu4pp#C0n3c72023", PASSWORD_DEFAULT);
                echo json_encode($conector);
        }
}

?>