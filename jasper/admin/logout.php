<?php /* unset and destroy sessions and redirect to login page*/
include("config.php");
session_start();
$goto="location:login.php";
if($_SESSION['userType']!=3)
{
$goto="location:login.php";
}
      unset($_SESSION['username']);  
      unset($_SESSION['userType']);  
      session_destroy();
header($goto);
exit();
?>