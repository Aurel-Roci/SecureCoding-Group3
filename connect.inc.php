<?php
//connect to DB
$conn_error='Could not connect';

$mysql_host='localhost';
$mysql_user='root';
// For the virtual machine we need this password
$mysql_pass='samurai';
$mysql_db= 'securecoding';

@$conn = mysql_connect($mysql_host,$mysql_user,$mysql_pass);
@$db = mysql_select_db($mysql_db);

if(!$conn && !$db){
	die(mysql_error());
}
?>
