<?php

require_once (dirname(__FILE__)."/rolclass.php");
require_once (dirname(__FILE__)."/../control/crud.php");

class USUARIOCLASS {
    
    //tabla userapp
    private int $id_userapp;
    private string $mail_user;
    private string $pass_user;
    //variable temporal para login
    private string $token;
    //llamar clase crud para sus funciones
    private $crud;
    private $rol;

    public function __construct() {
        //conexion a clase con funciones estandar
        $this->crud = new MICRUD();
        //conexion a clases de rol referencia a BD
         $this->rol = new ROLCLASS();
         //definir el token en vacio
         $this->token = "";
    }
    
    //funcion login
    public function Loguearse($mail, $clave){
        $respuesta = false;
        $select = "SELECT userapp.id_userapp, userapp.mail_user, userapp.pass_user, rolapp.idrol, rolapp.nomrol FROM userapp, rolapp WHERE userapp.rol_user = rolapp.idrol AND userapp.mail_user = ? AND (userapp.rol_user != 0 AND userapp.rol_user != 4) LIMIT 1";
        $result = $this->crud->Encontrar($mail, $select);
        if ($result->num_rows === 1) { 
                    // Obtener la fila del resultado
                    $fila = $result->fetch_assoc();
                    // Verificar la contraseña
                    if ($this->crud->ValidarCifrado($clave, $fila["pass_user"])) {
                        //almacenar en la clase lo de usuario
                        $this->setIduser($fila["id_userapp"]);
                        $this->setMail($fila["mail_user"]);
                        $this->setClave($fila["pass_user"]);
                        //almacenar en la clase lo de usuario
                        $this->rol->setIdrol($fila["idrol"]);
                        $this->rol->setNomrol($fila["nomrol"]);
                        if($fila["idrol"] != 5){
                            //crear el token y guardarlo
                            $numtoken = $this->crud->GenerarToken();
                            //enviar correo con token
                            if($this->EnviarToken($mail, $numtoken)){
                                //cifrar el token para enviarlo
                                $this->setToken($this->crud->CifrarDato($numtoken));
                                $respuesta = true;
                            }
                        } else { $respuesta = true; }
                        
                    }
            }
        return $respuesta;
    }
    
    //enviar token personalizado para usuario logueado/registrado
    public function EnviarToken($correo, $token){
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
        return $this->crud->EnviarCorreo($correo, $titulo, $mensaje);
    }
    
    //funcion para registrar
    
    //funcion para modificar clave
    

    //Getter de variables
    public function getIduser() { return $this->id_userapp; }
    public function getMail() { return $this->mail_user; }
    public function getClave() { return $this->pass_user; }
    public function getToken() { return $this->token; }
    //Getter de clases
    public function getRol() { return $this->rol; }
    public function getCrud() { return $this->crud;} 
        
    //Setter de variables
    public function setIduser($id_userapp) { $this->id_userapp = $id_userapp; }
    public function setMail($mail_user) { $this->mail_user = $mail_user; }
    public function setClave($pass_user) { $this->pass_user = $pass_user; }
    public function setToken($token) { return $this->token = $token; }

}

?>