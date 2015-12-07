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
if (isset($output)) {
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
}
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
            sender_id(account number),recipient_id(account number),amount,TAN,description<br/>
            [(10 digits),(10 digits),(1-10 digits).(0-2 digits),(15 alphanumeric character),(0-200 alphanumeric character)]<br/>
            TAN has not to be provided if the application TAN is used.
          </p>
        </div>
      </div>
      <?php
      if ($user->pinHash) {
      ?>
      <div class="form_group">
        <label for="fileTAN" class="col-sm-2 control-label">File TAN:</label>
        <div class="col-sm-10">
          <input name="fileTAN" class="form-control" placeholder="1234567890ABCDE" type="text"/>
        </div>
      </div>
      <?php
      }
      ?>
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
