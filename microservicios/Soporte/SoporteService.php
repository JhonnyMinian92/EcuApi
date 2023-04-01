<?php

// Verificar que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Acceso incorrecto';
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
            header('WWW-Authenticate: Basic realm="EcuApp"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Autenticación incorrecta';
            exit;
        } 
        else {
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
                            $respuesta = $user->EnviarToken($data['mail'], $data['token']);
                            break;
                        default:
                            header('HTTP/1.1 405 Method Not Allowed');
                            echo 'Acceso incorrecto';
                            break;
                    }
                    echo json_encode($respuesta);
                }
                else {
                        header('HTTP/1.1 405 Method Not Allowed');
                        echo 'Acceso incorrecto';
                        exit;
                }
        }
}

?>