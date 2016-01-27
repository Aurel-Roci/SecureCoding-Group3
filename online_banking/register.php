<?php
require 'init.sec.php';
require 'register.inc.php';

$c = new \Csrf\CsrfToken();
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
        $extraMessage = "";
        if ($tan_method == 1) {
          $extraMessage = "<a href='applicationDownload.php?user_id=" . $user_id . "' target='_blank'>Download application!</a> Use your PIN: ". $pin . "<br>";
        }
				echo '<div class="alert alert-success" role="alert">Registration was successful. ' . $extraMessage .' <a href="index.php">Login now</a></div>';
			}
			?>
			<form class="form-horizontal" id="register-form" action='register.php' method="POST" onsubmit="return validateFields(this);" autocomplete="off">
        <?php echo $c->generateHiddenField(); ?>
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
							<p class="help-block">Password must be minimum 8 characters at least 1 Uppercase letter, 1 Lowercase letter and 1 Number</p>
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
							<select id="opts" name="memberrole" class="form-control" onchange="showForm()">
								<option value="0">Customer</option>
								<option value="1">Employee</option>
							</select>
							<p class="help-block">Are you an employee or a normal customer?</p>
						</div>
          </div>
          <div class="control-group">
            <!-- Tan method -->
            <label class="control-label" for="tanMethod">TAN Method</label>
            <div id="cust" class="controls">
							<select id="opts" name="tanMethod" class="form-control" >
								<option value="0">Email</option>
								<option value="1">Application</option>
							</select>
							<p class="help-block">Receive tans by email or an application?</p>
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

      function showForm() {
          var selopt = document.getElementById("opts").value;
          if (selopt == 0) {
              document.getElementById("cust").style.display = "block";
          }
          if (selopt == 1) {
              document.getElementById("cust").style.display = "none";
          }
      }
			function validateEmail(email) {
				var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
				return re.test(email);
			}

      function validatePassword(password){
        var re = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/i;
        return re.test(password);
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
