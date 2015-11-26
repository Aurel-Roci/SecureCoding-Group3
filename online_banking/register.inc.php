<?php
$error = "";
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if($post) {
	$allPramatetersSet = isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_again']) &&
		isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']);
	if($allPramatetersSet) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$memberrole = $_POST['memberrole'];
		$email = $_POST['email'];


		if(!empty($username) && !empty($password) && !empty($password_again) && !empty($firstname) && !empty($lastname) && !empty($email)) {
			$query = "SELECT username FROM users WHERE username='".mysql_real_escape_string($username)."'";
			$query_run=mysql_query($query);
			if(mysql_num_rows($query_run) > 0) {
				$error = "The username ".$username." already exists";
			} else {
				$query = "INSERT INTO users (username,password,approved,memberrole,firstname,lastname,email) "
							 . "VALUES ('".mysql_real_escape_string($username)."', SHA2('".mysql_real_escape_string($password)
				 		 	 . "', 256), False,".$memberrole.",'".mysql_real_escape_string($firstname)."','"
				 		 	 . mysql_real_escape_string($lastname)."','".mysql_real_escape_string($email)."')";

				if($query_run = mysql_query($query)) {
					$query = "SELECT id FROM users WHERE username='".mysql_real_escape_string($username)."'";
					$result = mysql_query($query);
					$user_id = mysql_result($result, 0);

					$tans = "";
					for ($i = 0; $i <+ 100; $i++) {
						$rand = generateRandomString(15);
						$query = "INSERT INTO tans VALUES('".$rand."','".$user_id."')";
						if($query_run = mysql_query($query)) {
							$tans .= $rand."\n";
						} else {
							$error = "Failed generating tans";
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
					$error = "Could not register at this time. Try again later";
				}
			}
		} else {
			$error = "Please fill in all fields!";
		}
	}
}
?>
