<?php
require_once('core.inc.php');

$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$emailSet = isset($_POST['email']);
$idSet = isset($_GET['id']) || isset($_POST['id']);
if($post && $emailSet) {
	$email = $_POST['email'];
  $query = "SELECT user_id FROM resetrequests r, users u WHERE user_id = u.id AND email ='".mysql_real_escape_string($email)."'";
  $query_run=mysql_query($query);
  if(mysql_num_rows($query_run) > 0) {
      $error = "There exists already a password reset request for this user account. Check your emails.";
  } else {
		$query = "SELECT id, lastname FROM users u WHERE email ='".mysql_real_escape_string($email)."'";
		$result=mysql_query($query);

		$row = mysql_fetch_assoc($result);
		if ($row) {
			$user_id = $row["id"];
			$lastname = $row["lastname"];
			$randomInt = rand(1 , 9999999999);

			$query = "INSERT INTO resetrequests (id,user_id) "
					. "VALUES (" . $randomInt . ", " . $user_id . ")";

			$query_run = mysql_query($query);

			$link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}?id=" . $randomInt;

			sendPasswordResetMail($email, $link, $lastname);
		}
		$message = "Success! If an user with this email address exists you will get an email with instructions how to reset your password.";
  }
} else if (!$post && $idSet) {
	$id = $_GET['id'];
	$query = "SELECT * FROM resetrequests r WHERE id ='".mysql_real_escape_string($id)."'";
	$result = mysql_query($query);
	if(mysql_num_rows($result) == 0) {
		$error = "No password reset request with this id exists.";
	}
} else if ($post && $idSet) {
	$id = $_POST['id'];
	$password = $_POST['password'];
	$query = "SELECT user_id FROM resetrequests r WHERE id ='".mysql_real_escape_string($id)."'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	if ($row) {
		$user_id = $row["user_id"];
		$deleteQuery = "DELETE FROM resetrequests WHERE id ='".mysql_real_escape_string($id)."'";
		$passwordChangeQuery = "UPDATE USERS SET PASSWORD=SHA2('" . mysql_real_escape_string($password) . "', 256) WHERE id=" . mysql_real_escape_string($user_id) . ";";

		$query_run = mysql_query($deleteQuery);
		$query_run = mysql_query($passwordChangeQuery);

		$message = "Success! You changed your passwort successfully.";
	} else {
		$error = "Couldn't find corresponding user.";
	}
}
?>
