<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $post = $_SERVER['REQUEST_METHOD'] === 'POST';

  if($post) {
    $allPramatetersSet = isset($_POST['recipient']) && isset($_POST['amount']) && isset($_POST['tan']) && isset($_POST['description']);

  	if($allPramatetersSet){
			$recipient_name = $_POST['recipient'];
			$amount = $_POST['amount'];
			$tan = $_POST['tan'];
			$description = $_POST['description'];
			if($amount<0) {
        ?>
        <div class="alert alert-warning" role="alert"><strong>Warning!</strong>You cannot transfer a negative amount of money!</div>
        <?php
      } else {
        if(!empty($recipient_name) &&!empty($amount) &&!empty($tan)&&  !empty($description)) {
          $senderbalance = getUser()->getBalance();
          $newbalance = $senderbalance - $amount;
          if($newbalance>=0){
            $recipient = fetchUserWithUsername($recipient_name);
            if ($recipient) {
        			$tan_is_for_user = validateTAN($tan, getUser(), $amount, $recipient->getAccountNumber());
						  $tan_unused = isTanUnused($tan);
          		if($tan_is_for_user && $tan_unused) {
      					insertNewTransaction(getUser()->id, $recipient->id, $amount, $description, $tan);
					    } else {
    					  ?>
    					  <div class="alert alert-warning" role="alert"><strong>Warning!</strong> There is a problem with the inserted TAN!</div>
    					  <?php
  				    }
          	} else {
              ?>
              <div class="alert alert-warning" role="alert"><strong>Warning!</strong> The user you are trying to reach does not exist!</div>
              <?php
            }
          } else {
            ?>
            <div class="alert alert-warning" role="alert"><strong>Warning!</strong> You do not have enough money to make this transaction!</div>
            <?php
          }
        }
      }
  	} else if (isset($_FILES['transactionfile'])) {
      //tmp_name
      $filepath = $_FILES['transactionfile']['tmp_name'];
      $output = "";
      $return_line = exec("../parser_src/upload_parser " . escapeshellarg($filepath), $output, $return_var);
    }
  }

?>



<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transaction</div>
  <div class="panel-body">
    <form class="form-horizontal" action="" method="POST" onsubmit="return validateFields(this);" id="transaction_form">
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
      <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <input class="form-control" name="description" placeholder="Enter description" type="text">
        </div>
      </div>
      <input type="submit" class="form-control" value="Submit transaction" />
    </form>
  </div>
</div>

<?php
/*
foreach ($output as $line) {
  if (strstr($line, "Successfully") === FALSE) {
    ?>
    <div class="alert alert-danger" role="alert"><strong>Error!</strong><?= $line?></div>
    <?php
  } else {
    ?>
    <div class="alert alert-success" role="alert"><strong>Success!</strong><?= $line?></div>
    <?php
  }
}
*/
?>

<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transactions by batch file upload</div>
  <div class="panel-body">
    <form class="form-horizontal" enctype="multipart/form-data" action="" method="POST">
      <div class="form-group">
        <label for="transactionfile" class="col-sm-2 control-label">Transaction file:</label>
        <div class="col-sm-10">
          <input name="transactionfile" class="form-control" type="file" accept="text/plain"/>
          <p class="help-block">
            The transaction file has to match exactly the following format to work:<br/>
            sender_id(account number),recipient_id(account number),amount,TAN<br/>
            [(10 digits),(10 digits),(1-10 digits).(0-2 digits),(15 alphanumeric character)]
          </p>
        </div>
      </div>
      <input type="submit" class="form-control" value="Upload transaction file" />
    </form>
  </div>
</div>

<script type="text/javascript">
  function validateAccount(account) {
    return account != "";
  }

  function validateAmount(amount) {
    var re = /^\d*\.?\d*$/i;
    return re.test(amount) && amount != "";
  }

  function validateTAN(tan) {
    var re = /^[a-zA-Z0-9]{15}$/i;
    return re.test(tan) && tan != "";
  }

  function validateFields(form) {
    if (!validateAccount(form.recipient.value)) {
      alert("Please provide a valid username.");
      return false;
    }

    if (!validateAmount(form.amount.value)) {
      alert("Please use the correct format for the amount.");
      return false;
    }

    return true;
  }
</script>
