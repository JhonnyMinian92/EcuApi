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
        $repositorio = $con->getPropiedades();

        // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
        if ($_SERVER['PHP_AUTH_USER'] !== $repositorio->getUsuarioservice() || $_SERVER['PHP_AUTH_PW'] !== $repositorio->getClaveservicio()) {
            include '../../error/405.php';
            exit;
        } 
        else {
                //obtener una codigo aleatorio para conectar (front a back)
                $conector = password_hash($repositorio->getClaveacceso(),PASSWORD_DEFAULT);
                echo json_encode($conector);
        }
}

?>