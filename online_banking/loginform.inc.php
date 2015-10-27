<div class="container">
  <h1>Login</h1>
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

<?php

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(!empty($username) &&! empty($password)){ //check if empty fields
		$query = "SELECT approved, id FROM users WHERE username='".mysql_real_escape_string($username)."' AND password=SHA2('".mysql_real_escape_string($password)."', 256)";

		if($result = mysql_query($query)){
			$num=mysql_num_rows($result);
			if($num==0){
				echo 'Invalid credentials';
			} else if ($num==1){

				while($row = mysql_fetch_assoc($result)) {
					if($row['approved']!=0){ // check if account approved (everything except 0 is true)
						//echo $row['approve'];
						$user_id = mysql_result($result,0,'id') ; //retrive userID for the session
						$_SESSION['user_id'] = $user_id;
						header('Location: index.php');
					} else {
						echo "Account not approved!";
					}
				}
			}
		}
	} else {
		echo 'Enter username and password';
	}
}
?>
