<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require 'models/user.php';
  require 'models/transaction.php';

  require 'core.inc.php';
  require 'connect.inc.php';

  $isOnIndexPage = strpos($_SERVER['REQUEST_URI'], '/index.php') !== false;
  $isOnRegisterPage = strpos($_SERVER['REQUEST_URI'], '/register.php') !== false;
  $isOnEmployeePage = strpos($_SERVER['REQUEST_URI'], '/employee.php') !== false;

  if (!isLoggedIn()) {
    if (!$isOnIndexPage && !$isOnRegisterPage) {
      redirect("index.php");
    }
  } else {
    $user = getUser();
    if ($user->isEmployee() && !$isOnEmployeePage) {
      redirect("employee.php");
    } else if (!$user->isEmployee() && $isOnEmployeePage) {
      redirect("index.php");
    }
  }

?>
