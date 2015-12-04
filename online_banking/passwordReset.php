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
    <div class="container">
      <?php
      require 'passwordReset.inc.php';
      if (isset($error)) {
        echo '<div class="alert alert-warning" role="alert">' . $error . '</div>';
      } else if (isset($message)) {
        echo '<div class="alert alert-success" role="alert">' . $message . ' <a href="index.php">Login now</a></div>';
      }
      if (!$post && $idSet && !isset($error)) {
        ?>
        <form class="form-horizontal" id="passwordReset-form" action='passwordReset.php' method="POST" onsubmit="return validatePasswordFields(this);">
          <fieldset>
            <div id="legend">
              <legend class="">Password reset</legend>
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
              <!-- Button -->
              <div class="controls">
                <button class="btn btn-primary btn-lg" style="width: 100%;">Reset password</button>
              </div>
            </div>
          </fieldset>
          <input type="id" id="id" name="id" value="<?= $_GET['id'] ?>" style="display: none;">
        </form>
        <?php
      } else if ($post && $idSet) {
      } else {
        ?>
        <form class="form-horizontal" id="passwordReset-form" action='passwordReset.php' method="POST" onsubmit="return validateFields(this);">
          <fieldset>
            <div id="legend">
              <legend class="">Password reset</legend>
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
              <!-- Button -->
              <div class="controls">
                <button class="btn btn-primary btn-lg" style="width: 100%;">Reset password</button>
              </div>
            </div>
          </fieldset>
        </form>
      <?php } ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">

      function validateEmail(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
      }

      function validateFields(form) {
        if (!validateEmail(form.email.value)) {
          alert("This is not a valid email address.");
          return false;
        }

        return true;
      }

      function validatePassword(password) {
        var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i;
        return re.test(password);
      }

      function validatePasswordFields(form) {
        if (form.password.value !== form.password_again.value) {
          alert("The two passwords are not the same.");
          return false;
        }

        if (!validatePassword(form.password.value)) {
          alert("This is not a valid password. The password must have at least 8 characters containing at least 1 uppercase letter, 1 lowercase letter and 1 number");
          return false;
        }

        return true;
      }
    </script>

  </body>
  <?php include 'footer.inc.php'; ?>
</html>
