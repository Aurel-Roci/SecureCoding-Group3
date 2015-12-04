<?php
//reusable functions
require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/PHPMailerAutoload.php');
require('fpdf/fpdf.php');

header('X-Frame-Options: DENY');

ob_start();
session_set_cookie_params(600, dirname($_SERVER['REQUEST_URI']));
session_name('72AM7bD1sp2zIDdoEv6g');
session_start();
session_regenerate_id(true);


if (isset($_SESSION['user_agent'])) {
  if ($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
  }
} else {
  $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
}

if (isset($_SESSION['remote_ip'])) {
  if ($_SESSION['remote_ip'] != $_SERVER['REMOTE_ADDR']) {
    session_destroy();
  }
} else {
  $_SESSION['remote_ip'] = $_SERVER['REMOTE_ADDR'];
}

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

function pdfCreate($message, $password){
         require_once('fpdf/FPDF_Protection.php');
         $pdf=new FPDF_Protection();
         $pdf->SetProtection(array(),$password);
         $pdf->AddPage();
         $pdf->SetFont('Arial');
         $pdf->Multicell(330,10, $message);
         $pdfdoc = $pdf->Output('attachment.pdf', 'S');
         return ($pdfdoc);
}


function send_registration_mail($email,$password, $tans, $lastname){
          $pdf = pdfCreate($message, $password);

					$mail = new PHPMailer();
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'team3securecoding@gmail.com';                 // SMTP username
					$mail->Password = 'securecoding';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;

					$mail->From      = 'team3securecoding@gmail.com';
					$mail->FromName  = 'Team3';
					$mail->Subject   = "Welcome to online banking!";
					$mail->Body      = "Please, find the tans attached above. The Password is the one used for Registration.";
					$mail->AddAddress( $email);

					$mail->AddStringAttachment( $pdf , 'TANS.pdf' );

					return $mail->Send()?1:$mail->ErrorInfo;
}

function send_pin_mail($email,$password, $pin, $lastname){
          $message = "Dear Mr/Ms ".$lastname.", for your new online banking account we send you your Pin code to use your personal SCS.\nPin: " . $pin . "\nBest regards,\nYour online banking team";

					$mail = new PHPMailer();
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'team3securecoding@gmail.com';                 // SMTP username
					$mail->Password = 'securecoding';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;

					$mail->From      = 'team3securecoding@gmail.com';
					$mail->FromName  = 'Team3';
					$mail->Subject   = "Welcome to online banking!";
					$mail->Body      = $message;
					$mail->AddAddress( $email);

					return $mail->Send()?1:$mail->ErrorInfo;
}

function sendPasswordResetMail($email, $link, $lastname){
          $message = "Dear Mr/Ms ".$lastname.", you can reset your password by clicking on following link: <a href='".$link."'>$link</a> <br>If you didn't request a password reset please ignore this email.<br>Best regards,<br>Your online banking team"; 
					$mail = new PHPMailer();
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'team3securecoding@gmail.com';                 // SMTP username
					$mail->Password = 'securecoding';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;
					$mail->IsHTML(true);
					$mail->From      = 'team3securecoding@gmail.com';
					$mail->FromName  = 'Team3';
					$mail->Subject   = "Your online banking password reset request!";
					$mail->Body      = $message;
					$mail->AddAddress( $email);

					return $mail->Send()?1:$mail->ErrorInfo;
}

function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
