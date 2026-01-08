<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;

final class AuthenticationController extends Controller
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
   $username = trim($_POST['username'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $password = $_POST['password'] ?? '';
   $confirm = $_POST['confirm'] ?? '';

   // Validation basique des champs
   if ($username === '' || $email === '' || $password === '' || $password !== $confirm) {
    $this->render('auth/register', params: [
     'title' => 'Inscription',
     'error' => 'Tous les champs sont requis et les mots de passe doivent correspondre.',
     'old' => ['username' => $username, 'email' => $email],
    ]);
    return;
   }

   // On essaie de créer l'utilisateur, si ça échoue c'est que l'email exist déjà
   if (!\Mini\Models\User::createUser($username, $email, $password)) {
    $this->render('auth/register', params: [
     'title' => 'Inscription',
     'error' => 'Cet email est déjà utilisé.',
     'old' => ['username' => $username, 'email' => $email],
    ]);
    return;
   }

   // Si tout est bon, on récupere l'utilisateur créé et on le connecte direct
   $user = \Mini\Models\User::findByEmail($email);
   $_SESSION['auth'] = [
    'id' => $user['id_user'],
    'email' => $user['email'],
    'username' => $user['username'],
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

   if ($email === '' || $password === '') {
    $this->render('auth/login', params: [
     'title' => 'Connexion',
     'error' => 'Email et mot de passe requis.',
     'old' => ['email' => $email],
    ]);
    return;
   }

   $user = \Mini\Models\User::findByEmail($email);

   // On verifie que l'utilisateur existe et que le mot de passe est bon
   if (!$user || !password_verify($password, $user['pwd'])) {
    $this->render('auth/login', params: [
     'title' => 'Connexion',
     'error' => 'Identifiants invalides.',
     'old' => ['email' => $email],
    ]);
    return;
   }

   $_SESSION['auth'] = [
    'id' => $user['id_user'],
    'email' => $user['email'],
    'username' => $user['username'],
   ];

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
