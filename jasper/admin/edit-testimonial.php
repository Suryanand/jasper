<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 
if($userType==2 && !isset($m_testimonials)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$editId	= $_GET["id"];


//select category to be editted
$rslt=mysqli_query($con,"select * from tbl_testimonials where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-testimonials.php');
}
$row=mysqli_fetch_assoc($rslt);
$fullName	= $row["fullName"];
$designation		= $row["designation"];
$company		= $row["company"];
$remarks		= $row["remarks"];
$testimonialImage		= $row["image"];
$altTag			= $row["altTag"];
$date 	= date('Y-m-d',strtotime($row["date"]));
$activeStatus	= $row["activeStatus"];

// new user submit
if(isset($_POST["submit"]))
{
	$fullName 	= mysqli_real_escape_string($con,$_POST["fullName"]);
	$designation	= mysqli_real_escape_string($con,$_POST["designation"]);
	$company 	= mysqli_real_escape_string($con,$_POST["company"]);
	$remarks 	= mysqli_real_escape_string($con,$_POST["remarks"]);
	$date 	= date('Y-m-d',strtotime($_POST["date"]))." ".date("H:i:s");
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);	
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	
		$image = new UploadImage\Image($_FILES);
		$image->setLocation("../uploads/images/testimonials");
		if($image["image"]){
			$upload = $image->upload(); 
			if($upload){
				$testimonialImage=$image->getName().".".$image->getMime();			
			}else{
				echo $image["error"]; 
			}
		}
		
	//echo "update tbl_testimonials set fullName='".$fullName."',altTag='".$altTag."',designation='".$designation."',company='".$company."',date='".$date."',remarks='".$remarks."',image='".$image."',updatedOn=NOW() where id='".$editId."'";
		mysqli_query($con,"update tbl_testimonials set fullName='".$fullName."',altTag='".$altTag."',designation='".$designation."',company='".$company."',date='".$date."',remarks='".$remarks."',image='".$testimonialImage."',activeStatus='$activeStatus',updatedOn=NOW() where id='".$editId."'") or die(mysql_error());
		$_SESSION["response"]="Testimonial Updated";
		echo "<script>location.href = 'manage-testimonials.php'</script>";

}
if(isset($_POST["deleteImage"]))
{
	unlink("../uploads/".$testimonialImage);
	mysqli_query($con,"update tbl_testimonials set image='' where id='".$editId."'") or die(mysql_error());
	echo "<script>location.href = 'edit-testimonial.php?id=".$editId."'</script>;";																			
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>

</head>

<body>

	<!-- Fixed top -->
	<?php include_once('top-bar.php'); ?>
	<!-- /fixed top -->


	<!-- Content container -->
	<div id="container">

		<!-- Sidebar -->
		<?php include_once('side-bar.php'); ?>
		<!-- /sidebar -->


		<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">

			    <!-- Breadcrumbs line -->
			    <?php include_once('bread-crumbs.php'); ?>
			    <!-- /breadcrumbs line -->

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->
				<h5 class="widget-name"><i class="icon-thumbs-up"></i>Edit Testimonial <a href="manage-testimonials.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $fullName;?>" class="validate[required] input-xlarge" name="fullName" id="fullName"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Designation:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $designation;?>" class="validate[] input-xlarge" name="designation" id="designation"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Company:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $company;?>" class="validate[] input-xlarge" name="company" id="company"/>					
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Date:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $date;?>" class="validate[] datepicker input-xlarge" name="date" id="date"/>					
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Remarks:<span class="text-error">*</span></label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="remarks" class="validate[required] span12"><?php echo $remarks;?></textarea>
	                                </div>
	                            </div>                               
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br> <?php echo image_size('testimonials');?></label>
	                                <div class="controls">
                                    <?php if(!empty($testimonialImage))
									{?>
                                    	<img src="../uploads/images/testimonials/<?php echo $testimonialImage; ?>" width="75" height="100" />
										<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
                                    <?php } 
									else
									{
									?>
                                    	<img src="../images/testimonials/default.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="image" id="image" class="validate[custom[images]]">
										<br><br>
	                                    <label>Alt Tag : <input type="text" value="<?php echo $altTag;?>" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 0) {echo "checked";}?>  name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 1) {echo "checked";}?> name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
											Publish
										</label>
	                                </div>
	                            </div>
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>
	                        </div>
                                                       
                            

	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
				<!-- /form validation -->
				<!-- form submition - add new user-->
				<?php
				?>
				<!-- /form submition -->
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script type="text/javascript">	
	CKEDITOR.replace('remarks');
	</script>
</body>
</html>
