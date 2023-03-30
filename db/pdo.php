<?php
// Chargement des variables d'environnement
require_once 'vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

// Me connecter à la base de données
// Docker avec Windows : host.docker.internal
// Docker avec système Unix : 172.17.0.1
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

//TODO: PDOException
$pdo = new PDO($dsn, $dbUser, $dbPassword, $pdoOptions);
