<?php

  $post = $_SERVER['REQUEST_METHOD'] === 'POST';

  $userid = $_POST['user'];
	mysql_query("INSERT INTO `table` (`dateposted`) VALUES ('$date')");
  if($post) {
  $allPramatetersSet = isset($_POST['username']) && isset($_POST['amount']) && isset($_POST['tan']);

	if($allPramatetersSet){
			$username = $_POST['username'];
			$amount = $_POST['amount'];
			$tan = $_POST['tan'];
			if(!empty($username) &&!empty($amount) &&!empty($tan)){
				if($amount<10000){
					$date = date('Y-m-d H:i:s');
				} else {
					$date = NULL;
				}

				$query = "SELECT id FROM users WHERE username ='".mysql_real_escape_string($username)."'";
				$query_run = mysql_query($query);
				$id = mysql_result($query_run,0);

				$query2 = "SELECT * FROM tans WHERE user_id ='".mysql_real_escape_string($userid)."' AND id = '".mysql_real_escape_string($tan)."'";
				$query_run2 = mysql_query($query2);

				if(mysql_num_rows($query_run2) == 1) {
					$query3 = "SELECT tan_id FROM transactions WHERE tan_id='".mysql_real_escape_string($tan)."'";
					$query_run3 = mysql_query($query3);

					if(mysql_num_rows($query_run3) == 0){
						$query = "INSERT INTO transactions (sender_id,recipient_id,approval_date,amount,tan_id) "
							 . "VALUES ('".mysql_real_escape_string($userid)."', '".mysql_real_escape_string($id)."','".$date."' ,".$amount.",'". mysql_real_escape_string($tan)."')";

						if($query_run = mysql_query($query)){
							echo "Transactions complete!";
						} else {
							echo "Transaction could not be completed!";
						}
					} else {
						echo "Tan already used!";
					}
				}

			}
		}
  }

?>



<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transactions</div>
  <p>Enter information for the transaction</p>
  <form action="" method="POST">
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


<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transactions by file upload</div>
  <div class="panel-body">
    <form enctype="multipart/form-data" action="" method="POST">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000" />
      <div class="form-group">
        <label for="transactionfile">Upload the following transaction file:</label>
        <input name="transactionfile" type="file" accept="text/plain"/>
      </div>
      <input type="submit" class="form-control" value="Submit transaction" />
    </form>
  </div>
</div>
