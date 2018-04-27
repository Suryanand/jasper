<?php
include_once('config.php');
include_once('session.php');

// select tags for category
if(isset($_POST["catId"])){
	$print="";
	$category=$_POST["catId"];
}
if(isset($_POST["delId"]))
{
	$rslt=mysqli_query($con,"select * from tbl_tags where id='".$_POST["delId"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["fkCategoryId"];
	mysqli_query($con,"delete from tbl_tags where id='".$_POST["delId"]."'");
}
?>
<div class="well row-fluid">                            	                                                                
	<div class="control-group span4">
<?php	
	$i=0;
	$rslt=mysqli_query($con,"select * from tbl_tags where fkCategoryId='".$category."' order by tagName asc");
	while($row=mysqli_fetch_assoc($rslt))
	{
		$i++;
	?>	
			<label class="control-label" style="width:200px;"><?php echo $row["tagName"];?></label>
	        <div class="controls">
				<label class="radio inline"  style="margin-left:20px;">
					<button type="button" title="remove" onClick="deleteTag(this)" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="delete"><i class="fam-cross"></i></button>
				</label>
	        </div><br>
	<?php
	if($i%10==0)
		echo '</div><div class="control-group span4">';
	}?>
	</div>
</div>