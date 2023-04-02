<?php
ini_set('memory_limit', '-1');

// Verificar que la solicitud sea un POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    include '../../error/404.php';
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
            include '../../error/405.php';
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
