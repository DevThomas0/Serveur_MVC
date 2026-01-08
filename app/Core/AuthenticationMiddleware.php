<?php

declare(strict_types=1);

namespace Mini\Core;

// Middleware simple pour vérifier si l'utilisateur est connecté
// Si pas connecté, on redirige vers la page de login
class AuthenticationMiddleware
{
 public static function handle(): bool
 {
  if (session_status() === PHP_SESSION_NONE) {
   session_start();
  }

  if (!isset($_SESSION['auth'])) {
   header('Location: /login');
   exit;
  }

  return true;
 }
}
