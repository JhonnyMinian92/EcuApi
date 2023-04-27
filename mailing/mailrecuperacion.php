<?php
//colocar seguridad que solo se pueda conectar desde navegador
if (empty($_SERVER['HTTP_USER_AGENT'])) {
    include './../error/404.php';
    exit;
}
?>
<html>
    <head>
        <title>title</title>
    </head>
    <body>

    </body>
</html>