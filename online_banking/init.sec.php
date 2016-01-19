<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(0);

  require 'models/user.php';
  require 'models/transaction.php';

  require 'core.inc.php';
  require 'connect.inc.php';

  $isOnIndexPage = strpos($_SERVER['REQUEST_URI'], '/index.php') !== false;
  $isOnRegisterPage = strpos($_SERVER['REQUEST_URI'], '/register.php') !== false;
  $isOnEmployeePage = strpos($_SERVER['REQUEST_URI'], '/employee.php') !== false;
  $isOnPasswordResetPage = strpos($_SERVER['REQUEST_URI'], '/passwordReset.php') !== false;

  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
      // last request was more than 30 minutes ago
      session_unset();     // unset $_SESSION variable for the run-time
      session_destroy();   // destroy session data in storage
  }

  $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

  if (!isLoggedIn()) {
    if (!$isOnIndexPage && !$isOnRegisterPage && !$isOnPasswordResetPage) {
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

<style id="antiClickjack">body{display:none !important;}</style>
<script type="text/javascript">
   if (self === top) {
       var antiClickjack = document.getElementById("antiClickjack");
       antiClickjack.parentNode.removeChild(antiClickjack);
   } else {
       top.location = self.location;
   }
</script>
