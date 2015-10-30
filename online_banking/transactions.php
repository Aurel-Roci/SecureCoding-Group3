<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $post = $_SERVER['REQUEST_METHOD'] === 'POST';

  if($post) {
    $allPramatetersSet = isset($_POST['recipient']) && isset($_POST['amount']) && isset($_POST['tan']);

  	if($allPramatetersSet){
			$recipient_name = $_POST['recipient'];
			$amount = $_POST['amount'];
			$tan = $_POST['tan'];
			if(!empty($recipient_name) &&!empty($amount) &&!empty($tan)){

				$recipient = fetchUserWithUsername($recipient_name);

        if ($recipient) {
  				$tan_is_for_user = isTanFromUser($tan, getUser()->id);
          $tan_unused = isTanUnused($tan);

  				if($tan_is_for_user && $tan_unused) {
  					insertNewTransaction(getUser()->id, $recipient->id, $amount, $tan);
          } else {
            //error message "TAN error"
          }

			  } else {
          // error "user does not exist"
        }
      }
		}
  }

?>



<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transaction</div>
  <div class="panel-body">
    <form class="form-horizontal" action="" method="POST">
      <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">To</label>
        <div class="col-sm-10">
          <input class="form-control" name="recipient" placeholder="Username" type="text">
        </div>
      </div>
  	  <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">Amount</label>
        <div class="col-sm-10">
          <input class="form-control" name="amount" placeholder="123.45" type="text">
        </div>
      </div>
      <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">Tan#</label>
        <div class="col-sm-10">
          <input class="form-control" name="tan" placeholder="1234567890ABCDE" type="text">
        </div>
      </div>
      <input type="submit" class="form-control" value="Submit transaction" />
    </form>
  </div>
</div>


<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transactions by file upload</div>
  <div class="panel-body">
    <form class="form-horizontal" enctype="multipart/form-data" action="" method="POST">
      <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">Transaction file:</label>
        <div class="col-sm-10">
          <input name="transactionfile" class="form-control" type="file" accept="text/plain"/>
        </div>
      </div>
      <input type="submit" class="form-control" value="Upload transaction file" />
    </form>
  </div>
</div>
