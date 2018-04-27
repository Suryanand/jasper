<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_firm where urlName='$urlName'");
$row=mysqli_fetch_assoc($rslt);
$address = $row["address"];
	$firmImage = $row["image"];
	$companyType = $row["companyType"];
	$email  = $row["email"];
	$country = $row["country"];
	$area = $row["area"];
	$network1 = $row["network1"];
	$network2 = $row["network2"];
	$location=$row["location"];
	$companyName	=$row["companyName"];
	$profile	=$row["profile"];
	//$email	=$row["email"];
	$contactNo	=$row["contactNo"];
	$fax	=$row["fax"];
	$googleMap	=$row["googleMap"];
	$activeStatus=$row["activeStatus"];
	$branchId=$row["branchId"];
	$website=$row["website"];
	//$password=encryptIt($row["password"]);
	
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];

//$companyType=2;
if($companyType==1)
	$url="clinics/";
if($companyType==2)
	$url="hospitals/";
if($companyType==3)
	$url="pharmacy/";
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_firm_image=$row["default_firm_image"];
?>
<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en-US"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en-US"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
	<head>		
		<!-- Meta Description -->
		<meta charset="UTF-8">
		<?php include_once("includes/meta-tags.php");?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 		
		  <!-- Site Favicon --> 
		 <link rel="icon" href="<?php echo $absolutePath;?>assets/img/fav_icon.png">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/bootstrap.min.css">   
		<!-- Fontawesome -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/font-awesome.min.css"> 
		<!-- Owl Carousel -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/owl.theme.default.min.css">
		<!-- Animate css -->		
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/animate.min.css"> 
		<!-- Icon Font -->	
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/icofont.css">
		<!-- Responsive Menu css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/slicknav.min.css">		
		<!-- Custom css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/style.css">
		<!-- Responsive css -->
		<link rel="stylesheet" href="<?php echo $absolutePath;?>assets/css/responsive.css">
		<style>
		.sidebar-title{
			padding:10px;
			background:#343434;
			color:#fff;			
		}
		.filter-label input{
			margin-right:5px;
		}
		.filter-label{
			width:100%;
			font-size:14px;
			font-weight:bold;
			cursor:pointer;
			padding-left:15px;
		}
		iframe{
			width:100%;
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
				<div class="Breadcrumbs page-header-img-1"> <!-- Slider Image -->	
					<div class="bg-overlay opacity-9"></div> <!-- Slider Overlay -->
					<div class="slider-item-table">
						<div class="slider-item-table-cell">
							<div class="container">
								<div class="row">
									<div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
										<h2 class="wow fadeInDown"><?php echo $companyName;?></h2>
										<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">Home</a></li>                                            
                                            <li class="active"><?php if($companyType==1) echo "Clinics / ";elseif($companyType==2) echo "Hospitals / ";else echo "Pharmacies / ";echo $companyName;?></li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
					<div class="col-md-4">
                        <h4 class="sidebar-title">Address</h4>
						<label class="filter-label"><?php echo $address;?></label>
						<br clear="all"/>
						<h4 class="sidebar-title">Phone</h4>
						<label class="filter-label"><?php echo $contactNo;?></label>
						<br clear="all"/>
						<h4 class="sidebar-title">Fax</h4>
						<label class="filter-label"><?php echo $fax;?></label>
						<br clear="all"/>
						<h4 class="sidebar-title">Email</h4>
						<label class="filter-label"><?php echo $email;?></label>
						<br clear="all"/>
						<?php if(!empty($website)){?>
						<h4 class="sidebar-title">Website</h4>
						<label class="filter-label"><?php echo $website;?></label>
						<br clear="all"/>
						<?php }?>
						<h4 class="sidebar-title">Networks</h4>
						<?php if(!empty($network1)){?><label class="filter-label"><?php echo $network1;?></label><?php }?>
						<label class="filter-label"><?php echo $network2;?></label>
                    </div>					
					<div class="col-md-8">					
                        <?php if(!empty($firmImage)){?><img src="<?php echo $absolutePath."uploads/images/hospitals/".$firmImage;?>"><?php }?>
						<h3><?php echo $companyName;?></h3>
						<?php echo $profile;?>
						<br clear="all"/>
						<?php echo $googleMap;?>
                    					
                    </div>
				</div>
			</div> <!-- End container --> 
		</div> <!-- End Dortor Profile Section -->
        
       <!-- Start Footer Section -->
		<?php include_once("includes/footer.php");?>
		
		<!-- js scripts -->		
		<script src="<?php echo $absolutePath;?>assets/js/jquery.min.js"></script>	
		<script src="<?php echo $absolutePath;?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo $absolutePath;?>assets/js/owl.carousel.min.js"></script>		
		<script src="<?php echo $absolutePath;?>assets/js/wow.min.js"></script>
		<script src="<?php echo $absolutePath;?>assets/js/jquery.slicknav.min.js"></script>
		<script src="<?php echo $absolutePath;?>assets/js/jquery.scrollTo.min.js"></script>
		<script src="<?php echo $absolutePath;?>assets/js/active.js"></script>	
        
	</body>
</html>