<?php
include_once('config.php');
include_once('session.php');
include('get-user.php'); /* Geting logged in user details*/
// set insert specification
if(isset($_POST["category"]) && isset($_POST["specification"])){
	$category=$_POST["category"];	
	$specification=$_POST["specification"];
	$rslt=mysqli_query($con,"select * from tbl_specifications where fkCategoryId='".$category."' and specification='".$specification."'");
	if(mysqli_num_rows($rslt))
	{
		$_SESSION["err"]="1";
	}
	else
	{
		mysqli_query($con,"insert into tbl_specifications (specification,fkCategoryId) values('".$specification."','".$category."')") or die(mysqli_error($con));
	}
}
// update specification
if(isset($_POST["specId"]) && isset($_POST["specification"])){
	$specId=$_POST["specId"];	
	$specification=$_POST["specification"];	
	mysqli_query($con,"update tbl_specifications set specification='".$specification."' where id='".$specId."'") or die(mysqli_error($con));
	$rslt=mysqli_query($con,"select fkCategoryId from tbl_specifications where id='".$specId."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["fkCategoryId"];
}

// select specification for category
if(isset($_POST["catId"])){
	$category=$_POST["catId"];
}

// delete specification
if(isset($_POST["delSpecId"])){
	$specId=$_POST["delSpecId"];
	$rslt=mysqli_query($con,"select fkCategoryId from tbl_specifications where id='".$specId."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["fkCategoryId"];
	mysqli_query($con,"delete from tbl_specifications where id='".$specId."'");
}

?>
<div class="control-group">
	                                <label class="control-label">Category: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="category" onChange="catSpec(this.value)" id="category" class="validate[required] options" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Category</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT t1.categoryId AS catId,
TRIM(LEADING '-> ' FROM CONCAT(IFNULL(t4.categoryName, ''), '-> ', IFNULL(t3.categoryName, ''), '-> ', IFNULL(t2.categoryName, ''), '-> ', IFNULL(t1.categoryName, ''))) AS parentCategory 
FROM tbl_category t1 
LEFT JOIN tbl_category t2 ON t1.parentId=t2.categoryId 
LEFT JOIN tbl_category t3 ON t2.parentId=t3.categoryId 
LEFT JOIN tbl_category t4 ON t3.parentId=t4.categoryId
WHERE t1.activeStatus=1
ORDER BY parentCategory
");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["catId"];?>"<?php if($category==$row["catId"]) echo "selected"; ?>><?php echo $row["parentCategory"];?></option>
                                            <?php } ?>
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Attribute Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-large" name="spec" id="spec"/>					
										 <?php 
										if($permission["Product Attribute"] >1)
										{
										?>
										<button type="button" onClick="saveSpec()" class="btn btn-info" name="submit">Add</button>
										<?php }?>
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">Attribute already created</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
	                                </div>
                                    <?php $rslt=mysqli_query($con,"select * from tbl_specifications where fkCategoryId='".$category."' order by id desc");
								while($row=mysqli_fetch_assoc($rslt))
								{
								 ?>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row["specification"]; ?>" class="validate[required] input-large" name="spec<?php echo $row["id"]; ?>" id="spec<?php echo $row["id"]; ?>"/>					
										 <?php 
										if($permission["Product Attribute"] >2)
										{
										?>
										<button type="button" title="update" onClick="updateSpec(this)" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="update"><i class="fam-tick"></i></button>
										<?php }
										if($permission["Product Attribute"] ==4)
										{
										?>
										<button type="button" title="remove" onClick="deleteSpec(this)" value="<?php echo $row["id"]; ?>" class="remove-button-icon" name="delete"><i class="fam-cross"></i></button>
										<?php } ?>
	                                </div>
                                <?php }?>
	                            </div>
