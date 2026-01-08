<?php

declare(strict_types=1);
namespace Mini\Controllers;
use Mini\Core\Controller;
use Mini\Models\Catalogue;
use Mini\Models\Produit;
use Mini\Models\ProduitAlimentaire;
use Mini\Models\User;

final class HomeController extends Controller
{
    private Catalogue $catalogue;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->catalogue = Catalogue::fromSession();
        $this->catalogue->seedDefaultsIfEmpty();
    }

    public function index(): void
    {
        $this->render('home/index', params: [
            'title' => 'Mini Catalogue POO',
            'catalogue' => $this->catalogue,
        ]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prix = (float) ($_POST['prix'] ?? 0);
            $expiration = trim($_POST['expiration'] ?? '');

            if ($nom === '' || $prix <= 0) {
                $this->render('home/add', params: [
                    'title' => 'Ajouter un produit',
                    'error' => 'Nom et prix sont obligatoires (prix > 0).',
                    'old' => ['nom' => $nom, 'prix' => $prix, 'expiration' => $expiration],
                ]);
                return;
            }

            $id = $this->catalogue->prochaineId();
            if ($expiration !== '') {
                $produit = new ProduitAlimentaire($id, $nom, $prix, $expiration);
            } else {
                $produit = new Produit($id, $nom, $prix);
            }

            $this->catalogue->ajouterProduit($produit);
            $this->catalogue->toSession();
            header('Location: /');
            exit;
        }

        $this->render('home/add', params: [
            'title' => 'Ajouter un produit',
        ]);
    }

    public function users(): void
    {
        $this->render('home/users', params: [
            'users' => $users = User::getAll(),
        ]);
    }
}