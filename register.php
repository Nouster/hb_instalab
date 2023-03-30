<?php
require_once 'vendor/autoload.php';

use App\Session\Session;

$session = new Session();

require_once 'layout/header.php';
?>

<div class="container">
  <h1>Inscription</h1>

  <?php if ($session->hasFlash()) { ?>
    <div class="alert alert-danger">
      <?php echo $session->consumeFlash(); ?>
    </div>
  <?php } ?>

  <form action="register_process.php" method="post">
    <div class="form-floating mb-3">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>
    <button type="submit" class="btn btn-primary mt-4">Inscription</button>
  </form>
  <div class="mt-5">
    <a href="login.php">Connexion</a>
  </div>
</div>

<?php require_once 'layout/footer.php'; ?>