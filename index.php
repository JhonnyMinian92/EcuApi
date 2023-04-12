<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include './error/404.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './error/405.php';
    exit;
}
?>