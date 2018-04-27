<?php
session_start();
//session_destroy();
require_once("config.php"); // include the library file
$body="";
$signature="";
$subject="";
if(isset($_POST["mailType"]))
{
	$mailType=$_POST["mailType"];
	$rslt=mysqli_query($con,"select * from tbl_mails where id='".$mailType."'");
	if(mysqli_num_rows($rslt)>0)
	{
		$row = mysqli_fetch_assoc($rslt);
		$emailFrom =$row["emailFrom"];
		$body = $row["body"];
		$signature = $row["signature"];
		$subject = $row["subject"];
	}
	$arr = array('emailFrom' => $emailFrom, 'subject' => $subject, 'body' => $body, 'signature' => $signature);
	echo json_encode($arr);
}
?>