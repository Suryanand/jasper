<?php
include('config.php');
$id=$_GET['id'];
$type=$_GET['type'];
mysqli_query($con,"delete from tbl_trainer_education where id='".$id."'");
echo "<script>location.href = 'edit-trainer.php?id=$type';</script>";exit();
?>