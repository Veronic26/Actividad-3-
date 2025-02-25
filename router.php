<?php
class Router {
    private $routes = [
        '/' => 'HomeController@index',
        'libros' => 'LibroController@index',
        'autores' => 'AutorController@index',
    ];

    public function route($url) {
        $url = rtrim($url, '/');
        if ($url === '') {
            $url = '/';
        }

        if (array_key_exists($url, $this->routes)) {
            list($controller, $method) = explode('@', $this->routes[$url]);
            require_once "controllers/$controller.php";
            $controllerInstance = new $controller();
            $controllerInstance->$method();
            return;
        }

        $urlParts = explode('/', $url);
        if ($urlParts[0] === 'autores' && isset($urlParts[1])) {
            require_once "controllers/AutorController.php";
            $controllerInstance = new AutorController();

            switch ($urlParts[1]) {
                case 'store':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controllerInstance->store();
                    } else {
                        echo "Método no permitido";
                    }
                    break;
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($urlParts[2])) {
                        $controllerInstance->update($urlParts[2]);
                    } else {
                        echo "Método no permitido o ID no proporcionado";
                    }
                    break;
                case 'delete':
                    if (isset($urlParts[2])) {
                        $controllerInstance->delete($urlParts[2]);
                    } else {
                        echo "ID no proporcionado";
                    }
                    break;
                default:
                    echo "Acción no encontrada";
                    break;
            }
        } elseif ($urlParts[0] === 'libros' && isset($urlParts[1])) {
            require_once "controllers/LibroController.php";
            $controllerInstance = new LibroController();

            switch ($urlParts[1]) {
                case 'store':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controllerInstance->store();
                    } else {
                        echo "Método no permitido";
                    }
                    break;
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($urlParts[2])) {
                        $controllerInstance->update($urlParts[2]);
                    } else {
                        echo "Método no permitido o ID no proporcionado";
                    }
                    break;
                case 'delete':
                    if (isset($urlParts[2])) {
                        $controllerInstance->delete($urlParts[2]);
                    } else {
                        echo "ID no proporcionado";
                    }
                    break;
                default:
                    echo "Acción no encontrada";
                    break;
            }
        } else {
            echo "Página no encontrada";
        }
    }
}
?>


