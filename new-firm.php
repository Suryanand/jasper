<?php 
session_start();
include_once('admin/config.php');
include_once('admin/functions.php');
include_once('admin/uploadimage.php');

if(!isset($_SESSION["user_id"]) || $_SESSION["user_type"]!=2)
{
	header('location: '.$absolutePath);
}
if(isset($_POST["submit"]))
{
	$companyType = mysqli_real_escape_string($con,$_POST["companyType"]);
	$country = mysqli_real_escape_string($con,$_POST["country"]);
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$area = mysqli_real_escape_string($con,$_POST["area"]);
	$network1 = mysqli_real_escape_string($con,$_POST["network1"]);
	$network2 = mysqli_real_escape_string($con,$_POST["network2"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$companyName	=mysqli_real_escape_string($con,$_POST["companyName"]);
	$profile	=mysqli_real_escape_string($con,$_POST["profile"]);
	$email	=mysqli_real_escape_string($con,$_POST["email"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
	$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$branchId=mysqli_real_escape_string($con,$_POST["branchId"]);
	$firmImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("uploads/images/firms");
	if($image["firmImage"]){
		$upload = $image->upload(); 
		if($upload){
			$firmImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$companyName;
	$urlName = set_url_name($urlName);

	
	mysqli_query($con,"insert into tbl_firm(userId,location,companyName,address,contactNo,fax,googleMap,activeStatus,titleTag,metaDescription,metaKeywords,urlName,companyType,country,area,network1,network2,image,branchId)values('".$_SESSION["user_id"]."','".$location."','$companyName','$address','$contactNo','$fax','$googleMap','$activeStatus','".$titleTag."','$metaDescription','$metaKeywords','$urlName','$companyType','$country','$area','$network1','$network2','$firmImage','$branchId')") or die(mysqli_error($con));
	$_SESSION["response"]='Hospital Saved';
	echo "<script>location.href = '".$absolutePath."user-home'</script>";exit();
	
}
?>
<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en-US"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en-US"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
	<head>		
		<!-- Meta Description -->
		<meta charset="UTF-8">
		<meta name="description" content="Health Care - Medical & Doctor Html5 Template">
		<meta name="keywords" content=" clinic, dental, family doctor, health, hospital, medical, medicine">
		<meta name="developer" content="Arpon Das">
		<meta name="author" content="UI Cafe">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 		
		<!-- Site Title -->
		<title>Alodawa Medical & Medicine Portal</title>  <!-- Site Favicon --> 
		 <link rel="icon" href="assets/img/fav_icon.png">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">   
		<!-- Fontawesome -->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css"> 
		<!-- Owl Carousel -->
		<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
		<!-- Animate css -->		
		<link rel="stylesheet" href="assets/css/animate.min.css"> 
		<!-- Icon Font -->	
		<link rel="stylesheet" href="assets/css/icofont.css">
		<!-- Responsive Menu css -->
		<link rel="stylesheet" href="assets/css/slicknav.min.css">		
		<!-- Custom css -->
		<link rel="stylesheet" href="assets/css/style.css">
		<!-- Responsive css -->
		<link rel="stylesheet" href="assets/css/responsive.css">
<style>
.radio-label{
	margin-right:20px;
}
</style>		
	</head>
	
	<body>	
		<!-- Start Site Preloader Area -->
		<div class="site-preloader">
			<div class="spinner"></div>
		</div>
		<!-- End Site Preloader Area -->
	<!-- Start Header Area -->
		<?php include_once("includes/header.php");?>        
        <!-- Start Breadcrumb Section -->
		<div class="home-slider-wrapper" id="top"> 
			<div class="home-slider"> <!-- Start Slider -->
				<div class="Breadcrumbs page-header-img-1" style="height:350px;"> <!-- Slider Image -->	
					<div class="bg-overlay opacity-9"></div> <!-- Slider Overlay -->
					<div class="slider-item-table">
						<div class="slider-item-table-cell">
							<div class="container">
								<div class="row">
									<div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
										<h2 class="wow fadeInDown">Register Your Firm</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Register</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
        <!-- Start Contact Form Section -->
		<div id="appoiintments" class="health-care-content-block solid-color no-padding-1"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				
				<div class="row">
					<div class="contact-form col-md-3" style="margin-top:25px;"> <!-- Start Form Group -->
					<h3>Menu</h3>
						<?php include_once("includes/side-menu.php");?>
					</div>
					<div class="contact-form col-md-9" style="margin-top:25px;"> <!-- Start Form Group -->
						
						<form action="" method="post">
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Name Box -->								
								<select name="companyType" class="form-control">
								<option value="">Category</option>
								<?php $rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1");
								while($row=mysqli_fetch_assoc($rslt))
								{?>
									<option value="<?php echo $row["id"];?>"><?php echo $row["categoryName"];?></option>
								<?php }?>
								</select>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Name Box -->
								<select class="form-control" name="branchId">
									<option value="0">Branch of None</option>
									<?php $rslt=mysqli_query($con,"select * from tbl_firm where userId='".$_SESSION["user_id"]."'");
									while($row=mysqli_fetch_assoc($rslt))
									{?>
									<option value="<?php echo $row["id"];?>" class="firms firm<?php echo $row["companyType"];?>"><?php echo $row["companyName"];?></option>
									<?php }?>
								</select>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Name Box -->
								<p><input type="text" name="companyName" required class="form-control" placeholder="Name"></p>							
							</div>						
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><textarea placeholder="Address" class="form-control" name="address"></textarea></p>
							</div>						
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Name Box -->
								<select class="form-control" name="country">
									<option>Select Country</option>
									<?php $rslt=mysqli_query($con,"select * from tbl_countries");
									while($row=mysqli_fetch_assoc($rslt))
									{?>
									<option value="<?php echo $row["countryName"];?>"><?php echo $row["countryName"];?></option>
									<?php }?>
								</select>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="location" required type="text" class="form-control" placeholder="Location"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="area" required type="text" class="form-control" placeholder="Area"></p>
							</div>						
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><textarea placeholder="Profile" class="form-control" name="profile"></textarea></p>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="contactNo" required type="text" class="form-control" placeholder="Contact No"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="fax" type="text" class="form-control" placeholder="Fax"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="email" required type="email" class="form-control" placeholder="Email"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="network1"  type="text" class="form-control" placeholder="Network 1"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="network2"  type="text" class="form-control" placeholder="Network 2"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><textarea placeholder="Google Map Iframe" class="form-control" name="googleMap"></textarea></p>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="firmImage" type="file" class="form-control" placeholder="Firm Image"></p>
							</div>						
						</div>
						<hr>
						<h4 style="padding-left:15px;">SEO</h4>
						<hr>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="urlName"  type="text" class="form-control" placeholder="URL Name"></p>
							</div>						
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="titleTag"  type="text" class="form-control" placeholder="Title Tag"></p>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><textarea placeholder="Meta Description" class="form-control" name="metaDescription"></textarea></p>
							</div>
						</div>

						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><textarea placeholder="Meta Keywords" class="form-control" name="metaKeywords"></textarea></p>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="appoiintments-form"> <!-- Name Box -->
								<label class="radio-label"><input type="radio" name="activeStatus" value="1" class=""> Publish</label>
								<label class="radio-label"><input type="radio" name="activeStatus" value="0" class=""> Draft</label>
							</div>						
						</div>
						<div class="col-sm-6 col-md-6"> <!-- Submit Button Box -->
							<div class="appoiintments-form">
								<input type="submit" name="submit" class="health-care-btn submit-btn" value="Submit">
							</div>
						</div>
						</form>
					</div> <!-- End Input Box -->
					
				</div> <!-- End Form Group -->
			</div>
		</div> <!-- End Container -->
	</div> <!-- End Contact Form Section -->
        
				
        
       <!-- Start Footer Section -->
		<?php include_once("includes/footer.php");?>
		
		<!-- js scripts -->		
		<script src="assets/js/jquery.min.js"></script>	
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/owl.carousel.min.js"></script>		
		<script src="assets/js/wow.min.js"></script>
		<script src="assets/js/jquery.slicknav.min.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="assets/js/active.js"></script>		
		<script>
		$(".ctype").click(function(){
			$(".firms").hide();
			var id=$(this).val();
			$(".firm"+id).show();
		});
		</script>
	</body>
</html>