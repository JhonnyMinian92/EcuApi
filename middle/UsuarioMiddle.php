<?php
//definir sesion solo mientras pestaña esta abierta
session_set_cookie_params(0);
//iniciar sesion para guardar token y usuario
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    
    //obtener claves de acceso a servicio
    require_once("../coneccion/conexion/conectar.php");
    //instaciar la clase con las funciones
    $con = new CONECTAR();
    $repositorio = $con->getPropiedades();
    //Ruta de servicios (normal-soporte)
    $patch = $repositorio->getPatch();
    $soporte = $repositorio->getSoporte();
    
    // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
    if ($_SERVER['PHP_AUTH_USER'] !== $repositorio->getUsuarioservice() || $_SERVER['PHP_AUTH_PW'] !== $repositorio->getClaveservicio()) {
        include '../error/405.php';
        exit;
    }
    
    if(!isset($_POST["auth"])){
        include '../error/404.php';
        exit;
    }
    
    //validar el acceso por clave de autorizacion
    if(!password_verify($repositorio->getClaveacceso(),json_decode($_POST["auth"]))){
        include '../error/405.php';
        exit;
    }
    
    // Código que se ejecuta si la solicitud es POST
    if(isset($_POST["opcion"])){
        //decifrar opcion cifrada de javascript
        $_POST["opcion"] = base64_decode($_POST["opcion"]);
        //obtener el token diario desde la bd y enviar por header
        //cifrar token por seguridad
        $tokendiario = password_hash($con->TokenServicios(), PASSWORD_DEFAULT);
        
        //Escoger las opciones
        switch ($_POST["opcion"]) {
            case "op1":
                //decifrar clave y usuario enviados por javascript
                $_POST["correo"] = base64_decode($_POST["correo"]);
                $_POST["clave"] = base64_decode($_POST["clave"]);
                //funcion para logueo incial de usuario
                $json = ServicioLogueo($_POST["correo"],$_POST["clave"],$tokendiario);
                $data = json_decode($json);
                if($data->status){ 
                    if($data->rol != 5){
                        $_SESSION["token"] = password_hash($data->token, PASSWORD_DEFAULT); 
                        $_SESSION["idusuario"]  = $data->idusuario; 
                        $_SESSION["rol"] = $data->rol;
                        echo json_encode($data->status);
                        EnviarToken($data->token, $_POST["correo"], $tokendiario);
                    } else { echo json_encode("-1"); }  
                } else { echo json_encode($data->status); }
                break;
            case "op2":
                //funcion para Ingresar Usuario
                
                break;
            case "op3":
                //funcion para Modificar Clave
                $_POST["correo"] = base64_decode($_POST["correo"]);
                echo RecuperarClave($_POST["correo"], $tokendiario);
                break;
            case "op4":
                //funcion para Validar Autenticacion
                $_POST["token"] = base64_decode($_POST["token"]);
                //marcar el login
                if(ValidarToken($_POST["token"],$tokendiario)){ echo MarcarLogin($_SESSION["idusuario"],$_POST["geolocalizacion"],$tokendiario); } 
                else { echo json_encode(false); }
                break;
            case "op5":
                //resetear sesion
                session_destroy();
                echo json_encode(true);
                break;
            default:
                include '../error/404.php';
                break;
        }
    } 
    else {
            include '../error/405.php';
            exit;
    }

} else {
    include '../error/404.php';
    exit;
}


function ServicioLogueo($correo,$clave,$tokendiario){
    $data = array(
            "opcion" => "logueo",
            "correo" => $correo,
            "clave" => $clave
            );
    global $patch;
    // Convertir el array a formato JSON
    $json_data = json_encode($data);
    //llamar al servicio validar login
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $patch.'UsuarioService.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$json_data,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic M0N1NHBwU2VydjFjMzpSM3N0M2N1NHBw',
        'Authentication: Bearer '.$tokendiario.'',
        'Content-Type: text/plain'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function ValidarToken($token,$tokendiario){
    $data = array(
            "opcion" => "permiso",
            "token" => $token,
            "almacen" => $_SESSION["token"]
    );
    global $patch;
    // Convertir el array a formato JSON
    $json_data = json_encode($data);
    //llamar al servicio validar token
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $patch.'UsuarioService.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$json_data,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic M0N1NHBwU2VydjFjMzpSM3N0M2N1NHBw',
        'Authentication: Bearer '.$tokendiario.'',
        'Content-Type: text/plain'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function EnviarToken($token, $mail, $tokendiario){
    $data = array(
            "opcion" => "mailtoken",
            "mail" => $mail,
            "token" => $token
            );
    // Convertir el array a formato JSON
    $json_data = json_encode($data);
    global $soporte;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $soporte.'SoporteService.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json_data,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic M0N1NHBwU2VydjFjMzpSM3N0M2N1NHBw',
        'Authentication: Bearer '.$tokendiario.'',
        'Content-Type: text/plain'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function MarcarLogin($idusuario,$geolocalizacion,$tokendiario){
    $data = array(
            "opcion" => "marcar",
            "idusuario" => $idusuario,
            "geolocalizacion" => $geolocalizacion
    );
    // Convertir el array a formato JSON
    $json_data = json_encode($data);
    global $patch;
    //servicio para marcar
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $patch.'UsuarioService.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json_data,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic M0N1NHBwU2VydjFjMzpSM3N0M2N1NHBw',
        'Authentication: Bearer '.$tokendiario.'',
        'Content-Type: text/plain'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function RecuperarClave($correo, $tokendiario){
    $data = array(
            "opcion" => "modifica",
            "correo" => $correo
    );
    // Convertir el array a formato JSON
    $json_data = json_encode($data);
    global $patch;
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $patch.'UsuarioService.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $json_data,
      CURLOPT_HTTPHEADER => array(
        'Authentication: Bearer '.$tokendiario.'',
        'Content-Type: text/plain',
        'Authorization: Basic M0N1NHBwU2VydjFjMzpSM3N0M2N1NHBw'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

?>
