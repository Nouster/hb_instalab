<?php
require_once 'vendor/autoload.php';

use App\Session\Session;
use App\User\Exception\UserLoginException;
use App\User\User;
use App\Utils;

['email' => $email, 'password' => $password] = $_POST;

// Si email ou password est null, alors l'utilisation du formulaire n'est pas correcte
if ($email === null || $password === null) {
  Utils::redirect("index.php");
}

require_once 'db/pdo.php';
$session = new Session();

// Trouver l'utilisateur qui a l'email passé dans le formulaire
// Pour pouvoir ensuite récupérer son mot de passe
// et le comparer avec le mot de passe qui a été saisi dans le formulaire
try {
  $user = new User($pdo, $email, $password);
  $session->setUser($user);
  // Connexion
  echo "Vous êtes connecté";
} catch (UserLoginException $e) {
  $session->addFlash($e->getMessage());
  Utils::redirect('login.php');
} catch (PDOException $e) {
  $session->addFlash($e->getCode() . "/" . $e->getMessage());
  Utils::redirect('login.php');
}
