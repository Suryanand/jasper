<?php 
include("session.php");
include("config.php");
if(isset($_GET["app"]))
{
	$loginId=$_GET["app"];
	if($userType==2)
	{
		$_SESSION["response"]="Permission Denied";
		header('location: manage-user.php');
	}
	else
	{
		mysqli_query($con,"update tbl_login set loginApprove='1' where loginId='$loginId'") or die(mysqli_error($con));
		echo "<script>location.href = 'user-profile.php?id=$loginId'</script>;";
		
	}
}

if(isset($_GET["rej"]))
{
	$loginId=$_GET["rej"];
	if($userType==2)
	{
		$_SESSION["response"]="Permission Denied";
		header('location: manage-user.php');
	}
	else
	{
		$rslt=mysqli_query($con,"select * from tbl_login where loginId='$loginId'");
		$row=mysqli_fetch_assoc($rslt);
		$userEmail=$row["loginUsername"];
		mysqli_query($con,"delete from tbl_login where loginId='$loginId'") or die(mysqli_error($con));
		mysqli_query($con,"delete from tbl_users where userEmail='$userEmail'") or die(mysqli_error($con));
		echo "<script>location.href = 'manage-user.php'</script>;";		
	}
}

if(isset($_GET["act"]))
{
	$loginId=$_GET["act"];
	if($userType==2)
	{
		$_SESSION["response"]="Permission Denied";
		header('location: manage-user.php');
	}
	else
	{
		mysqli_query($con,"update tbl_login set loginActive='1' where loginId='$loginId'") or die(mysqli_error($con));
		echo "<script>location.href = 'manage-user.php'</script>;";
		
	}}
	
if(isset($_GET["deact"]))
{
	$loginId=$_GET["deact"];
	if($userType==2)
	{
		$_SESSION["response"]="Permission Denied";
		header('location: manage-user.php');
	}
	else
	{
		mysqli_query($con,"update tbl_login set loginActive='0' where loginId='$loginId'") or die(mysqli_error($con));
		echo "<script>location.href = 'manage-user.php'</script>;";
		
	}}	
?>