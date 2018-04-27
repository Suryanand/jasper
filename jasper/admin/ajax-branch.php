<?php
include_once('config.php');
$PostType=$_GET['PostType'];
$q= mysqli_query($con,"select * from tbl_firm where id='" . $PostType . "'");
$RowP=mysqli_fetch_array($q);
$companyName=$RowP['companyName'];
$profile=$RowP['profile'];
?>
<div class="control-group">
										 <label class="control-label">Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											<input type="text" style="width:100%" value="<?php echo $companyName?>" class="validate[required] input-xlarge"  name="companyName" id="HideValueFrank"/>
										 </div>
									</div>									
									<div class="control-group">
										<label class="control-label">Profile: <span class="text-error">*</span></label>
										<div class="controls">
										<textarea rows="5" cols="5" name="profile" id="HideValueFrank" class="validate[] input-xlarge"><?php echo $profile;?></textarea>
										</div>
									</div>
<script type="text/javascript">	
CKEDITOR.replace('profile');        
</script>