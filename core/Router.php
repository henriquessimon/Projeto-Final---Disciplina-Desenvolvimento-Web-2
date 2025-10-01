<?php
class Router {
    public function routeContorler($controller, $method) {
        $controllerName = ucfirst($controller) . 'Controller';
        $url = '../app/controller/' . $controllerName  . '.php';

        if(!file_exists($url)) die('Rota não encontrada');

        require_once $url;

        if(!class_exists($controllerName)) die('Class inexistente');

        $controllerObj = new $controllerName();

        if(!method_exists($controllerObj, $method)) die('Método não existe');

        $controllerObj->$method();
    }
}

$router = new Router();
$router->routeContorler($_GET['controller'], $_GET['method']);
?>