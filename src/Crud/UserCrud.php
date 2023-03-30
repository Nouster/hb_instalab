<?php

namespace App\Crud;

use App\User\UserRegister;
use PDO;
use PDOException;

// Create / Read / Update / Delete
class UserCrud
{
  public function __construct(private PDO $pdo)
  {
  }

  public function create(UserRegister $user)
  {
    $query = "INSERT INTO users VALUES(null, :email, :pass)";
    $stmt = $this->pdo->prepare($query);
    // Exécuter la requête préparée en lui fournissant les valeurs des paramètres de requête
    $stmt->execute([
      'email' => $user->getEmail(),
      'pass' => password_hash($user->getPassword(), PASSWORD_BCRYPT)
    ]);
  }

  public function list(): array
  {
    return [];
  }

  public function update(int $id, array $data)
  {
  }

  public function delete(int $id)
  {
  }
}
