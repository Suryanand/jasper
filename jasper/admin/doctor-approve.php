<?php 
include("config.php"); 
$id=$_GET['id']; 
mysqli_query($con,"update tbl_comments set activeStatus='1' where id='".$id."'") ;
header('location:doctor-comment.php'); 
?>