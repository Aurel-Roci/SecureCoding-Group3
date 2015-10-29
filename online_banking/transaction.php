<?php
require 'core.inc.php';
require 'connect.inc.php';

  $post = $_SERVER['REQUEST_METHOD'] === 'POST';
 
  $userid = $_POST['user'];
  
  if($post) {
  $allPramatetersSet = isset($_POST['username']) && isset($_POST['amount']) && isset($_POST['tan']);
  
	if($allPramatetersSet){
			$username = $_POST['username'];
			$amount = $_POST['amount'];
			$tan = $_POST['tan']; 
			if(!empty($username) &&!empty($amount) &&!empty($tan)){
				if($amount<10000){
					$approved=TRUE;
				} else {
					$approved=FALSE;
				} 
				
				$query = "SELECT id FROM users WHERE username ='".mysql_real_escape_string($username)."'";
				$query_run = mysql_query($query);
				$id = mysql_result($query_run,0);  
				
				$query = "INSERT INTO transactions (sender_id,recipient_id,amount,tan_id,approved) "
							 . "VALUES ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($id)."' ,".$amount.",'". mysql_real_escape_string($tan)."','".$approved."')";
							 
				if($query_run = mysql_query($query)){
					echo "Transactions complete!";
				} else {
					echo "Transaction could not be completed!";
				}
							
			}
		}
  }

?>

<div class="container"> 
   
  <p>Enter information for the transaction</p>
  <form action="<?php echo $current_file; ?>" method="POST">
    <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">To</span>
      <input class="form-control" name="username" type="text">
    </div>
	 <div class="input-group" style="margin-top: 20px">
      <span class="input-group-addon" id="basic-addon1">Amount</span>
      <input class="form-control" name="amount" type="text">
    </div>
    <div class="input-group" style="margin-top: 20px">
      <span class="input-group-addon" id="basic-addon1">Tan#</span>
      <input class="form-control" name="tan" type="text">
    </div>
	<div>
		<input type="hidden" name="user" value="<?= $var_value = $_POST['user'];?>">
	</div>
		<button class="btn btn-primary" style="margin-top: 20px; width: 49%; float: left;" type="submit">Make Transaction</button> 
  </form>
</div>