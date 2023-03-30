<?php

namespace App\Session;

use App\User\User;

class Session
{
  public function __construct()
  {
    session_start();
  }

  public function isConnected(): bool
  {
    return isset($_SESSION['user']);
  }

  public function setUser(User $user): self
  {
    $_SESSION['user'] = $user->getEmail();

    return $this;
  }

  public function addFlash(string $message): void
  {
    $_SESSION['flash'] = $message;
  }

  public function hasFlash(): bool
  {
    return array_key_exists('flash', $_SESSION);
  }

  public function consumeFlash(): string
  {
    if (!$this->hasFlash()) {
      return '';
    }
    $message = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $message;
  }
}
