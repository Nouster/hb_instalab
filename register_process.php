<?php

// Chargement des variables d'environnement
require_once 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/.env');

['email' => $email, 'password' => $password] = $_POST;

// Si email ou password est null, alors l'utilisation du formulaire n'est pas correcte
if ($email === null || $password === null) {
  header('Location: index.php');
  exit;
}

// Si je me retrouve à cet endroit, alors je n'ai pas redirigé
// Donc je ne suis pas rentré dans le "if" ci-dessus
// Mes variables $email et $password ont correctement été assignées.
// Me connecter à la base de données
// Docker avec Windows : host.docker.internal
// Docker avec système Unix : 172.17.0.1
// TODO: Externaliser la configuration
$dbHost     = $_ENV['DB_HOST'];
$dbPort     = $_ENV['DB_PORT'];
$dbName     = $_ENV['DB_NAME'];
$dbUser     = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PASSWORD'];

$dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8";

$pdoOptions = [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

$pdo = new PDO($dsn, $dbUser, $dbPassword, $pdoOptions);

// Préparer une requête pour inscrire l'utilisateur
// Déclarer 2 paramètres de requête : email & pass
$query = "INSERT INTO users VALUES(null, :email, :pass)";
try {
  $stmt = $pdo->prepare($query);
  // Exécuter la requête préparée en lui fournissant les valeurs des paramètres de requête
  $stmt->execute([
    'email' => $email,
    'pass' => password_hash($password, PASSWORD_BCRYPT)
  ]);
} catch (PDOException $e) {
  // TODO: Gestion d'erreurs
  echo "Une erreur est survenue lors de l'enregistrement : " . $e->getCode() . " / " . $e->getMessage();
  exit;
}

echo "L'utilisateur a bien été enregistré";
