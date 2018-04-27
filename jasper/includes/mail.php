<?php
require 'includes/PHPMailerAutoload.php';
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

/* check mail type SMTP or PHP Mailer - starts*/
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
if($row["mailType"]==2)
{
	// SMTP is enabled
	//$mail->SMTPDebug = 2;	
	$mail->isSMTP();                                    	// Set mailer to use SMTP
	$mail->Host = $row["smtpServer"];  						// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               	// Enable SMTP authentication
	$mail->Username = $row["smtpUser"];                 	// SMTP username
	$mail->Password = $row["smtpPassword"];                 // SMTP password
	if($row["smtpSSL"]==1)
		$mail->SMTPSecure = 'ssl';                          // ssl is enabled
	else
		$mail->SMTPSecure = 'none';							// ssl disabled
	$mail->Port = $row["smtpPort"];                                    // TCP port to connect to
}
/* check mail type SMTP or PHP Mailer - ends*/


$mail->From = $fromEmail;									// From email id
$mail->FromName = $fromName;								// From Name
$mail->addAddress($toEmail, $toName);     					// Add a recipient and name
$mail->addReplyTo($fromEmail, $fromName);					// Reply to from 
//$mail->addBCC('bcc@example.com');							// bcc address
if(isset($cc) && !empty($cc))
{
	$mail->addCC($cc);
}
if(isset($cc2) && !empty($cc2))
{
	$mail->addCC($cc2);
}
if(isset($resume))											// check atachment(resume) available or not
	$mail->addAttachment('resume/'.$resume);         		// Add attachments

$mail->isHTML(true);                                  		// Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $body;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	if(!isset($cart))
		echo "<script>alert('".$response."');</script>";
}