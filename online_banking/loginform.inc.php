<?php
  $post = $_SERVER['REQUEST_METHOD'] === 'POST';
  $c = new \Csrf\CsrfToken();

  if($post && $c->checkToken($timeout=300)) {
  	$username = $_POST['username'];
  	$password = $_POST['password'];

    if ($user = fetchUser($username, $password)) {
    	session_regenerate_id();
      $_SESSION['user'] = $user;
      header('Location: index.php');
    }
  }
?>

<div class="container">
  <h1>Login</h1>
  <?php
    if (isLoginBlocked($username)) {
      echo '<div class="alert alert-danger" role="alert">Too many failed login attempts. Your account has been blocked! Contact an employee to unblock your account!</div>';
    } else {
      if($post && empty($_SESSION['user'])) {
        echo '<div class="alert alert-danger" role="alert">Login error!</div>';
      }
      ?>
      <p>Please login with your user credentials below:</p>
      <form action="<?php echo $current_file; ?>" method="POST" autocomplete="off">
        <?php echo $c->generateHiddenField(); ?>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input class="form-control" name="username" placeholder="Username" type="text">
        </div>
        <div class="input-group" style="margin-top: 20px">
          <span class="input-group-addon" id="basic-addon1">P</span>
          <input class="form-control" name="password" placeholder="Password" type="password">
        </div>
        <button class="btn btn-primary" style="margin-top: 20px; width: 49%; float: left;" type="submit">Log in</button>
        <button class="btn btn-info" style="margin-top: 20px; width: 49%; float: right;" onclick="window.location = 'register.php'; return false;">Register</button>
        <br>
        <button class="btn btn-info" style="margin-top: 20px; width: 100%;" onclick="window.location = 'passwordReset.php'; return false;">Reset Password</button>
      </form>
      <?php
    }
  ?>
</div>
