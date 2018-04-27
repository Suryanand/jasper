<?php
require('config.php');
$rslt=mysqli_query($con,"select * from tbl_area WHERE emirate LIKE '%".$_GET['id']."%'");
//$result = $mysqli->query($sql);
$json = [];
while($row = $rslt->fetch_assoc()){
$json[$row['area']] = $row['area'];
}
echo json_encode($json);
?>