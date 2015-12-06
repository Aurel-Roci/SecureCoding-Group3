<?php
$user_id = $_GET['user_id'];
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="scs.jar"');
readfile("/tmp/". $user_id ."/scs.jar", "r");
exec("rm /tmp/". $user_id ."/scs.jar", $output);
?>
