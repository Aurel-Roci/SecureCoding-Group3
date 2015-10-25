<?php
require 'core.inc.php';
require 'connect.inc.php';

if(!loggedin()){
	if(isset($_POST['username'])&&
	isset($_POST['password'])&&
	isset($_POST['password_again'])&&
	isset($_POST['firstname'])&&
	isset($_POST['lastname'])&&
	isset($_POST['email'])
	)
	{
	    $username=$_POST['username'];
		$password=$_POST['password'];
		$password_again=$_POST['password_again'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$memberrole=$_POST['memberrole'];
		$email=$_POST['email'];
		if(!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($firstname)&&!empty($lastname)&&!empty($email)){
			$query = "SELECT username FROM users WHERE username='".mysql_real_escape_string($username)."'";
			$query_run=mysql_query($query);
			if(mysql_num_rows($query_run)==1){
				echo 'The username '.$username.' already exists';
			} else {
				$query = "INSERT INTO users (username,password,approved,memberrole,firstname,lastname,email) ";
				$query .= "VALUES ('".mysql_real_escape_string($username)."', SHA2('".mysql_real_escape_string($password);
				$query .= "', 256), False,".$memberrole.",'".mysql_real_escape_string($firstname)."','";
				$query .= mysql_real_escape_string($lastname)."','".mysql_real_escape_string($email)."')";
				if($query_run=mysql_query($query)){
					$query = "SELECT id FROM users WHERE username='".mysql_real_escape_string($username)."'";
					$result = mysql_query($query);
					$user_id = mysql_result($result, 0);
					$tans = "";
					for ($i = 0; $i <+ 100; $i++) {
						$rand = generateRandomString(15);
						$query = "INSERT INTO tans VALUES('".$rand."','".$user_id."')";
						if($query_run=mysql_query($query)){
							$tans .= $rand."\n";
						} else {
							//something went wrong
							echo "Failed";
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
					echo 'Could not register at this time. Try again later';
				}
			}
		} else {
			 echo 'Please fill in all fields!';
		}
}
?>
<form action = "register.php" method = "POST" id="register-form">
	Username: <br> <input type="text" name="username"><br>
	Password: <br> <input type="password" name="password"><br>
	Password again:<br> <input type="password" name="password_again"><br>
	First Name: <br> <input type="text" name="firstname"><br>
	Last Name: <br> <input type="text" name="lastname"><br>
	Email: <br> <input type="email" name="email"><br>
	User:   <br>
	<select name='memberrole'>
	  <option value="0">Customer</option>
	  <option value="1">Employee</option>
	</select>
	<br>
	<input type="submit" value="register">
</form>
<script type="text/javascript">

	var  function validateEmail (email) {
		var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		return re.test(email);
	}
	document.getElementById("register-form").submit(function(ev) {
		ev.preventDefault(); // stop submitting
		if (this.password !== this.password_again) {
			// add error message
			return;
		}

		if (!validateEmail(this.email)){
			// add error message
			return;
		}
		this.submit(); //validation succeeded
	})
</script>
<?php
} else if(loggedin()){
	session_destroy();
}

?>
