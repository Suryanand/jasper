<?php 
include_once("admin/config.php");
//get about page details
$rslt=mysqli_query($con,"select t1.*,t2.description as desc2 from tbl_pages t1 left join tbl_page_description t2 on t1.id=t2.pageId where t1.id=1");
$row=mysqli_fetch_assoc($rslt);
$pageText=$row["description"];
$pageText2=$row["desc2"];
$pageTitle=$row["pageTitle"];
$pageImage=$row["image"];
$imageAlt=$row["altTag"];
$metaDescription=$row['metaDescription'];
$metaKeywords=$row['metaKeywords'];
$titleTag=$row['titleTag'];
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
		<!-- Site Title -->
		
        <!-- Site Favicon --> 
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
	</head>
	
	<body>	
		<!-- Start Site Preloader Area -->
		<!--<div class="site-preloader">
			<div class="spinner"></div>
		</div>-->
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
										<h2 class="wow fadeInDown">About Alodawaa</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">About</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
      <!-- Start Features Section -->
		<div id="departments" class="health-care-content-block"> <!-- Start Content Block -->
			<div class="container"> <!-- Start container -->
				<!--<div class="row">
					<div class="col-md-12 ">
						<div class="section-title wow fadeIn">
							<p>Our comprehensive</p>
							<h2>Insurance</h2>
						</div>
					</div> 
				</div>-->
				<div class="row">
                 <div class="col-xs-12 col-sm-6 col-md-8"> <!-- Feature 1 -->
						<div class="single-feature-item wow fadeIn text-left mt-0">
							<!--<i class="icofont icofont-autism"></i>-->
                         <h3 class="mt-0"><?php echo $pageTitle;?></h3>							
							<?php echo $pageText;?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
						<div class="single-feature-item wow fadeIn mt-0">
							<!--<i class="icofont icofont-autism"></i>-->
                            <img src="<?php echo $absolutePath;?>uploads/images/<?php echo $pageImage;?>" alt="<?php echo $imageAlt;?>" style="    width: 100%"/>
							
						</div>
					</div>
                   
					
                   
				</div>
			</div> <!-- End Container -->
		</div> <!-- End Features Section -->
		
		
				
		
		
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
	</body>
</html>