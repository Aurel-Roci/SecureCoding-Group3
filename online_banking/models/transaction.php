<?php
  class Transaction {
    var $id = 0;
    var $sender_id = 0;
    var $recipient_id = 0;
    var $sender_acc=0;
    var $recipient_acc=0;
    var $description="";
    var $amount = 0;
    var $approval_date = "";
    var $create_date = "";
    var $tan_id = 0;

    function isApproved() {
      return !empty($this->approval_date);
    }

    function to_json() {
      $sender = fetchUserWithId($this->sender_id);
      $recipient = fetchUserWithId($this->recipient_id);

      $array = array(
          "Id" => $this->id,
          "Sender" => $sender->firstname." ".$sender->lastname,
          "Sender Account" => $sender->getAccountNumber(),
          "Recipient" => $recipient->firstname." ".$recipient->lastname,
          "Recipient Account" => $recipient->getAccountNumber(),
          "Amount" => $this->amount." Euro",
          "Description" => $this->description,
          "Approved" => empty($this->approval_date) ? "Not approved" : "Approved",
          "Date" => $this->create_date,
      );
      return json_encode($array);
    }
  }

  function fetchTransactionsForUsername($username) {
    $query = "SELECT * FROM transactions WHERE sender_id IN (SELECT id FROM users WHERE username = '".$username."')"
           . "UNION SELECT * FROM transactions WHERE recipient_id IN (SELECT id FROM users WHERE username = '".$username."')";

    $result = mysql_query($query);
    $transactions = array();

    if($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $transaction = new Transaction();

        $transaction->id = $row["id"];
        $transaction->sender_id = $row["sender_id"];
        $transaction->recipient_id = $row["recipient_id"];
        $transaction->description = $row["description"];
        $transaction->amount = $row["amount"];
        $transaction->approval_date = $row["approval_date"];
        $transaction->create_date = $row["create_date"];
        $transaction->tan_id = $row["tan_id"];

        $transactions[] = $transaction;
      }
    }

    return $transactions;
  }

  function approveTransactionWithId($transaction_id) {
    $query = "UPDATE transactions SET approval_date = NOW() WHERE id='".$transaction_id."';";
    mysql_query($query);
  }

  function fetchNotApprovedTransactions() {
    $query = "SELECT * FROM transactions WHERE approval_date IS NULL AND amount > 10000";

    $result = mysql_query($query);
    $transactions = array();

    if($result) {
      while ($row = mysql_fetch_assoc($result)) {
        $transaction = new Transaction();

        $transaction->id = $row["id"];
        $transaction->sender_id = $row["sender_id"];
        $transaction->sender_acc = $row["sender_acc"];
        $transaction->recipient_id = $row["recipient_id"];
        $transaction->recipient_acc = $row["recipient_acc"];
        $transaction->description = $row["description"];
        $transaction->amount = $row["amount"];
        $transaction->approval_date = $row["approval_date"];
        $transaction->create_date = $row["create_date"];
        $transaction->tan_id = $row["tan_id"];

        $transactions[] = $transaction;
      }
    }

    return $transactions;
  }

  function transactionsToJson($transactions) {
    $res = "[";
    for ($i = 0; $i < count($transactions); $i++) {
      $transaction = $transactions[$i];
      $res .= $transaction->to_json();
      if ($i != (count($transactions) - 1)) {
        $res .= ", ";
      }
    }
    $res = $res . "]";
    return $res;
  }

  function validateTAN($tan, $user, $amount, $account) {
    if ($user->pinHash) {
      $secretKey = substr($tan, strpos($tan, ";") + 1);
      $hashCount = intval(substr($tan, 0, strpos($tan, ";")));
      // echo $user->getLastUsedTAN()."<br>";
      if ($hashCount <= $user->getLastUsedTAN()) {
        return false;
      } else {
        $realHash = $user->pinHash;
        for ($i = 0; $i < $hashCount; $i++) {
          // echo $realHash."<br>";
          $realHash = hash("sha256", utf8_encode($realHash));
        }
        $realHash = hash("sha256", $amount . $account . $realHash);
        // echo $realHash."<br>";
        // echo $secretKey."<br>";
        return strcmp($secretKey, $realHash) == 0;
      }
    }
  	$query = "SELECT id FROM tans WHERE id = '" . mysql_real_escape_string($tan) . "' and user_id = " . $user->id;
  	$query_result = mysql_query($query);
  	return mysql_num_rows($query_result) == 1;
  }

  function isTanUnused($tan){
  	$query = "SELECT id FROM transactions WHERE tan_id = '" . mysql_real_escape_string($tan) . "'";
  	$query_result = mysql_query($query);
  	return mysql_num_rows($query_result) == 0;
  }

  function insertNewTransaction($senderid, $recipientid, $amount, $description, $tan, $hashCount) {
    $date_string = "null";
    if ($amount < 10000) {
      $date_string = "NOW()";
    }

  	$query = "INSERT INTO transactions(sender_id, recipient_id, approval_date, amount, description, tan_id) "
  		. "VALUES ('" . $senderid . "', '" . $recipientid . "', " . $date_string . ", "
      . $amount . " , '" . mysql_real_escape_string($description) . "','" . mysql_real_escape_string($tan) . "')";
    mysql_query($query);

    $query2 = "UPDATE users SET lastUsedTAN = " . $hashCount . " WHERE id = " . $senderid . ";";
    mysql_query($query2);
  }

  function initializeBalance($user_id, $balance) {
    $tan = '';
    do {
      $rand = generateRandomString(15);
      $query = "INSERT INTO tans VALUES('" . $rand . "','" . getUser()->id . "')";
      $tan = $rand;
    } while(!($query_run = mysql_query($query)));
    $query = "INSERT INTO transactions(sender_id, recipient_id, approval_date, amount, description, tan_id) "
  		. "VALUES ('" . getUser()->id . "', '" . $user_id . "', NOW(), "
      . $balance . " , 'balance initialization','" . $tan . "')";
    mysql_query($query);
  }
?>
