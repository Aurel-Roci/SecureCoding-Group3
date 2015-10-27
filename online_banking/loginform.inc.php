<?php
  $post = $_SERVER['REQUEST_METHOD'] === 'POST';
  if($post) {
  	$username = $_POST['username'];
  	$password = $_POST['password'];

    if ($user = fetchUser($username, $password)) {
      $_SESSION['user'] = $user;
      header('Location: index.php');
    }
  }
?>

<div class="container">
  <h1>Login</h1>
  <?php
    if($post && empty($_SESSION['user'])) {
      echo '<div class="alert alert-danger" role="alert">Login error!</div>';
    }
  ?>
  <p>Please login with your user credentials below:</p>
  <form action="<?php echo $current_file; ?>" method="POST">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">@</span>
      <input class="form-control" name="username" placeholder="Username" type="text">
    </div>
    <div class="input-group" style="margin-top: 20px">
      <span class="input-group-addon" id="basic-addon1">P</span>
      <input class="form-control" name="password" placeholder="Password" type="password">
    </div>
		<button class="btn btn-default" style="margin-top: 20px" type="submit">Log in</button>
		<button class="btn btn-default" style="margin-top: 20px" onclick="window.location = 'register.php'; return false;">Register</button>
  </form>
</div>
