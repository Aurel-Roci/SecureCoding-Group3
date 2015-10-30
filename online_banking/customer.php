<?php
require 'init.sec.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Banking</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
  </head>
  <body>
    <div class="topbar">
      <div class="topbarcontent">
        <div class="center">
          <span style="position: absolute; top: 25%; margin-top: 0px;">
            <b>
              <a href="index.php">Online Banking</a>
            </b>
            <span style="color: #888;"></span>
            <span style="font-size: 12pt;">
              <span class="glyphicon glyphicon-menu-right"></span>
              <a href="customer.php">Customer</a>
            </span>
          </span>
        </div>
        <span style="float: right;">
          <span style="margin-top: 20px; font-size: 12pt;"><?= getUser()->email ?></span>
          <button class="btn btn-danger" onclick="window.location = 'logout.php'">
            <span class="glyphicon glyphicon-log-out"></span>
            Log out
          </button>
        </span>
      </div>
    </div>

    <div class="container">
      <?php
      if (!getUser()->isApproved()) {
      ?>
      <div class="alert alert-warning" role="alert">Your user account hasn't been approved yet! Please contact an employee.</div>
      <?php
      } else {
      ?>
      <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
        <div class="panel-heading">User info</div>
        <table class="table">
          <thead>
            <tr>
              <th>Account number</th>
              <th>Username</th>
              <th>First name</th>
              <th>Last name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Approval state</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <p><?= $user->getAccountNumber() ?></p>
              </td>
              <td>
                <p><?= getUser()->username ?></p>
              </td>
              <td>
                <p><?= getUser()->firstname ?></p>
              </td>
              <td>
                <p><?= getUser()->lastname ?></p>
              </td>
              <td>
                <p><?= getUser()->email ?></p>
              </td>
              <td>
                <p><?= getUser()->isEmployee() ? 'Employee' : 'Customer' ?></p>
              </td>
              <td>
                <p><?= getUser()->isApproved() ? 'Approved' : 'Not approved' ?></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <?php
      $username = getUser()->username;
      $transactions = fetchTransactionsForUsername($username);
      ?>
      <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
        <?php
        if(count($transactions) == 0) {
          ?>
          <div class="panel-heading">No transactions found.</div>
          <?php
        } else {
        ?>
        <div class="panel-heading">Transactions</div>
        <table class="table">
          <thead>
            <tr>
              <th>Sender</th>
              <th>Recipient</th>
              <th>Amount</th>
              <th>Date</th>
			  <th>Approval state</th>
            </tr>
          </thead>
          <tbody>
            <?php   foreach ($transactions as &$transaction) {
              $sender = fetchUserWithId($transaction->sender_id);
              $recipient = fetchUserWithId($transaction->recipient_id);
              ?>
              <tr>
                <td>
                  <a href="#"><?= $sender->firstname ?> <?= $sender->lastname ?></a>
                </td>
                <td>
                  <a href="#"><?= $recipient->firstname ?> <?= $recipient->lastname ?></a>
                </td>
                <td>
                  <p><?= $transaction->amount ?> &euro;</p>
                </td>
                <td>
                  <p><?= $transaction->create_date ?></p>
                </td>
				        <td>
                  <p><?= $transaction->isApproved() ? 'Approved' : 'Not approved'?></p>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php
        }
        ?>
      </div>
      <button class='btn btn-primary btn-lg' style='width: 100%;' onclick='downloadTransactionsAfPDF(<?= transactionsToJson($transactions) ?>)'>Download as PDF</button>

      <?php
        include 'transactions.php';
      }
       ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/jspdf.min.js"></script>
    <script type="text/javascript" src="dist/jspdf.plugin.table.js"></script>

    <script type="text/javascript">
      function downloadTransactionsAfPDF(data) {
        var doc = new jsPDF('p', 'pt', 'a4', true);
        doc.setFont("courier", "normal");
        doc.setFontSize(12);

        var height = doc.drawTable(data);
        doc.save("transaction.pdf");
      }
    </script>
  </body>
</html>
