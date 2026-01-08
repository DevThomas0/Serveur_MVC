<?php

declare(strict_types=1);
namespace Mini\Controllers;
use Mini\Core\Controller;
use Mini\Models\ProductCatalogeManager;
use Mini\Models\ProduitItem;
use Mini\Models\ProduitAlimentaireItem;
use Mini\Models\User;

final class CatalogPageController extends Controller
{
 private ProductCatalogeManager $catalogManager;

 public function __construct()
 {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

   $this->catalogManager = ProductCatalogeManager::loadFromSession();
  $this->catalogManager->initializeDefaultProductsIfEmpty();
 }

 public function index(): void
 {
  $this->render('home/index', params: [
   'title' => 'Mini Catalogue POO',
   'catalogue' => $this->catalogManager,
  ]);
 }

 public function add(): void
 {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $nom = trim($_POST['nom'] ?? '');
   $prix = (float) ($_POST['prix'] ?? 0);
   $expiration = trim($_POST['expiration'] ?? '');

   // Validation basique - on pourrait améliorer ça plus tard
   // TODO: ajouter plus de validations (caractères spéciaux, etc)
   if ($nom === '' || $prix <= 0) {
    $this->render('home/add', params: [
     'title' => 'Ajouter un produit',
     'error' => 'Nom et prix sont obligatoires (prix > 0).',
     'old' => ['nom' => $nom, 'prix' => $prix, 'expiration' => $expiration],
    ]);
    return;
   }

   $id = $this->catalogManager->getNextAvailableId();
   
   // Si y'a une date d'expiration, c'est un produit alimentaire
   if ($expiration !== '') {
    $produit = new ProduitAlimentaireItem($id, $nom, $prix, $expiration);
   } else {
    $produit = new ProduitItem($id, $nom, $prix);
   }

   $this->catalogManager->addProductItem($produit);
   $this->catalogManager->saveToSession();
   header('Location: /');
   exit;
  }

  $this->render('home/add', params: [
   'title' => 'Ajouter un produit',
  ]);
 }

 public function show(): void
 {
  $id = (int)($_GET['id'] ?? 0);
  $produit = $this->catalogManager->findProductById($id);

  // Si le produit existe pas, on renvoie un 404 simple
  // TODO: créer une vraie page 404 plus jolie
   if (!$produit) {
   http_response_code(404);
   echo 'Produit introuvable';
   return;
  }

  $this->render('home/show', params: [
   'title' => 'Détails du produit',
   'produit' => $produit,
   'catalogue' => $this->catalogManager,
  ]);
 }

 public function users(): void
 {
  $this->render('home/users', params: [
   'users' => $users = User::getAll(),
  ]);
 }
}
