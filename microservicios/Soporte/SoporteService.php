<?php

// Verificar que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include '../../error/404.php';
    exit;
}
else {
        //obtener clase de control con funciones
        require_once("../../coneccion/control/crud.php");
        require_once("../../coneccion/clases/usuarioclass.php");
        //instaciar la clase con las funciones
        $crud = new MICRUD();
        //obtener la data de conexion
        $con = $crud->getConectar();

        // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
        if ($_SERVER['PHP_AUTH_USER'] !== $con->getUserservice() || $_SERVER['PHP_AUTH_PW'] !== $con->getPasservice()) {
            include '../../error/405.php';
            exit;
        } 
        else {
                //recuperar de cabecera token enviado por middle
                $authHeader = isset($_SERVER['HTTP_AUTHENTICATION']) ? $_SERVER['HTTP_AUTHENTICATION'] : '';
                $tokendiario = "";
                if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) { $tokendiario = $matches[1]; } //else { $tokendiario = $authHeader; }
                //comparar token y validar para el acceso
                if($tokendiario == ""){ include '../../error/404.php'; exit; }
                //comparar token cifrado por seguridad
                if(!password_verify($con->TokenServicios(), $tokendiario)){ include '../../error/405.php'; exit; }
            
                //varible para devolver
                $respuesta = null;
                // Recibir la solicitud POST con el array, el texto y el número
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['opcion'])) {
                    //caso con las opciones a ejecutar
                    switch ($data['opcion']) {
                        case "cifrar":
                            $respuesta = $crud->CifrarDato($data['clave']);
                            break;
                        case "validar":
                            $respuesta = $crud->ValidarCifrado($data['valor'],$data['cifrado']);
                            break;
                        case "token":
                            $respuesta = $crud->GenerarToken();
                            break;
                        case "mailtoken":
                            $user = new USUARIOCLASS();
                            $respuesta = $user->EnviarToken($data['mail'], $data['token'], $tokendiario);
                            break;
                        default:
                            include '../../error/404.php';
                            break;
                    }
                    echo json_encode($respuesta);
                }
                else {
                        include '../../error/404.php';
                        exit;
                }
        }
}

?>