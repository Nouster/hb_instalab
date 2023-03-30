<?php
session_start();
require_once 'vendor/autoload.php';

use App\Crud\UserCrud;
use App\User\Exception\UserRegisterException;
use App\User\UserRegister;
use App\Utils;

['email' => $email, 'password' => $password] = $_POST;

// Si email ou password est null, alors l'utilisation du formulaire n'est pas correcte
if ($email === null || $password === null) {
  Utils::redirect('index.php');
}

// Si je me retrouve à cet endroit, alors je n'ai pas redirigé
// Donc je ne suis pas rentré dans le "if" ci-dessus
// Mes variables $email et $password ont correctement été assignées.
require_once 'db/pdo.php';

try {
  $newUser = new UserRegister($email, $password); // $email + $password
  $crud = new UserCrud($pdo);
  $crud->create($newUser);
} catch (UserRegisterException $e) {
  $_SESSION['flash'] = $e->getMessage();
} catch (PDOException $e) {
  $_SESSION['flash'] = $e->getCode() . " / " . $e->getMessage();
} finally {
  Utils::redirect('register.php');
}

echo "L'utilisateur a bien été enregistré";
