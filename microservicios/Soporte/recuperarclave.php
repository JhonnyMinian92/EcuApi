<?php

if (!empty($_SERVER['HTTP_USER_AGENT'])) {
    
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        include '../../error/404.php';
        exit;
    }

    if(!isset($_GET["token"]) || $_GET["token"] == ""){
        include '../../error/404.php';
        exit;
    } else {
        $idusuario = base64_decode($_GET["token"]);
        //pagina recuperacion (llama servicios)
        
    }
    
} else {
    include '../../error/404.php';
    exit;
}
?>