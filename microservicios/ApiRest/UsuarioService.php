<?php

// Verificar que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Acceso incorrecto';
    exit;
}
else {
        require_once ("../../coneccion/clases/usuarioclass.php");
        $usuario = new USUARIOCLASS();
        //obtener datos y funciones del crud
        $crud = $usuario->getCrud();
        //obtener datos de conexion
        $con = $crud->getConectar();
        // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
        if ($_SERVER['PHP_AUTH_USER'] !== $con->getUserservice() || $_SERVER['PHP_AUTH_PW'] !== $con->getPasservice()) {
            header('WWW-Authenticate: Basic realm="EcuApp"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Autenticación incorrecta';
            exit;
        } 
        else {
                // Recibir la solicitud POST con el array, el texto y el número
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['opcion'])) {
                    //varible para devolver
                    $respuesta = null;
                    //caso con las opciones a ejecutar
                    switch ($data['opcion']) {
                        case "logueo":
                            $status = $usuario->Loguearse($data['correo'],$data['clave']);
                            $rol = $usuario->getRol();
                            if($status){
                                $respuesta = ["status"=>$status,
                                              "token"=>$usuario->getToken(),
                                              "idusuario"=>$usuario->getIduser(),
                                              "rol"=>$rol->getIdrol()
                                              ];
                            } else { $respuesta = ["status"=>$status]; }                   
                            break;
                        case "registro":
                            echo "Ingresar Usuario";
                            break;
                        case "modifica":
                            echo "Modificar Clave";
                            break;
                        case "permiso":
                            $respuesta = $crud->ValidarCifrado($data['token'],$data['almacen']);
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
