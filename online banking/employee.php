<form action="employee.php" method="POST">
Customer username: <input type="text" name="user">
<input type="submit" value="View Transactions">
</form>
<?php
require 'core.inc.php';
require 'connect.inc.php';

echo '<a href="logout.php">Log out</a><br>';
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

?>
