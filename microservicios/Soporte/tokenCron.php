<?php

//definir para que solo se ejecute desde un cron
//if (!isset($_SERVER['CRON_TOKEN'])) { exit(); }

//definir que debe ser por GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { include '../../error/405.php'; exit; }
//validar que se envia la clave
if(!isset($_GET['key']) || $_GET['key']== ""){ include '../../error/405.php'; exit; }
//definir la clave como constante
define('SECRET_KEY', '3cUaP1cr0N23P4ss');
//comprobar si la clave es correcta
if (!defined('SECRET_KEY') || $_GET['key'] !== SECRET_KEY) {
    include '../../error/404.php';
    exit;
} else {
    require_once '../../coneccion/control/crud.php';
    //instanciar la funcion
    $crud = new MICRUD();
    //obtener el valor aleatorio
    $token = $crud->generarTokenServicio();
    //crear el array con los datos
    $datos = array('token' => $token); 
    //guardar en la base de datos
    if($crud->Ingresar("tokendia", $datos)){
        echo 'Token generado correctamente';
    } else { echo 'Error al generar token'; }
}

?>