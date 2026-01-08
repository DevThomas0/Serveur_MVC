<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

$routes = [
    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],
    ['GET', '/add', [Mini\Controllers\HomeController::class, 'add']],
    ['POST', '/add', [Mini\Controllers\HomeController::class, 'add']],
    ['GET', '/users', [Mini\Controllers\HomeController::class, 'users']],
    ['GET', '/panier', [Mini\Controllers\CartController::class, 'show']],
    ['POST', '/panier/add', [Mini\Controllers\CartController::class, 'add']],
    ['POST', '/panier/remove', [Mini\Controllers\CartController::class, 'remove']],
    ['POST', '/panier/checkout', [Mini\Controllers\CartController::class, 'checkout']],
    ['GET', '/commandes', [Mini\Controllers\CartController::class, 'orders']],
    ['GET', '/login', [Mini\Controllers\AuthController::class, 'login']],
    ['POST', '/login', [Mini\Controllers\AuthController::class, 'login']],
    ['GET', '/register', [Mini\Controllers\AuthController::class, 'register']],
    ['POST', '/register', [Mini\Controllers\AuthController::class, 'register']],
    ['GET', '/logout', [Mini\Controllers\AuthController::class, 'logout']],
];

$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);


