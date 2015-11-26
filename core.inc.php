<?php
//reusable functions
ob_start();
session_start();
$current_file = $_SERVER['SCRIPT_NAME'];

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isLoggedIn() {
	return isset($_SESSION['user']);
}

function getUser() {
	return $_SESSION['user'];
}

function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
