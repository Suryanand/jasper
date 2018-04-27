<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="table-overflow">
<table class="table table-striped table-bordered tcenter" id="txtHint">
<thead>
<tr>
<th STYLE="width:5%;text-align:center;">In Patient</th>
<th STYLE="width:5%;text-align:center;">Out Patient</th>                                   
</tr>
</thead>
<tbody>
<?php
$q = intval($_GET['q']);
include("config.php");
$rslt=mysqli_query($con,"select * from tbl_insurance_status where networkId='$q'");
$row=mysqli_num_rows($rslt);
if ($row>0) 
{	
while($row = mysqli_fetch_array($rslt)) {
$outPatient=$row['outPatient']; 
$inPatient=$row['inPatient']; 
$networkId=$row['networkId']; 
}
?>
<tr>
<?php
if($inPatient!=1) {
?>
<td STYLE="width:5%;"><input type='checkbox' value='1' name='inPatient'></td>
<?php
} 
else{
?>
<td STYLE="width:5%;"><input type='checkbox' value='1' name='inPatient' checked></td>
<?php	
}
?>
<?php
if($outPatient!=1)
{
?>
<td><input type='checkbox' value='1' name='outPatient'></td>
<?php
}
else {
?>
<td><input type='checkbox' value='1' name='outPatient' checked></td>
<?php	
}
?>
</tr>
</tbody>
</table>
<?php 
}
else {
?>
<tr>
<td><input type='checkbox' value='1' name='inpatient'></td>
<td><input type='checkbox' value='1' name='outpatient'></td>
</tr>
</tbody>
</table>
<?php } ?>
<?php
mysqli_close($con);
?>
<style>
.tcenter
{
text-align: center !important;	
}
.tleft
{
text-align: left !important;	
}
</style>
</body>
</html>