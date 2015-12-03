<?php
require 'init.sec.php';

$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if($post) {
  if(isset($_POST['balance']) && isset($_POST['user_id'])) {
    $balance= $_POST['balance'];
    $user_id = $_POST['user_id'];
    if (is_numeric($balance)) {
      approveUserWithIdAndBalance($user_id, $balance);
    }else {
      header(':', true, 400);
    }

  }else if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    approveUserWithId($user_id);
  } else if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];
    approveTransactionWithId($transaction_id);
  }
}
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
              <a href="employee.php">Employee</a>
            </span>
          </span>
        </div>
        <span style="float: right;">
          <img class="profilepic" src="http://www.gravatar.com/avatar/<?= md5(getUser()->email) ?>" alt=""/>
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
      <div class="alert alert-warning" role="alert">Your user account isn't approved yet! Please contact an employee</div>
      <?php
      } else {
      ?>
      <form action="employee.php" method="GET">
        <input class="form-control" name="user" placeholder="Customer username" style="margin-bottom: 10px; width: 49%; float: left;" type="text" value="<?= isset($_GET['user']) ? $_GET['user'] : '' ?>">
        <button class="btn btn-primary center" style="width: 49%; float: right;" type="submit">Show user details</button>
        <div style="clear: both;"></div>
      </form>

      <?php
      $search = isset($_GET['user']);
      if($search) {
        $username = $_GET['user'];
        $transactions = fetchTransactionsForUsername($username);
        $user = fetchUserWithUsername($username);
        if (empty($user)){
          ?>
            <div class="alert alert-warning" role="alert"><strong>Warning!</strong> User does not exists</div>
          <?php
        		}
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
                <th>Balance</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <p><?= $user->getAccountNumber() ?></p>
                </td>
                <td>
                  <p><?= $user->username ?></p>
                </td>
                <td>
                  <p><?= $user->firstname ?></p>
                </td>
                <td>
                  <p><?= $user->lastname ?></p>
                </td>
                <td>
                  <p><?= $user->email ?></p>
                </td>
                <td>
                  <p id="user_balance"><?= number_format($user->getBalance(), 2, ".", ",") ?> &euro;</p>
                </td>
                <td>
                  <p><?= $user->isEmployee() ? 'Employee' : 'Customer' ?></p>
                </td>
                <?php if (!$user->isApproved()) { ?>
                <td>
                  <p><input style="border: 1px solid #CCC;border-radius: 4px;" name="balance" placeholder="0.0" type="text"></p>
                </td>
                <?php } ?>
                <td>
                  <?php
                  if($user->isApproved()) {
                    echo "<p>Approved</p>";
                  } else {
                    echo "<a href='#' onclick='requestUserApproval(\"".$user->username."\", ".$user->id.",this)'>Approve now!</a>";
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
          <?php if (count($transactions) == 0) { ?>
            <div class="panel-heading">No transactions found</div>
          <?php } else { ?>
            <div class="panel-heading">Transactions</div>
            <table class="table">
              <thead>
                <tr>
                  <th>Sender</th>
                  <th>Sender Account</th>
                  <th>Recipient</th>
                  <th>Recipient Account</th>
                  <th>Amount</th>
                  <th>Description</th>
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
                      <a href="employee.php?user=<?= $sender->username ?>"><?= $sender->firstname ?> <?= $sender->lastname ?></a>
                    </td>
                    <td>
                      <p><?= $sender->getAccountNumber() ?></p>
                    </td>
                    <td>
                      <a href="employee.php?user=<?= $recipient->username ?>"><?= $recipient->firstname ?> <?= $recipient->lastname ?></a>
                    </td>
                    <td>
                      <p><?= $recipient->getAccountNumber() ?></p></p>
                    </td>
                    <td>
                      <p><?= number_format($transaction->amount, 2, ".", ",") ?> &euro;</p>
                    </td>
                    <td>
                      <p><?= $transaction->description ?></p>
                    </td>
                    <td>
                      <p><?= $transaction->create_date ?></p>
                    </td>
                    <td>
                      <?php
                      if($transaction->isApproved()) {
                        echo "<p>Approved</p>";
                      } else {
                        echo "<a href='#' onclick='requestTransactionApproval(".$transaction->id.",this)'>Approve now!</a>";
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
        <button class='btn btn-primary btn-lg' style='width: 100%;' onclick='downloadTransactionsAfPDF(<?= transactionsToJson($transactions) ?>)'>Download as PDF</button>
      <?php
    } else {
      $notApprovedUsers = fetchNotApprovedUsers();
      $notApprovedTransactions = fetchNotApprovedTransactions();
      ?>
        <hr>
        <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
          <?php if (count($notApprovedUsers) == 0) { ?>
            <div class="panel-heading">No user registration requests found</div>
          <?php } else { ?>
            <div class="panel-heading">Open user registration requests</div>
            <table class="table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Approval state</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($notApprovedUsers as &$user) { ?>
                  <tr>
                    <td>
                      <p><?= $user->username ?></p>
                    </td>
                    <td>
                      <p><?= $user->firstname ?></p>
                    </td>
                    <td>
                      <p><?= $user->lastname ?></p>
                    </td>
                    <td>
                      <p><?= $user->email ?></p>
                    </td>
                    <td>
                      <p id="user_balance"><?= number_format($user->getBalance(), 2, ".", ",") ?> &euro;</p>
                    </td>
                    <td>
                      <p><?= $user->isEmployee() ? 'Employee' : 'Customer' ?></p>
                    </td>
                    <?php if (!$user->isApproved()) { ?>
                    <td>
                      <p><input style="border: 1px solid #CCC;border-radius: 4px;" name="balance" placeholder="0.0" type="text"></p>
                    </td>
                    <?php } ?>
                    <td>
                      <?php
                      if($user->isApproved()) {
                        echo "<p>Approved</p>";
                      } else {
                        echo "<a href='#' onclick='requestUserApproval(\"".$user->username."\", ".$user->id.",this)'>Approve now!</a>";
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>

        <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
          <?php if (count($notApprovedTransactions) == 0) { ?>
            <div class="panel-heading">No open transaction requests found</div>
          <?php } else { ?>
            <div class="panel-heading">Open transaction requests</div>
            <table class="table">
              <thead>
                <tr>
                  <th>Sender</th>
                  <th>Sender Account</th>
                  <th>Recipient</th>
                  <th>Recipient Account</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Date</th>
    			        <th>Approval state</th>
                </tr>
              </thead>
              <tbody>
                <?php   foreach ($notApprovedTransactions as &$transaction) {
                  $sender = fetchUserWithId($transaction->sender_id);
                  $recipient = fetchUserWithId($transaction->recipient_id);
                  ?>
                  <tr>
                    <td>
                      <a href="employee.php?user=<?= $sender->username ?>"><?= $sender->firstname ?> <?= $sender->lastname ?></a>
                    </td>
                    <td>
                      <p><?= $sender->getAccountNumber() ?></p>
                    </td>
                    <td>
                      <a href="employee.php?user=<?= $recipient->username ?>"><?= $recipient->firstname ?> <?= $recipient->lastname ?></a>
                    </td>
                    <td>
                      <p><?= $recipient->getAccountNumber() ?></p></p>
                    </td>
                    <td>
                      <p><?= number_format($transaction->amount, 2, ".", ",") ?> &euro;</p>
                    </td>
                    <td>
                      <p><?= $transaction->description ?></p>
                    </td>
                    <td>
                      <p><?= $transaction->create_date ?></p>
                    </td>
                    <td>
                      <?php
                      if($transaction->isApproved()) {
                        echo "<p>Approved</p>";
                      } else {
                        echo "<a href='#' onclick='requestTransactionApproval(".$transaction->id.",this)'>Approve now!</a>";
                      }
                      ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
        <?php
        }
      }
      ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/jspdf.min.js"></script>
    <script type="text/javascript" src="dist/jspdf.plugin.table.js"></script>

    <script type="text/javascript">
      function requestUserApproval(user, id, link) {
        var approve = confirm("Do you really want to approve "+user+"?");

        if (approve == true) {
          var http = new XMLHttpRequest();
          var url = "employee.php";
          var params = "user_id="+id;
          var balance = 0;
          if (document.getElementsByName('balance')[0].value.length > 0) {
            balance = document.getElementsByName('balance')[0].value;
            params = params + "&balance=" + balance;
          }
          http.open("POST", url, true);

          http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          http.setRequestHeader("Content-length", params.length);
          http.setRequestHeader("Connection", "close");

          http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
              link.parentElement.parentElement.removeChild(link.parentElement.parentElement.querySelector('[name="balance"]').parentElement.parentElement);
              link.parentElement.parentElement.querySelector('#user_balance').innerHTML = balance + " &euro;";
              link.parentElement.innerHTML = '<p>Approved</p>';
            } else if (http.readyState == 4 && http.status == 400) {
              alert("Could not approve user!\nMalformed balance");
            }
          }
          http.send(params);
        }
      }


      function handleError(error) {
          alert(error);
      }


      function requestTransactionApproval(id, link) {
        var approve = confirm("Do you really want to approve this transaction?");

        if (approve == true) {
          var http = new XMLHttpRequest();
          var url = "employee.php";
          var params = "transaction_id="+id;
          http.open("POST", url, true);

          http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          http.setRequestHeader("Content-length", params.length);
          http.setRequestHeader("Connection", "close");

          http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
              link.parentElement.innerHTML = '<p>Approved</p>';
            }
          }
          http.send(params);
        }
      }

      function downloadTransactionsAfPDF(data) {
        var doc = new jsPDF('p', 'pt', 'a4', true);
        doc.setFont("courier", "normal");
        doc.setFontSize(12);

        var height = doc.drawTable(data);
        doc.save("transaction.pdf");
      }

    </script>
  </body>
  <?php include 'footer.inc.php'; ?>
</html>
