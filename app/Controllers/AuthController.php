<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

final class AuthController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($email === '' || $password === '' || $password !== $confirm) {
                $this->render('auth/register', params: [
                    'title' => 'Inscription',
                    'error' => 'Email et mot de passe requis (confirmation identique).',
                    'old' => ['email' => $email],
                ]);
                return;
            }

            $_SESSION['user'] = [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            header('Location: /');
            exit;
        }

        $this->render('auth/register', params: [
            'title' => 'Inscription',
        ]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $_SESSION['user'] ?? null;
            if (!$user || $email === '' || $password === '' || !password_verify($password, $user['password'])) {
                $this->render('auth/login', params: [
                    'title' => 'Connexion',
                    'error' => 'Identifiants invalides.',
                    'old' => ['email' => $email],
                ]);
                return;
            }

            $_SESSION['auth'] = ['email' => $user['email']];
            header('Location: /');
            exit;
        }

        $this->render('auth/login', params: [
            'title' => 'Connexion',
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['auth']);
        header('Location: /');
        exit;
    }
}


