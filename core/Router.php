<?php
class Router {
    public function routeContorler($controller, $method) {
        $controllerName = ucfirst($controller) . 'Controller';
        $url = __DIR__ . '/../app/controller/' . $controllerName  . '.php';

        if(!file_exists($url)) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Rota não encontrada'
            ]);
            exit;
        }

        require_once $url;

        if(!class_exists($controllerName)) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Classe não encontrada'
            ]);
            exit;
        }

        $controllerObj = new $controllerName();

        if(!method_exists($controllerObj, $method)){
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Method não encontrado',
                'method'    => $method
            ]);
            exit;
        }

        $controllerObj->$method();
    }
}
?>