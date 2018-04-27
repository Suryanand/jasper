<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include_once('functions.php');
if($userType != 1) 
{
	header('location: index.php');
}

//get image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Admin Logo'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$absolutePath=$row["absolutePath"];
$default_firm_image=$row["default_firm_image"];
$default_doctor_image=$row["default_doctor_image"];
$delivery_charge=$row["delivery_charge"];
$free_delivery_amount=$row["free_delivery_amount"];
$bannerType=$row["bannerType"];

$rslt=mysqli_query($con,"select * from admin_title");
$row=mysqli_fetch_assoc($rslt);
$adminTitle=$row["title"];
$adminLogo=$row["adminLogo"];

// new user submit
if(isset($_POST["submit"]))
{

	$absolutePath=mysqli_real_escape_string($con,$_POST["absolutePath"]);
	$delivery_charge=mysqli_real_escape_string($con,$_POST["delivery_charge"]);
	$free_delivery_amount=mysqli_real_escape_string($con,$_POST["free_delivery_amount"]);
	$adminTitle=mysqli_real_escape_string($con,$_POST["adminTitle"]);
	$bannerType=mysqli_real_escape_string($con,$_POST["bannerType"]);
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images");
	if($image["default_firm_image"]){
		$upload = $image->upload(); 
		if($upload){
			$default_firm_image=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	$image2 = new UploadImage\Image($_FILES);
	$image2->setLocation("../uploads/images");
	if($image2["default_doctor_image"]){
		$upload = $image2->upload(); 
		if($upload){
			$default_doctor_image=$image2->getName().".".$image2->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	$image3 = new UploadImage\Image($_FILES);
	$image3->setLocation("img");
	if($image3["adminLogo"]){
		$upload = $image3->upload(); 
		if($upload){
			$adminLogo=$image3->getName().".".$image3->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	mysqli_query($con,"update admin_title set title='".$adminTitle."',adminLogo='".$adminLogo."'");
		
	mysqli_query($con,"update tbl_settings set delivery_charge='".$delivery_charge."',free_delivery_amount='".$free_delivery_amount."',absolutePath='".$absolutePath."',default_doctor_image='".$default_doctor_image."',default_firm_image='".$default_firm_image."',bannerType='".$bannerType."'") or die(mysqli_error($con));
	header('location: general-settings.php#stuff');
}
if(isset($_POST["deleteLogo"]))
{
	mysqli_query($con,"update admin_title set adminLogo=''");
	unlink("img/".$adminLogo);
	header('location: general-settings.php#stuff');
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
				<h5 class="widget-name"><i class="icon-picture"></i>General Settings</h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid" id="storeCurrency">                                
                               
								<div class="control-group">
	                                <label class="control-label">Absolute Path: </label>
	                                <div class="controls">
	                                    <input class="styled" type="text" name="absolutePath"  value="<?php echo $absolutePath; ?>"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Admin Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $adminTitle;?>" class="validate[required] input-large" name="adminTitle" id="adminTitle"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Admin Logo:<br>w: <?php echo $imageWidth;?>px h: <?php echo $imageHeight;?>px</label>
	                                <div class="controls">
	                                    <?php if(!empty($adminLogo)) {?><img src="img/<?php echo $adminLogo; ?>" width="100" height="75" /> 
										<button type="submit" name="deleteLogo" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" name="adminLogo" id="adminLogo" class="validate[custom[images]]">									
	                                </div>									
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Delivery Charge: </label>
	                                <div class="controls">
	                                    <input class="styled" type="text" name="delivery_charge"  value="<?php echo $delivery_charge; ?>"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Min for Free Delivery: </label>
	                                <div class="controls">
	                                    <input class="styled" type="text" name="free_delivery_amount"  value="<?php echo $free_delivery_amount; ?>"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Default Hospital/Clinic Image: </label>
	                                <div class="controls">
										<?php if(!empty($default_firm_image)){?><img src="../uploads/images/<?php echo $default_firm_image;?>" width="100"/><?php }?>
	                                    <input type="file" name="default_firm_image"  value="1"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Default Doctor Image: </label>
	                                <div class="controls">
										<?php if(!empty($default_doctor_image)){?><img src="../uploads/images/<?php echo $default_doctor_image;?>" width="100"/><?php }?>
	                                    <input type="file" name="default_doctor_image"  value="1"/>
	                                </div>
	                            </div>
								
								
								<div class="control-group hide">
	                                <label class="control-label">Banner Type:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($bannerType == 1) {echo "checked";}?> checked name="bannerType" id="full" value="1" data-prompt-position="topLeft:-1,-5"/>
											Full Width
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($bannerType == 2) {echo "checked";}?> name="bannerType" id="box" value="2" data-prompt-position="topLeft:-1,-5"/>
											Box Structure
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <div class="controls">
										<button type="submit" class="btn btn-info" name="submit">Save</button>
									</div>
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

</body>
</html>
