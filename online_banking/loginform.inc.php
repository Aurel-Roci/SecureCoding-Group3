<?php

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(!empty($username)&&!empty($password)){ //check if empty fields
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

<form action="<?php echo $current_file; ?>" method="POST">
Username: <input type="text" name="username">
Password: <input type="password" name="password">
<input type="submit" value="Log in">
</form>
