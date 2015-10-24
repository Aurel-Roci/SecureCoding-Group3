<?php
require 'core.inc.php';

if(!loggedin()){
?>
<form action = "register.php" method = "POST">
Username: <br> <input type="text" name="username"><br><br>
Password: <br> <input type="password" name="password"><br><br>
Password again:<br> <input type="password" name="password_again"><br><br>
First Name: <br> <input type="text" name="firstname"><br><br>
Last Name: <br> <input type="text" name="lastname"><br><br>
<input type="submit" value="register">
</form>
<?php	
} else if(loggedin()){
	
}

?>