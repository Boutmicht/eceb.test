<?php
require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$mail=new PHPMailer(true); // Passing `true` enables exceptions
 
//settings
$mail->SMTPDebug=0; // Enable verbose debug output
$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true; // Enable SMTP authentication
$mail->Username='mx971507@gmail.com'; // SMTP username
$mail->Password='AQWzsx123'; // SMTP password
$mail->SMTPSecure='ssl';
$mail->Port=465;

$mail->setFrom('mx971507@gmail.com', 'EM EX');

//recipient
$mail->addAddress('mr.boutmicht@gmail.com', 'mouhcine boutmicht');     // Add a recipient

//content
$mail->isHTML(true); // Set email format to HTML
$mail->Subject='Here is the subject';
$mail->Body='This is the HTML message body <b>in bold!</b>';
$mail->AltBody='This is the body in plain text for non-HTML mail clients';

if ($mail->send()) {
echo 'Message has been sent';
}
  

?>
