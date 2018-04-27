<?php
session_start();
if(!isset($_SESSION["username"]))
{
header('location:login.php');
exit();
}
else
{
	$_SESSION['KCFINDER'] = array(
    'disabled' => false
	);
	$username=$_SESSION["username"];
	$userType=$_SESSION["userType"];
	$clientLoginId=$_SESSION["loginId"];
}
?>