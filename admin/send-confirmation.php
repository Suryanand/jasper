<?php
$mailTo	 = $_POST['email'];
$subject = "Email Verification mail";
$headers = "From: eShop@jaspermicron.com \r\n";
$headers .= "Reply-To: eShop@jaspermicron.com \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
$message.='<div style="width:550px; background-color:#CC6600; padding:15px; font-weight:bold;">';
$message.='Email Verification mail';
$message.='</div>';
$message.='<div style="font-family: Arial;">Confiramtion mail have been sent to your email id<br/>';
$message.='click on the below link in your verification mail id to verify your account ';
$message.="<a href='http://localhost/user-confirmation.php?id=$id&email=$email&confirmation_code=$rand'>click</a>";
$message.='</div>';
$message.='</body></html>';

mail($email,$subject,$message,$headers);
?>