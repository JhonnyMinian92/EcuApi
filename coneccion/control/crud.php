<?php

require_once (dirname(__FILE__) ."/../conexion/conectar.php");

class MICRUD {
    //clases a conectar
    private $conectar;

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

    public function Encontrar($campo, $select){
        try {
                //conexion a la base de datos
                $conexion = $this->conectar->ConectarBD();
                //prepara el select para busqueda (rol (4-5) anulado - bloqueado)
                $stmt = $conexion->prepare($select);
                //agrega el parametro String(s) solo 1 por solo 1 parametro
                $stmt->bind_param("s", $campo);
                // Ejecutar la consulta del select
                $stmt->execute();
                $result = $stmt->get_result();
                //cerrar conexion
                $this->conectar->Desconectar($conexion);
                //devolver el valor
                return $result;
        } catch (Exception $e) { echo 'Error: ' . $e->getMessage(); return false; }
    }
    
    //ingresar
    public function Ingresar($tabla, $datos){
        try {
                //conexion a la base de datos
                $conexion = $this->conectar->ConectarBD();
                // crear la consulta SQL
                $campos = implode(', ', array_keys($datos));
                $marcadores = implode(', ', array_fill(0, count($datos), '?'));
                $sql = "INSERT INTO $tabla ($campos) VALUES ($marcadores)";
                $stmt = $conexion->prepare($sql);
                $tipos = ''; // inicializamos la cadena de tipos vacía
                $valores = []; // inicializamos el array de valores vacío
                // recorremos los datos para construir la cadena de tipos y el array de valores
                foreach ($datos as $valor) {
                    if (is_int($valor)) {
                            $tipos .= 'i'; // 'i' para enteros
                    } elseif (is_float($valor)) {
                            $tipos .= 'd'; // 'd' para números de coma flotante
                    } elseif (is_string($valor)) {
                            $tipos .= 's'; // 's' para cadenas
                    } else {
                            $tipos .= 'b'; // 'b' para blobs/binarios
                    }
                    $valores[] = $valor; // agregamos el valor al array de valores
                }
                $stmt->bind_param($tipos, ...$valores);
                if ($stmt->execute()) { 
                    //cerrar conexion
                    $this->conectar->Desconectar($conexion);
                    return $stmt->insert_id;
                } else { return false; }
                     
        } catch (Exception $e){ echo 'Error: ' . $e->getMessage(); return false; }
    }
    
    //modificar
    
    //listar
    
    //eliminar
    
    //buscar
    
    public function getConectar() { return $this->conectar; }

}

?>