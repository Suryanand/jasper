<?php
include_once('config.php');
include_once('session.php');
// set insert specification
if(isset($_POST["province"])){
	$parent=$_POST["province"];	
    ?>
	<option value="">Select Area</option>
	<?php 
	$rslt=mysqli_query($con,"select * from tbl_locations where parentId='".$parent."' and level='1'");
	while($row=mysqli_fetch_assoc($rslt))
	{ ?>
        <option value="<?php echo $row["id"];?>"><?php echo $row["location"];?></option>
	<?php
	}?>
	<?php 
}
?>