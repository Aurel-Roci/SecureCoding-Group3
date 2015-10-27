<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'models/user.php';

require 'core.inc.php';
require 'connect.inc.php';

$error = "";
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if($post) {
	$allPramatetersSet = isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_again']) &&
		isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']);
	if($allPramatetersSet) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$memberrole = $_POST['memberrole'];
		$email = $_POST['email'];


		if(!empty($username) && !empty($password) && !empty($password_again) && !empty($firstname) && !empty($lastname) && !empty($email)) {
			$query = "SELECT username FROM users WHERE username='".mysql_real_escape_string($username)."'";
			$query_run=mysql_query($query);
			if(mysql_num_rows($query_run) > 0) {
				$error = "The username ".$username." already exists";
			} else {
				$query = "INSERT INTO users (username,password,approved,memberrole,firstname,lastname,email) "
							 . "VALUES ('".mysql_real_escape_string($username)."', SHA2('".mysql_real_escape_string($password)
				 		 	 . "', 256), False,".$memberrole.",'".mysql_real_escape_string($firstname)."','"
				 		 	 . mysql_real_escape_string($lastname)."','".mysql_real_escape_string($email)."')";

				if($query_run = mysql_query($query)) {
					$query = "SELECT id FROM users WHERE username='".mysql_real_escape_string($username)."'";
					$result = mysql_query($query);
					$user_id = mysql_result($result, 0);

					$tans = "";
					for ($i = 0; $i <+ 100; $i++) {
						$rand = generateRandomString(15);
						$query = "INSERT INTO tans VALUES('".$rand."','".$user_id."')";
						if($query_run = mysql_query($query)) {
							$tans .= $rand."\n";
						} else {
							$error = "Failed generating tans";
						}
					}

					$message = "Dear ".$lastname.",
						for your new online banking account we send you your TAN codes:
						".$tans."\nBest regards,\nYour online banking team";
					$headers = "From: info@team3securecoding.com\n";
					$headers .= "Reply-To: info@team3securecoding.com";
					$mailing = mail($email, "TAN Codes", $message, $headers);
					error_log("Mail success: ".$mailing);
				} else {
					$error = "Could not register at this time. Try again later";
				}
			}
		} else {
			$error = "Please fill in all fields!";
		}
	}
}
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
		<div class="topbar">
			<div class="topbarcontent">
				<div class="center">
					<span style="position: absolute; top: 25%; margin-top: 0px;">
						<b>
							<a href="index.php">Online Banking</a>
						</b>
						<span style="color: #888;"></span>
						<span style="font-size: 12pt;">
							<span class="glyphicon glyphicon-menu-right"></span>
							<a href="register.php">Register</a>
						</span>
					</span>
				</div>
			</div>
		</div>

		<div class="container">
			<?php
			if($post && !empty($error)) {
				echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
			} else if ($post && empty($error)) {
				echo '<div class="alert alert-success" role="alert">Registration was successful.</div>';
			}
			?>
			<form class="form-horizontal" id="register-form" action='register.php' method="POST" onsubmit="return validateFields(this);">
				<fieldset>
					<div id="legend">
						<legend class="">Register</legend>
					</div>
					<div class="control-group">
						<!-- Username -->
						<label class="control-label" for="username">Username</label>
						<div class="controls">
							<input type="text" id="username" name="username" placeholder="user" class="form-control input-normal">
							<p class="help-block">Username can contain any letters or numbers, without spaces</p>
						</div>
					</div>
					<div class="control-group">
						<!-- E-mail -->
						<label class="control-label" for="email">E-mail</label>
						<div class="controls">
							<input type="text" id="email" name="email" placeholder="user@domain.com" class="form-control">
							<p class="help-block">Please provide your E-mail</p>
						</div>
					</div>
					<div class="control-group">
						<!-- Password-->
						<label class="control-label" for="password">Password</label>
						<div class="controls">
							<input type="password" id="password" name="password" placeholder="********" class="form-control">
							<p class="help-block">Password should be at least 4 characters</p>
						</div>
					</div>
					<div class="control-group">
						<!-- Password -->
						<label class="control-label" for="password_again">Password (Confirm)</label>
						<div class="controls">
							<input type="password" id="password_again" name="password_again" placeholder="********" class="form-control">
							<p class="help-block">Please confirm password</p>
						</div>
					</div>
					<div class="control-group">
						<!-- First name -->
						<label class="control-label" for="firstname">First name</label>
						<div class="controls">
							<input type="text" id="firstname" name="firstname" placeholder="Max" class="form-control" style="width = 50% !important">
							<p class="help-block">Please provide your first name</p>
						</div>
					</div>
					<div class="control-group">
						<!-- Last name -->
						<label class="control-label" for="lastname">Last name</label>
						<div class="controls">
							<input type="text" id="lastname" name="lastname" placeholder="Mustermann" class="form-control">
							<p class="help-block">Please provide your last name</p>
						</div>
					</div>
					<div class="control-group">
						<!-- Member role -->
						<label class="control-label" for="memberrole">Employee</label>
						<div class="controls">
							<select name="memberrole" class="form-control" >
								<option value="0">Customer</option>
								<option value="1">Employee</option>
							</select>
							<p class="help-block">Are you an employee or a normal customer?</p>
						</div>
					</div>
					<div class="control-group">
						<!-- Button -->
						<div class="controls">
							<button class="btn btn-primary btn-lg" style="width: 100%;">Register</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			function validateEmail(email) {
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				return re.test(email);
			}

			function validateFields(form) {
				if (form.password.value !== form.password_again.value) {
					alert("The two passwords are not the same.");
					return false;
				}

				if (!validateEmail(form.email.value)) {
					alert("This is not a valid email address.");
					return false;
				}

				return true;
			}
		</script>
  </body>
</html>
