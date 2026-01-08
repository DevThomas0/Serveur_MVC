<?php
declare(strict_types=1);
namespace Mini\Core;
class Controller
{
 // Rend une vue avec les paramètres passés
 // Utilise output buffering pour capturer le contenu avant de l'injecter dans le layout
 // TODO: gérer les erreurs si la vue existe pas
 protected function render(string $view, array $params = []): void
 {
  extract(array: $params);
  $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
  $layoutFile = dirname(__DIR__) . '/Views/layout.php';

  ob_start();
  require $viewFile;

  $content = ob_get_clean();

  // On passe l'info d'auth au layout pour afficher le menu
  $auth = $_SESSION['auth'] ?? null;

  require $layoutFile;
 }
}
