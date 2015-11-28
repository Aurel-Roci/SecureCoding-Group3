<?php
//reusable functions
require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/PHPMailerAutoload.php');
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

function sendmail($email,$tans){
						
					$mail = new PHPMailer();
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'team3securecoding@gmail.com';                 // SMTP username
					$mail->Password = 'securecoding';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;    
					$message = "Dear ".$lastname.", for your new online banking account we send you your TAN codes.\n".$tans."\nBest regards,\nYour online banking team";  
					$mail->From      = 'team3securecoding@gmail.com';
					//$mail->FromName  = 'Your Name';
					$mail->Subject   = "Welcome to online banking!";
					$mail->Body      = $message;
					$mail->AddAddress( $email);

					$file_to_attach = 'PATH_OF_YOUR_FILE_HERE';

					//$email->AddAttachment( $file_to_attach , 'TANS.pdf' );

					return $mail->Send()?1:$mail->ErrorInfo;
	}

function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
