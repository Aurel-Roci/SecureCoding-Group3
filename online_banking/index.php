<?php
require 'init.sec.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Banking</title>

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
  </head>
  <body>
		<?php
			if(isset($_SESSION['user'])){
				$user = $_SESSION['user'];
				if($user->isEmployee()){
					redirect("employee.php");
				} else {
					redirect("customer.php");
				}
			} else {
				include 'loginform.inc.php'; //if not logged in go to login form
			}
		?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
