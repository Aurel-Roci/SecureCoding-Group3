<?php
  class User {
    var $id = 0;
    var $username = "";
    var $firstname = "";
    var $lastname = "";
    var $email = "";
    var $memberrole = 0;
    var $approved = 0;

    function isEmployee() {
      return $this->memberrole == 1;
    }

    function isApproved() {
      return $this->approved == 1;
    }
  }

  function fetchUser($username, $password) {
    $query = "SELECT * FROM users WHERE username='".mysql_real_escape_string($username)
           . "' AND password=SHA2('".mysql_real_escape_string($password)."', 256)";

    $result = mysql_query($query);

		if($result && mysql_num_rows($result) > 0) {
			$row = mysql_fetch_assoc($result);

      $user = new User();
      $user->id = $row["id"];
      $user->username = $row["username"];
      $user->firstname = $row["firstname"];
      $user->lastname = $row["lastname"];
      $user->email = $row["email"];
      $user->memberrole = $row["memberrole"];
      $user->approved = $row["approved"];

      return $user;
    }
  }

  function fetchUserWithId($user_id) {
    $query = "SELECT id, firstname, lastname FROM users WHERE id='".$user_id."';";

    $result = mysql_query($query);

    if($result && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);

      $user = new User();
      $user->id = $row["id"];
      $user->firstname = $row["firstname"];
      $user->lastname = $row["lastname"];

      return $user;
    }
  }

?>
