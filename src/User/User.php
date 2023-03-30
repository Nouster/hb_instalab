<?php

namespace App\User;

use App\User\Exception\UserLoginException;
use PDO;

class User
{
  public function __construct(
    PDO $pdo,
    private string $email,
    private string $password
  ) {
    $query = "SELECT pass FROM users WHERE email=:email";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);

    $passDatabase = $stmt->fetch(); // ['pass' => hash]

    if ($passDatabase === false) {
      throw new UserLoginException("L'email n'existe pas dans la base de données");
    }

    $hashedPassword = $passDatabase['pass'];

    if (password_verify($password, $hashedPassword) === false) {
      throw new UserLoginException("Le mot de passe est incorrect");
    }
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}
