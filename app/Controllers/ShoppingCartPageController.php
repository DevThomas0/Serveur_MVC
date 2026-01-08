<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ShoppingCartManager;
use Mini\Models\ProductCatalogeManager;
use Mini\Models\OrderRecord;

final class ShoppingCartPageController extends Controller
{
 private ProductCatalogeManager $catalogManager;
 private ShoppingCartManager $cartManager;

 public function __construct()
 {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
   $this->catalogManager = ProductCatalogeManager::loadFromSession();
  $this->catalogManager->initializeDefaultProductsIfEmpty();
  $this->cartManager = ShoppingCartManager::loadFromSession();
 }

 public function show(): void
 {
  $this->render('home/cart', params: [
   'title' => 'Mon panier',
   'cart' => $this->cartManager,
   'catalogue' => $this->catalogManager,
  ]);
 }

 public function add(): void
 {
  $id = (int) ($_POST['id'] ?? 0);
  $qty = (int) ($_POST['qty'] ?? 1);

  // On verifie que le produit existe avant de l'ajouter
  if ($id > 0 && $this->catalogManager->findProductById($id)) {
   $this->cartManager->addProductToCart($id, max(1, $qty));
   $this->cartManager->saveToSession();
  }
  header('Location: /panier');
  exit;
 }

 public function remove(): void
 {
  $id = (int) ($_POST['id'] ?? 0);
  if ($id > 0) {
   $this->cartManager->removeProductFromCart($id);
   $this->cartManager->saveToSession();
  }
  header('Location: /panier');
  exit;
 }

 // Valide la commande et crée un OrderRecord
 public function checkout(): void
 {
  $lines = $this->cartManager->getDetailedCartLines($this->catalogManager);
  if (empty($lines)) {
   // Panier vide, on redirige
   header('Location: /panier');
   exit;
  }

  // On prepare les lignes de commande avec les infos qu'on veut garder
  $lignesCommande = [];
  foreach ($lines as $line) {
   $product = $line['product'];
   $lignesCommande[] = [
    'nom' => $product->getProductName(),
    'prix' => $product->getProductPrice(),
    'qty' => $line['qty'],
    'total' => $line['total'],
   ];
  }

  // On récupere les commandes existantes et on genere un nouvel ID
  $orders = $_SESSION['orders'] ?? [];
  $nextId = empty($orders) ? 1 : (max(array_map(static fn($o) => $o['id'], $orders)) + 1);
  
  $totalCommande = $this->cartManager->calculateTotalAmount($this->catalogManager);
  $commande = new OrderRecord($nextId, $lignesCommande, $totalCommande, date('Y-m-d H:i'));
  
  // On stock la commande dans la session
  $orders[] = [
   'id' => $commande->getOrderId(),
   'lignes' => $commande->getOrderLines(),
   'total' => $commande->getOrderTotal(),
   'date' => $commande->getOrderDate(),
  ];

  $_SESSION['orders'] = $orders;
  $this->cartManager->clearCart();
  $this->cartManager->saveToSession();

  header('Location: /commandes');
  exit;
 }

 public function orders(): void
 {
  $orders = $_SESSION['orders'] ?? [];
  $this->render('home/orders', params: [
   'title' => 'Mes commandes',
   'orders' => $orders,
  ]);
 }
}
