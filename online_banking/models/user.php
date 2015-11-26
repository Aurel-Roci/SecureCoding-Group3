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

    function getAccountNumber() {
      $account_number = $this->id;
      while (strlen($account_number) < 10) {
        $account_number = "0" . $account_number;
      }
      return $account_number;
    }
 
  }

  function userBalance($user_id, $balance){
		$query = "UPDATE users SET balance = '".$balance."' WHERE id='".$user_id."'";
		mysql_query($query);
	}
   
	
  function getBalance($id) {
       
      $query = "SELECT balance FROM users WHERE  id ='".$id."'";
      $result = mysql_query($query);
      if($result && mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
          $array_row = array_values($row);
          // print_r($array_row[0]);
          return $array_row[0];
        //return (float)$result;
      }

      return (float)"N/A";
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

  function fetchUserWithUsername($username) {
    $query = "SELECT * FROM users WHERE username='".mysql_real_escape_string($username)."';";

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
    $query = "SELECT id, firstname, lastname, username FROM users WHERE id='".$user_id."';";

    $result = mysql_query($query);

    if($result && mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);

      $user = new User();
      $user->id = $row["id"];
      $user->firstname = $row["firstname"];
      $user->lastname = $row["lastname"];
      $user->username = $row["username"];

      return $user;
    }
  }

  function approveUserWithId($user_id) {
    $query = "UPDATE users SET approved = 1 WHERE id='".$user_id."';";
    mysql_query($query);
  }

  function userBalance($user_id, $balance){
    $query = "UPDATE users SET balance = '".$balance."' WHERE id='".$user_id."';";
    mysql_query($query);
  }

  function fetchNotApprovedUsers() {
    $query = "SELECT * FROM users WHERE approved = 0";

    $result = mysql_query($query);
    $users = array();

		if($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $user = new User();

        $user->id = $row["id"];
        $user->username = $row["username"];
        $user->firstname = $row["firstname"];
        $user->lastname = $row["lastname"];
        $user->email = $row["email"];
        $user->memberrole = $row["memberrole"];
        $user->approved = $row["approved"];

        $users[] = $user;
      }
    }
    return $users;
  }

?>
