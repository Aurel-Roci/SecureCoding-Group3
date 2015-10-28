<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'models/user.php';
require 'models/transaction.php';

require 'core.inc.php'; //reusable functions
require 'connect.inc.php'; //connect to DB

$post = $_SERVER['REQUEST_METHOD'] === 'POST';
if($post) {
  $user_id = $_POST['user_id'];
  approveUserWithId($user_id);
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
          <span style="margin-top: 20px; font-size: 12pt;"><?= getUser()->email ?></span>
          <button class="btn btn-danger" onclick="window.location = 'logout.php'">
            <span class="glyphicon glyphicon-log-out"></span>
            Log out
          </button>
        </span>
      </div>
    </div>

    <div class="container">
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
      ?>
        <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
          <div class="panel-heading">User info</div>
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
                  <p><?= $user->isEmployee() ? 'Employee' : 'Customer' ?></p>
                </td>
                <td>
                  <?php
                  if($user->isApproved()) {
                    echo "<p>Approved</p>";
                  } else {
                    echo "<a href='#' onclick='requestApproval(\"".$user->username."\", ".$user->id.",this)'>Approve now!</a>";
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
          <div class="panel-heading">Transactions</div>
          <table class="table">
            <thead>
              <tr>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Amount</th>
                <th>Date</th>
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
                    <a href="employee.php?user=<?= $recipient->username ?>"><?= $recipient->firstname ?> <?= $recipient->lastname ?></a>
                  </td>
                  <td>
                    <p><?= $transaction->amount ?></p>
                  </td>
                  <td>
                    <p><?= $transaction->create_date ?></p>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php
      }
      ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      function requestApproval(user, id, link) {
        var approve = confirm("Do you really want to approve "+user+"?");

        if (approve == true) {
          var http = new XMLHttpRequest();
          var url = "employee.php";
          var params = "user_id="+id;
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
    </script>
  </body>
</html>
