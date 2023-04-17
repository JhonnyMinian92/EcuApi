<?php
    // Verificar que la solicitud sea un POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        include '../../error/404.php';
        exit;
    }
    else {
            require_once ("../../coneccion/conexion/conectar.php");
            // Verificar las credenciales del usuario antes de permitir que se ejecute la solicitud POST
            //obtener clases almacenadas
            $conexion = new CONECTAR();
            if ($_SERVER['PHP_AUTH_USER'] !== $conexion->getUserservice() || $_SERVER['PHP_AUTH_PW'] !== $conexion->getPasservice()) {
                include '../../error/405.php';
                exit;
            } 
            else {
                    //recuperar de cabecera token enviado por middle
                    $authHeader = isset($_SERVER['HTTP_AUTHENTICATION']) ? $_SERVER['HTTP_AUTHENTICATION'] : '';
                    $token = "";
                    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) { $token = $matches[1]; } else { $token = $authHeader; }
                    //comparar token y validar para el acceso
                    if($token == ""){ include '../../error/404.php'; exit; }
                    //comparar token cifrado por seguridad
                    if(!password_verify($conexion->TokenServicios(), $token)){ include '../../error/405.php'; exit; }
                
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