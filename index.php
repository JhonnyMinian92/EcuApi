<?php

//colocar seguridad que solo se pueda conectar desde navegador
if (empty($_SERVER['HTTP_USER_AGENT'])) {
    include './error/404.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include './error/404.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './error/404.php';
    exit;
}
?>