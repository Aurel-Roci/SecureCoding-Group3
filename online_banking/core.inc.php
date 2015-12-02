<?php
//reusable functions
require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/PHPMailerAutoload.php');
require('fpdf/fpdf.php');
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


function sendmail($email,$password, $tans, $lastname){
          $message = "Dear Mr/Ms ".$lastname.", for your new online banking account we send you your TAN codes.\n".$tans."\nBest regards,\nYour online banking team";
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

function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}

?>
