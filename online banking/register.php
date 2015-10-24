<?php
require 'core.inc.php';
require 'connect.inc.php';
if(!loggedin()){
	
	if(isset($_POST['username'])&& isset($_POST['password'])&& isset($_POST['password_again'])&& isset($_POST['firstname'])&& isset($_POST['lastname'])&&isset($_POST['user'])&&isset($_POST['email'])){
	    $username=$_POST['username'];
		$password=$_POST['password'];
		$password_again=$_POST['password_again'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$status=$_POST['status'];
		$email=$_POST['email'];
		if(!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($firstname)&&!empty($lastname)&&!empty($email)){
			if($password!=$password_again){
				echo 'Passwords do not match';
			} else {
				
				$query = "SELECT username FROM users WHERE username='$username'";
				$query_run=mysql_query($query);
				if(mysql_num_rows($query_run)==1){
					echo 'The username '.$username.' already exists';
				} else {
					$query = "INSERT INTO users (username,password,approve,status,fistname,lastname,email)VALUES ('".$username."','".$password."','0','".$status."','".$firstname."','".$lastname."','".$email."')";
					if($query_run=mysql_query($query)){
						header('Location:register_success.php');
					} else {
						echo 'Could not register at this time. Try again later';
					}
					
				}
			
				
			}
			
		} else {
			
		}
	}

?>
<form action = "register.php" method = "POST">
Username: <br> <input type="text" name="username"><br>
Password: <br> <input type="password" name="password"><br>
Password again:<br> <input type="password" name="password_again"><br>
First Name: <br> <input type="text" name="firstname"><br>
Last Name: <br> <input type="text" name="lastname"><br>
Email: <br> <input type="email" name="email" required><br>
User:   <br>
<select name='status'>
  <option value="customer">Customer</option>
  <option value="employe">Employe</option> 
</select> 
<br>
<input type="submit" value="register">
</form>
<?php	
} else if(loggedin()){
	session_destroy();
}

?>