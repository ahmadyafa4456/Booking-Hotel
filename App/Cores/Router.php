<?php
namespace App\Cores;

class Router
{
    public static array $routes = [];

    public static function add(string $method, string $path, string $controller, string $function, array $middleware = [])
    {
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "function" => $function,
            "middleware" => $middleware,
        ];
    }

    public static function run()
    {
        $path = "/";
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }
        $method = $_SERVER['REQUEST_METHOD'];
        foreach (self::$routes as $route) {
            $pattern = "#^" . self::builderPattern($route['path']) . "$#";
            if (preg_match($pattern, $path, $variable) && $method == $route['method']) {
                foreach ($route['middleware'] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }
                $function = $route['function'];
                $controller = new $route['controller'];
                array_shift($variable);
                call_user_func_array([$controller, $function], $variable);
                return;
            }
        }
        http_response_code(404);
        echo "NOT FOUND";
    }

    public static function builderPattern(string $path)
    {
        return preg_replace('/(:\w+)/', '(\w+)', $path);
    }
}