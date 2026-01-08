<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Cart;
use Mini\Models\Catalogue;
use Mini\Models\Commande;

final class CartController extends Controller
{
    private Catalogue $catalogue;
    private Cart $cart;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->catalogue = Catalogue::fromSession();
        $this->catalogue->seedDefaultsIfEmpty();
        $this->cart = Cart::fromSession();
    }

    public function show(): void
    {
        $this->render('home/cart', params: [
            'title' => 'Mon panier',
            'cart' => $this->cart,
            'catalogue' => $this->catalogue,
        ]);
    }

    public function add(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $qty = (int) ($_POST['qty'] ?? 1);

        if ($id > 0 && $this->catalogue->findById($id)) {
            $this->cart->addProduct($id, max(1, $qty));
            $this->cart->toSession();
        }
        header('Location: /panier');
        exit;
    }

    public function remove(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $this->cart->removeProduct($id);
            $this->cart->toSession();
        }
        header('Location: /panier');
        exit;
    }

    public function checkout(): void
    {
        $lines = $this->cart->detailedLines($this->catalogue);
        if (empty($lines)) {
            header('Location: /panier');
            exit;
        }

        $lignesCommande = [];
        foreach ($lines as $line) {
            $product = $line['product'];
            $lignesCommande[] = [
                'nom' => $product->getNom(),
                'prix' => $product->getPrix(),
                'qty' => $line['qty'],
                'total' => $line['total'],
            ];
        }

        $orders = $_SESSION['orders'] ?? [];
        $nextId = empty($orders) ? 1 : (max(array_map(static fn($o) => $o['id'], $orders)) + 1);
        $commande = new Commande($nextId, $lignesCommande, $this->cart->total($this->catalogue), date('Y-m-d H:i'));
        $orders[] = [
            'id' => $commande->getId(),
            'lignes' => $commande->getLignes(),
            'total' => $commande->getTotal(),
            'date' => $commande->getDate(),
        ];

        $_SESSION['orders'] = $orders;
        $this->cart->clear();
        $this->cart->toSession();

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


