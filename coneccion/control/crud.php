<?php

require_once (dirname(__FILE__) ."/../clases/usuarioclass.php");
require_once (dirname(__FILE__) ."/../clases/rolclass.php");
require_once (dirname(__FILE__) ."/../conexion/conectar.php");

class MICRUD {
    //clases a conectar
    private $conectar;
    private $usuario;
    private $rol;
    //variables para almacenar por login
    private $token;

    public function __construct() {
        $this->conectar = new CONECTAR();
    }

    public function GenerarToken(){
        // Generamos una cadena aleatoria de longitud 10
        $cadenaAleatoria = bin2hex(random_bytes(10));
        // Aplicamos la función hash SHA-256 a la cadena aleatoria
        $hash = hash('sha256', $cadenaAleatoria);
        // Obtenemos los primeros 6 dígitos numéricos del hash
        $token = preg_replace("/[^0-9]/", "", substr($hash, 0, 6));
        // Si el token tiene menos de 6 dígitos, lo completamos con dígitos aleatorios
        while(strlen($token) < 6) { $token .= mt_rand(0, 9); }
        // Devolvemos el token generado
        return $token;
    }

    public function CifrarDato($valor){
        //convertir en encriptado (claves y token)
        return password_hash($valor, PASSWORD_DEFAULT);
    }

    public function ValidarCifrado($valor, $cifrado){
        //validar el valor vs el cifrado
        if(password_verify($valor, $cifrado)){ return true; } else { return false; }
    }

    public function EnviarCorreo($correo, $titulo, $mensaje){
        $data = array(
            "destinatario" => $correo,
            "titulo" => $titulo,
            "mensaje" => $mensaje
        );
        // Convertir el array a formato JSON
        $json_data = json_encode($data);
        //servicio de envio de correos
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->conectar->getPatch().'MailService.php',
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
            'Content-Type: text/plain'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function EnviarToken($mail, $token){
        $titulo = "Codigo de Autenticacion ECUAPP";
        //variable mensaje personalizada
        $mensaje = '<html><body>';
        $mensaje .= '<img src="https://i.postimg.cc/Y0Q2rkRt/logo2.png" alt="Logo ECUAPP" style="display:block; margin:auto;">';
        $mensaje .= '<h1 style="text-align:center; color:#2d3b4e;">Bienvenido a ECUAPP</h1>';
        $mensaje .= '<p style="text-align:center;">Gracias por unirte a nuestra plataforma de servicios ciudadanos. Nos complace tenerte como parte de nuestra comunidad. </p>';
        $mensaje .= '<p style="text-align:center;">Tu código de seguridad es:</p>';
        $mensaje .= '<h2 style="text-align:center; font-size:36px; color:#2d3b4e;">' .$token. '</h2>';
        $mensaje .= '<p style="text-align:center;">Este código es confidencial, por favor no lo compartas con nadie. </p>';
        $mensaje .= '</body></html>';
        return $this->EnviarCorreo($mail, $titulo, $mensaje);
    }

    public function Loguear($mail, $clave){
        try {
                $respuesta = false;
                //conexion a la base de datos
                $conexion = $this->conectar->ConectarBD();
                //prepara el select para busqueda (rol (4-5) anulado - bloqueado)
                $stmt = $conexion->prepare("SELECT userapp.id_userapp, userapp.mail_user, userapp.pass_user, rolapp.idrol, rolapp.nomrol FROM userapp, rolapp WHERE userapp.rol_user = rolapp.idrol AND userapp.mail_user = ? AND (userapp.rol_user != 4 AND userapp.rol_user != 5) LIMIT 1");
                //agrega el parametro String(s) solo 1 por solo 1 parametro
                $stmt->bind_param("s", $mail);
                // Ejecutar la consulta del select
                $stmt->execute();
                $result = $stmt->get_result();
                // Verificar si se encontró un registro con el mail
                if ($result->num_rows === 1) { 
                    // Obtener la fila del resultado
                    $fila = $result->fetch_assoc();
                    // Verificar la contraseña
                    if ($this->ValidarCifrado($clave, $fila["pass_user"])) {
                        //conexion a clases de usuario referencia a BD
                        $this->usuario = new USUARIOCLASS();
                        //almacenar en la clase lo de usuario
                        $this->usuario->setIduser($fila["id_userapp"]);
                        $this->usuario->setMail($fila["mail_user"]);
                        $this->usuario->setClave($fila["pass_user"]);
                        //conexion a clases de rol referencia a BD
                        $this->rol = new ROLCLASS();
                        //almacenar en la clase lo de usuario
                        $this->rol->setIdrol($fila["idrol"]);
                        $this->rol->setNomrol($fila["nomrol"]);
                        //crear el token y guardarlo
                        $this->token = $this->GenerarToken();
                        //enviar correo con token
                        if($this->EnviarToken($mail, $this->token)){
                            //cifrar el token para enviarlo
                            $this->token = $this->CifrarDato($this->token);
                            $respuesta = true;
                        }
                    }
                }
                //cerrar conexion
                $this->conectar->Desconectar($conexion);
                return $respuesta;
        } catch (Exception $e) { echo 'Error: ' . $e->getMessage(); return false; }
    }


    //Getter
    public function getToken() { return $this->token; }
    public function getUsuario() { return $this->usuario; }
    public function getRol() { return $this->rol; }
    public function getUserservice() { return $this->conectar->getUserservice(); }
    public function getPasservice() { return $this->conectar->getPasservice(); }

}

?>