<?php
$user_id = intval($_GET['user_id']);
$user_id = escapeshellarg($user_id);
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="scs.jar"');
readfile("/tmp/". $user_id ."/scs.jar", "r");
exec("rm -rf /tmp/". $user_id ."/", $output);
?>
