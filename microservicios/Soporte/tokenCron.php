<?php

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

?>