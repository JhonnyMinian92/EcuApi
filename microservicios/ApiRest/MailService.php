<?php
    // Verificar que la solicitud sea un POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('HTTP/1.1 405 Method Not Allowed');
        echo 'Acceso incorrecto';
        exit;
    }
    else {
            require_once ("../../coneccion/conexion/conectar.php");
            // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
            //obtener clases almacenadas
            $conexion = new CONECTAR();
            if ($_SERVER['PHP_AUTH_USER'] !== $conexion->getUserservice() || $_SERVER['PHP_AUTH_PW'] !== $conexion->getPasservice()) {
                header('WWW-Authenticate: Basic realm="EcuApp"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Autenticación incorrecta';
                exit;
            } 
            else {
                    // Recibir la solicitud POST para los datos del correo
                    $data = json_decode(file_get_contents('php://input'), true);
                    //datos de entrada
                    $headers = [
                        'From' => 'Ecuapp Mail <ecuappmail@gmail.com>',
                        'X-Sender' => 'Ecuapp Mail <ecuappmail@gmail.com>',
                        'X-Mailer' => 'PHP/' . phpversion(),
                        'X-Priority' => '1',
                        'Return-Path' => 'ecuappmail@gmail.com',
                        'MIME-Version' => '1.0',
                        'Content-Type' => 'text/html; charset=iso-8859-1'
                    ];
                    // Envío del correo electrónico
                    if (mail($data["destinatario"], $data['titulo'], $data['mensaje'], $headers)) { echo true; } else { echo false; }
            }
    }

?>