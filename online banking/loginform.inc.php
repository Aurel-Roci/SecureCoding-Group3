<?php 
 
if(isset($_POST['username']) && isset($_POST['password'])){ 
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(!empty($username)&&!empty($password)){ //check if empty fields
		$query = "SELECT approve, UserID FROM users WHERE username='".mysql_real_escape_string($username)."' AND password='".mysql_real_escape_string($password)."'"; 
		
		if($result = mysql_query($query)){ 
			$num=mysql_num_rows($result);	 
			if($num==0){ 
				echo 'Invalid credentials';
			} else if ($num==1){ 
				
				while($row = mysql_fetch_assoc($result)) {
					if($row['approve']==1){ // check if account approved
						//echo $row['approve'];
						$user_id = mysql_result($result,0,'UserID') ; //retrive userID for the session
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