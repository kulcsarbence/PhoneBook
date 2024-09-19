<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($method, $path, $controller)
    {
        $this->routes[] = compact('method', 'path', 'controller');
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($method == $route['method'] && $uri == $route['path']) {
                $controller = $route['controller'];
                return $controller();
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
