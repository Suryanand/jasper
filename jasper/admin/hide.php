<?php 
include("config.php"); 
$id=$_GET['id']; 
$eid=$_GET['eid']; 
mysqli_query($con,"update tbl_category set showBanner='0' where id='".$id."'") ;
header('location:edit-banner.php?id='.$eid); 
?>