<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $employee_page = strpos($_SERVER['REQUEST_URI'], '/employee.php') !== false;

  $user = getUser();
  if (!isset($user)) {
    redirect("index.php");
  }
  if ($user->isEmployee() && !$employee_page) {
    redirect("employee.php");
  }
  if (!$user->isEmployee() && $employee_page) {
    redirect("index.php");
  }

?>
