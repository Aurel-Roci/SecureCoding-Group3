<?php
require 'core.inc.php'; //reusable functions
require 'connect.inc.php'; //connect to DB
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
              <a href="/">Online Banking</a>
            </b>
            <span style="color: #888;"></span>
            <span style="font-size: 12pt;">
              <span class="glyphicon glyphicon-menu-right"></span>
              <a href="/employee.php">Employee</a>
            </span>
          </span>
        </div>
        <span style="float: right;">
          <span style="margin-top: 20px; font-size: 12pt;">Hier kommt eine E-Mail Adresse</span>
          <button class="btn btn-danger" onclick="window.location = 'logout.php'">
            <span class="glyphicon glyphicon-log-out"></span>
            Log out
          </button>
        </span>
      </div>
    </div>

    <div class="container">
      <form action="employee.php" method="POST">
        <input class="form-control" name="user" placeholder="Customer username" style="margin-bottom: 10px; width: 49%; float: left;" type="text">
        <button class="btn btn-primary center" style="width: 49%; float: right;" type="submit">View Transactions</button>
        <div style="clear: both;"></div>
      </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>



<?php
/*
if(isset($_POST['user'])){
 $username=$_POST['user'];
	if(!empty($username)){
		$result=viewTransactions($username);
			if($result){
				echo "$query_run";
?>
	<table>
	<tr><th>Username</th><th>Amount</th><th>Receiver</th><th>Approved</th></tr>
<?php
                while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
				    echo "<tr>";
                    echo "<td>" . $row['sender_id'] . "</td>";
                    echo "<td>" . $row['amount'] . "</td>";
                    echo "<td>". $row['receiver_id']."</td>";
                    echo "<td>". ($row['approval_date']?$row['approval_date']:"NOT APPROVED YET") ."</td>";
                    echo "</tr>";  //$row['index'] the index here is a field name
				}
			} else {
				die(mysql_error());
			}
?>
	</table>
<?php
	} else {
		echo "Please enter username!";
	}
}
*/
?>
