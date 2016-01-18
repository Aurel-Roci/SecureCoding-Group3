<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $post = $_SERVER['REQUEST_METHOD'] === 'POST';
  $user = getUser();

  if($post) {
    $allPramatetersSet = isset($_POST['recipient']) && isset($_POST['amount']) && isset($_POST['tan']) && isset($_POST['description']);

  	if($allPramatetersSet){
			$recipient_name = $_POST['recipient'];
			$amount = $_POST['amount'];
			$tan = $_POST['tan'];
			$description = $_POST['description'];
      $description = htmlspecialchars($description);
			if($amount<0) {
        ?>
        <div class="alert alert-warning" role="alert"><strong>Warning!</strong>You cannot transfer a negative amount of money!</div>
        <?php
      } else {
        if(!empty($recipient_name) &&!empty($amount) &&!empty($tan)&&  !empty($description)) {
          $senderbalance = $user->getBalance();
          $newbalance = $senderbalance - $amount;
          if($newbalance>=0){
            $recipient = fetchUserWithUsername($recipient_name);
            if ($recipient) {
        			$tan_is_for_user = validateTAN($tan, $user, $amount, $recipient->getAccountNumber());
						  $tan_unused = isTanUnused($tan);
          		if($tan_is_for_user && $tan_unused) {
                $hashCount = 0;
                if ($user->pinHash) {
                  $hashCount = intval(substr($tan, 0, strpos($tan, ";")));
                }
      					insertNewTransaction($user->id, $recipient->id, $amount, $description, $tan, $hashCount);
                $user->lastUsedTAN = $hashCount;
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
      // TODO if aplication for tans hash_file("sha256", $filepath)
      if ($user->pinHash) {
        $tan = $_POST['fileTAN'];
        $tanFile = substr($tan, strpos($tan, ";") + 1);
        $count = intval(substr($tan, 0, strpos($tan, ";")));
        $key = $user->pinHash;
        for ($i = 0; $i < $count; $i++) {
          $key = hash("sha256", utf8_encode($key));
        }
        $toHash = file_get_contents($filepath);
        // echo $hashCount."<br/>";
        // echo $user->getLastUsedTAN()."<br/>";
        if ($count <= $user->getLastUsedTAN()) {
          $output = array("Wrong TAN");
        }else if (!$toHash) {
          $output = array("Could not read file");
        } else if (strlen($tanFile) != 64){
          $output = array("TAN has not the correct length");
        }else {
          $toHash = $toHash . $key;
          $hash = hash("sha256", $toHash);
          $return_line = exec("../parser_src/upload_parser " . escapeshellarg($filepath) . " " . $user->id . " "
            . $hash . " " . $tanFile . " " . $count, $output, $return_var);
        }
      } else {
        $return_line = exec("../parser_src/upload_parser " . escapeshellarg($filepath) . " " . $user->id, $output, $return_var);
      }
    }
  }

?>
