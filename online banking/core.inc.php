<?php
//reusable functions
ob_start();
session_start();
$current_file = $_SERVER['SCRIPT_NAME']; 
$http_referer = $_SERVER['HTTP_REFERER'];

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function loggedin() {
	if(isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])){
		return true;
	} else {
		return false;
	}
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

function getusersfield($field){
$query = "SELECT $field FROM users WHERE UserID = '".$_SESSION['user_id']."'";
	if($query_run = mysql_query($query)){
		if($query_result = mysql_result($query_run,0,$field)){
			return $query_result;
		}
	}
}

?>