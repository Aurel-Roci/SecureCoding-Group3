<?php
require_once('core.inc.php');
$error = "";
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if($post) {
	$allPramatetersSet = isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_again']) &&
		isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']);
	if($allPramatetersSet) {
		$username = htmlspecialchars($_POST['username']);
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		$firstname = htmlspecialchars($_POST['firstname']);
		$lastname = htmlspecialchars($_POST['lastname']);
		$memberrole = $_POST['memberrole'];
		$email = $_POST['email'];
		$tan_method = $_POST['tanMethod'];

		$passwordRegex = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$";
		$emailRegex = "^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$";

		if(preg_match("/^$passwordRegex/", $password)) {
			if(preg_match("/^$passwordRegex/", $password)){
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
										$i--;
									}
								}

								if($tan_method == 0){
									if(!send_registration_mail($email, $password, $tans, $lastname)) {
											$error = "Email was not sent.";
									}
								} else if($tan_method == 1) {
									if (!mkdir('/tmp/' . $user_id, 0777)) {
										die("mkdir error");
									}
									$propertiesFile = fopen('/tmp/' . $user_id . "/props.txt", "w");
									mt_srand();
									$pin = mt_rand(100000,999999);
									$prop_text = $pin . "\n" . hash("sha256", openssl_random_pseudo_bytes(64)) . "\n0";
									fwrite($propertiesFile, $prop_text);
									fclose($propertiesFile);
									copy("../scs.jar", "/tmp/" . $user_id . "/scs.jar");
									exec("jar uf /tmp/". $user_id ."/scs.jar /tmp/" . $user_id . "/props.txt", $output);
									header('Content-type: application/octet-stream');
									header('Content-Disposition: attachment; filename="scs.jar"');
									header('Content-Transfer-Encoding: binary');
									$scs = fopen("/tmp/". $user_id ."/scs.jar", "r");
									fpassthru($scs);
									fclose($scs);
									echo $output;
									if(!send_pin_mail($email, $password, $pin, $lastname)) {
											$error = "Pin-Email was not sent.";
									}
								}

							} else {
								$error = "Could not register at this time. Try again later";
							}
						}
				} else {
					$error = "Please fill in all fields!";
				}
			} else {
				$error = "This is not a valid email address!";
			}
		} else {
			$error = "Password must have at least 8 characters containing at least 1 uppercase letter, 1 lowercase letter and 1 number";
		}
	}
}
?>
