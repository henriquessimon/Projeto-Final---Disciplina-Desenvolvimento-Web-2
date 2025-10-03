<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/config/connection.php';

require_once __DIR__ . '/core/Autoloader.php';

require_once __DIR__ . '/core/Router.php';

$controller = $_GET['controller'] ?? 'home';
$method     = $_GET['method'] ?? 'index';

$router = new Router();
$router->routeContorler($controller, $method);
?>