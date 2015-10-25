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
				echo "<table>"; // start a table tag in the HTML
				echo "<tr><th>Username</th><th>Amount</th><th>Receiver</th><th>Approved</th></tr>";
				while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
				    echo "<tr><td>" . $row['username'] . "</td><td>" . $row['amount'] . "</td><td>". $row['receiver']."</td><td>". ($row['approved']?YES:NO) ."</td></tr>";  //$row['index'] the index here is a field name
				}
			} else {
				die(mysql_error());
			}
	   echo "</table>"; //Close the table in HTML
	} else {
		echo "Please enter username!";
	}
}

?>
