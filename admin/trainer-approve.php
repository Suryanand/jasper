<?php 
include("config.php"); 
$id=$_GET['id']; 
mysqli_query($con,"update tbl_fitness_comments set activeStatus='1' where id='".$id."'") ;
header('location:trainer-comment.php'); 
?>