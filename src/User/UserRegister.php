<?php

namespace App\User;

use App\User\Exception\UserRegisterException;

class UserRegister
{
  public function __construct(
    private string $email,
    private string $password
  ) {
    if (!$this->emailIsValid()) {
      throw new UserRegisterException("L'email est invalide");
    }
    if (!$this->passwordIsValid()) {
      throw new UserRegisterException("Le mot de passe doit faire au minimum 8 caractères");
    }
  }

  private function emailIsValid(): bool
  {
    return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
  }

  private function passwordIsValid(): bool
  {
    return mb_strlen($this->password) >= 8;
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
