<?php 
session_start();
include_once("admin/config.php");
include("admin/functions.php");

if(isset($_GET['vI']) && isset($_GET['ids']))
{
$emailHash=$_GET['vI'];
$email= mysqli_real_escape_string($con,decryptIt($emailHash));
$code=$_GET['ids'];

	$query=mysqli_query($con,"select * from tbl_user_login where email='$email' AND confirmationCode='$code' and activeStatus=0");
	if(mysqli_num_rows($query)>0)
	{
		mysqli_query($con,"update tbl_user_login set activeStatus='1' where email='$email'");
		$_SESSION["response"]="Account activation completed. Please login to complete your profile.";
	}

}

echo "<script>location.href = '".$absolutePath."login.php';</script>";exit();
?>