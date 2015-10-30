<?php
  class Transaction {
    var $id = 0;
    var $sender_id = 0;
    var $recipient_id = 0;
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
          "Recipient" => $recipient->firstname." ".$recipient->lastname,
          "Amount" => $this->amount." Euro",
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
        $transaction->recipient_id = $row["recipient_id"];
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

  function isTanFromUser($tan, $userid) {
  	$query = "SELECT id FROM tans WHERE id = '" . mysql_real_escape_string($tan) . "' and user_id = " . $userid;
  	$query_result = mysql_query($query);
  	return mysql_num_rows($query_result) == 1;
  }

  function isTanUnused($tan){
  	$query = "SELECT id FROM transactions WHERE tan_id = '" . mysql_real_escape_string($tan) . "'";
  	$query_result = mysql_query($query);
  	return mysql_num_rows($query_result) == 0;
  }

  function insertNewTransaction($senderid, $recipientid, $amount, $tan) {
    $date_string = "null";
    if ($amount < 10000) {
      $date_string = "NOW()";
    }

  	$query = "INSERT INTO transactions(sender_id, recipient_id, approval_date, amount,tan_id) "
  		. "VALUES ('" . $senderid . "', '" . $recipientid . "', " . $date_string . ", "
      . $amount . ", '" . mysql_real_escape_string($tan) . "')";
    mysql_query($query);
  }
?>
