<?php
require_once 'vendor/autoload.php';

use App\Session\Session;

$session = new Session();

var_dump($session, $session->isConnected());
