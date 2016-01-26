<?php
  const ATTEMPTS_BEFORE_LOCKOUT = 3;
  const LOCKOUT_CLEAR_TIME = 300;

  class User {
    var $id = 0;
    var $username = "";
    var $firstname = "";
    var $lastname = "";
    var $email = "";
    var $memberrole = 0;
    var $approved = 0;
    var $pinHash = "";

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

    function getBalance() {
      $query = "SELECT IFNULL(IFNULL((SELECT SUM(amount) FROM transactions WHERE recipient_id = ".$this->id." AND approval_date IS NOT NULL), 0)-IFNULL((SELECT SUM(amount) FROM transactions WHERE sender_id = ".$this->id." AND approval_date IS NOT NULL), 0), 0);";

      $result = mysql_query($query);

      if($result && mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        $array_row = array_values($row);
        return $array_row[0];
      }
    }

    function getLastUsedTAN() {
      $query = "SELECT lastUsedTAN FROM users WHERE id='".$this->id. "';";

      $result = mysql_query($query);

      if($result && mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        $array_row = array_values($row);
        return intval($array_row[0]);
      }
      return 0;
    }
  }

  function fetchUser($username, $password) {
    if (!isset($_SESSION["failedLoginAttempts"])) {
      $_SESSION["failedLoginAttempts"] = 0;
      $_SESSION["lastFailedLoginAttempt"] = 0;
    }

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
      $user->pinHash = $row["pinHash"];

      $_SESSION["failedLoginAttempts"] = 0;
      $_SESSION["lastFailedLoginAttempt"] = 0;

      return $user;
    } else {
      $_SESSION["failedLoginAttempts"] = $_SESSION["failedLoginAttempts"] + 1;
      $_SESSION["lastFailedLoginAttempt"] = time();
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
    $query = "UPDATE users SET approved = 1 WHERE id='".mysql_real_escape_string($user_id)."';";
    mysql_query($query);
  }

  function approveUserWithIdAndBalance($user_id, $balance) {
    $user_id = mysql_real_escape_string($user_id);
    $balance = mysql_real_escape_string($user_id);
    $user_id = htmlspecialchars($user_id);
    $balance = htmlspecialchars($balance);
    $query = "UPDATE users SET approved = 1 WHERE id='".$user_id."';";
    mysql_query($query);

    initializeBalance($user_id, $balance);
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

  function isLoginBlocked($username) {
    if (!isset($_SESSION["failedLoginAttempts"])) {
      $_SESSION["failedLoginAttempts"] = 0;
      $_SESSION["lastFailedLoginAttempt"] = 0;
    }
    if ($_SESSION["failedLoginAttempts"] > ATTEMPTS_BEFORE_LOCKOUT && $_SESSION["lastFailedLoginAttempt"] > time() - LOCKOUT_CLEAR_TIME) {
      $query = "UPDATE users SET approved = 0 WHERE username='".mysql_real_escape_string($username)."';";
      $result = mysql_query($query);
      return true;
    }
    return false;
  }

?>
