<?php
declare(strict_types=1);
namespace Mini\Core;
final class RouteDispatcher
{
 private array $routeTable;

 public function __construct(array $routeTable)
 {
  $this->routeTable = $routeTable;
 }

 // Dispatch la requete vers le bon contrôleur selon la route
 public function dispatch(string $method, string $uri): void
 {
  $path = parse_url($uri, PHP_URL_PATH) ?? '';

  foreach ($this->routeTable as $route) {
   $routeMethod = $route[0];
   $routePath = $route[1];
   $handler = $route[2];
   $middleware = $route[3] ?? null;

   // On gère les routes avec paramètres dynamiques comme {id}
   $matches = [];
   $pattern = preg_replace('/\{id\}/', '(\d+)', $routePath);
   $pattern = '#^' . $pattern . '$#';

   if ($method === $routeMethod && preg_match($pattern, $path, $matches)) {
    // On exécute le middleware si présent
    if ($middleware !== null && is_callable($middleware)) {
     $middleware();
    }

    // Si on a capturé un ID dans l'URL, on le met dans $_GET
    // TODO: gérer plusieurs paramètres dynamiques si besoin
    if (count($matches) > 1) {
     $_GET['id'] = (int)$matches[1];
    }

    [$class, $action] = $handler;
    $controller = new $class();
    $controller->$action();
    return;
   }
  }

  // Route pas trouvée, on renvoie un 404
  http_response_code(404);
  echo '404 Not Found';
 }
}
