<?php
declare(strict_types=1);
namespace Mini\Core;
final class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($method === $routeMethod && $path === $routePath) {
                [$class, $action] = $handler;
                $controller = new $class();
                $controller->$action();
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}


