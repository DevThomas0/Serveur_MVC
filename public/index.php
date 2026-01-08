<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\RouteDispatcher;
use Mini\Core\AuthenticationMiddleware;

$routes = [
 ['GET', '/', [Mini\Controllers\CatalogPageController::class, 'index'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/produit/{id}', [Mini\Controllers\CatalogPageController::class, 'show'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/add', [Mini\Controllers\CatalogPageController::class, 'add'], [AuthenticationMiddleware::class, 'handle']],
 ['POST', '/add', [Mini\Controllers\CatalogPageController::class, 'add'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/users', [Mini\Controllers\CatalogPageController::class, 'users'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/panier', [Mini\Controllers\ShoppingCartPageController::class, 'show'], [AuthenticationMiddleware::class, 'handle']],
 ['POST', '/panier/add', [Mini\Controllers\ShoppingCartPageController::class, 'add'], [AuthenticationMiddleware::class, 'handle']],
 ['POST', '/panier/remove', [Mini\Controllers\ShoppingCartPageController::class, 'remove'], [AuthenticationMiddleware::class, 'handle']],
 ['POST', '/panier/checkout', [Mini\Controllers\ShoppingCartPageController::class, 'checkout'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/commandes', [Mini\Controllers\ShoppingCartPageController::class, 'orders'], [AuthenticationMiddleware::class, 'handle']],
 ['GET', '/login', [Mini\Controllers\AuthenticationController::class, 'login']],
 ['POST', '/login', [Mini\Controllers\AuthenticationController::class, 'login']],
 ['GET', '/register', [Mini\Controllers\AuthenticationController::class, 'register']],
 ['POST', '/register', [Mini\Controllers\AuthenticationController::class, 'register']],
 ['GET', '/logout', [Mini\Controllers\AuthenticationController::class, 'logout']],
];

$router = new RouteDispatcher($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
