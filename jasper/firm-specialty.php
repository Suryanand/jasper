<?php 
include_once('admin/config.php');
if(isset($_POST['spec'])){
$comp=$_POST["comp"];
$spec=$_POST["spec"];
//echo $comp; echo $spec;die;
}
else{
header('location:'.$absolutePath.'');
}
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_firm_image=$row["default_firm_image"];
$default_doctor_image=$row["default_doctor_image"];
?>
<?php
$rslt=mysqli_query($con,"select * from tbl_category where id='$comp'");
$row=mysqli_fetch_assoc($rslt);
$categoryName=$row["categoryName"];
$companyType=$row["id"];
$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	
if($companyType==1)
	$url="hospitals/";
if($companyType==2)
	$url="clinics/";
if($companyType==3)
	$url="pharmacy/";
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
										<h2 class="wow fadeInDown"><?php echo "Search Results";?></h2>
										<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">Home</a></li>                                            
                                            <li class="active"><?php echo "Search Result";?></li>
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
										
					<div class="col-md-12">
					<?php 
					$rslt=mysqli_query($con,"select * from tbl_firm where activeStatus=1 and specialty like '%".$spec."%' and companyType='$comp'");
					while($row=mysqli_fetch_assoc($rslt))
					{
						$image=$absolutePath."uploads/images/firms/".$row["image"];
						if(empty($row["image"]))
							$image=$absolutePath."uploads/images/".$default_firm_image;
						$crop_str='...';
						$n_chars=200;
						$buff=strip_tags($row['profile']);
						
						 if(strlen($buff) > $n_chars)
						{
							$cut_index=strpos($buff,' ',$n_chars);
							$buff=trim(substr($buff,0,($cut_index===false? $n_chars: $cut_index+1))).$crop_str;
						}
					?>
					<div class="col-md-2">
                        <img src="<?php echo $image;?>" style="width:150px;height:150px">
                    </div>
					<div class="col-md-10">
                        <a href="<?php echo $absolutePath.$url.$row["urlName"];?>"><h3><?php echo $row["companyName"];?></h3></a>
						<p><?php echo $row["area"].", ".$row["location"];?></p>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>
						<?php echo $buff;?>
                    </div>
					<br clear="all"/>
					<hr>
					<?php }					
					?>

					<?php 
					if(mysqli_num_rows($rslt)==0) echo "No list available";
					?>
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