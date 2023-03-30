<?php
session_start();
require_once 'vendor/autoload.php';

use App\User\Exception\UserLoginException;
use App\User\User;
use App\Utils;

['email' => $email, 'password' => $password] = $_POST;

// Si email ou password est null, alors l'utilisation du formulaire n'est pas correcte
if ($email === null || $password === null) {
  Utils::redirect("index.php");
}

require_once 'db/pdo.php';

// Trouver l'utilisateur qui a l'email passé dans le formulaire
// Pour pouvoir ensuite récupérer son mot de passe
// et le comparer avec le mot de passe qui a été saisi dans le formulaire
try {
  $user = new User($pdo, $email, $password);
  // $session = new Session($user);
} catch (UserLoginException $e) {
  $_SESSION['flash'] = $e->getMessage();
  Utils::redirect('login.php');
} catch (PDOException $e) {
  $_SESSION['flash'] = $e->getCode() . "/" . $e->getMessage();
  Utils::redirect('login.php');
}

// Connexion
echo "Vous êtes connecté";
