<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
else
{
$deleteUserId=$_GET["id"];
/* delete user */
$rslt=mysqli_query($con,"select userEmail from tbl_users where userId='$deleteUserId'");
$row=mysqli_fetch_assoc($rslt);
$email=$row['userEmail'];
if($email != $username)
{
	mysqli_query($con,"delete from tbl_users where userId='$deleteUserId'");
	mysqli_query($con,"delete from tbl_login where loginUsername='$email'");
	$_SESSION['response'] = 'User Deleted';
}
else
{
$_SESSION['response'] = 'Cannot Delete this user';	
}
echo "<script>location.href = 'manage-user.php'</script>;";												
}
?>