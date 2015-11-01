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
		} else if (isset($_FILES['transactionfile'])) {
      //tmp_name
      $filepath = $_FILES['transactionfile']['tmp_name'];
      $return_line = exec("./upload_parser " . escapeshellarg($filepath), $output, $return_var);

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
      <input type="submit" class="form-control" value="Submit transaction" />
    </form>
  </div>
</div>

<?php
  if (isset($return_var)) {
    // echo $return_var;
    // print_r($output);
    if ($return_var == 0) {
?>
<div class="alert alert-success" role="alert"><?= $output[0]?></div>
<?php
    } else {
?>
<div class="alert alert-danger" role="alert"><?= $output[0]?></div>
<?php
    }
  }
?>

<div class="panel panel-default center" style="width: 100%; margin-top: 25px;">
  <div class="panel-heading">Make new transactions by file upload</div>
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

    if (!validateTAN(form.tan.value)) {
      alert("Please provide valid TANs.");
      return false;
    }

    return true;
  }
</script>
