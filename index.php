<?php
define('BASE_URL', '/gestion_libros_autores/');
require_once 'router.php';

$url = isset($_GET['url']) ? $_GET['url'] : '/';
$router = new Router();
$router->route($url);




