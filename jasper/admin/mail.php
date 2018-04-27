<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 1;                               // Enable verbose debug output
$rslt=mysqli_query($con,"select companyName from tbl_company_address limit 1");
$row=mysqli_fetch_assoc($rslt);
$companyName=$row["companyName"];

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
if($row["mailType"]==2)
{
//$mail->SMTPDebug = 2;	
$mail->isSMTP();                                    	// Set mailer to use SMTP
$mail->Host = $row["smtpServer"];  						// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               	// Enable SMTP authentication
$mail->Username = $row["smtpUser"];                 	// SMTP username
$mail->Password = $row["smtpPassword"];                 // SMTP password
if($row["smtpSSL"]==1)
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
else
	$mail->SMTPSecure = 'none';
$mail->Port = $row["smtpPort"];                                    // TCP port to connect to
}

$mail->From = $emailFrom;
$mail->FromName = $companyName;

foreach($toEmail as $email)
{
	$mail->addAddress($email, "");     // Add a recipient	
}
$mail->addReplyTo($emailFrom, $companyName);
//$mail->addBCC('bcc@example.com');

if(isset($attachment))
	$mail->addAttachment('reports/'.$attachment);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $body;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	if(!isset($cart))
		echo "<script>alert('Your Mail is sent');</script>";
}