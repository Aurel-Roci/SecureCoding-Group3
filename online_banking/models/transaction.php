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
      return !empty($approval_date);
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


?>
