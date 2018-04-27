<?php include_once('admin/config.php');
//get about page details
$rslt=mysqli_query($con,"select t1.*,t2.description as desc2 from tbl_pages t1 left join tbl_page_description t2 on t1.id=t2.pageId where t1.id=2");
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
										<h2 class="wow fadeInDown">Health & Fitness</h2>
										<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">Home</a></li>                                            
                                            <li class="active">Health & Fitness</li>
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
<!--				<div class="row">
					<div class="col-md-12 ">
						<div class="section-title wow fadeIn">
							<p>Our comprehensive</p>
							<h2>Insurance</h2>
						</div>
					</div> 
				</div>
<nav class="navbar navbar-default" role="navigation">
  <div class="container">
     Brand and toggle get grouped for better mobile display 
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-slide-dropdown">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

     Collect the nav links, forms, and other content for toggling 
    <div class="collapse navbar-collapse" id="bs-slide-dropdown">
        <ul class="nav navbar-nav">
            <li><a href="#">Fitness Trainers</a></li>
            <li><a href="#">Gymnasiums</a></li>
            <li><a href="#">Nutritionists</a></li>
        	<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fitness Activities <span class="caret"></span></a>				
			  <ul class="dropdown-menu" role="menu">
                <li><a href="#">Yoga</a></li>
                <li><a href="#">Boot Camps</a></li>
                <li><a href="#">Dance Class</a></li>
              </ul>                
            </li>
            <li><a href="#">Sports</a></li>
        </ul>
        
   
    </div> /.navbar-collapse 
  </div> /.container-fluid 
</nav>                                -->
<div class="row">
<div id="departments" class="health-care-content-block"> <!-- Start Content Block -->
<div class="container"> <!-- Start container -->
<!--<div class="row">
<div class="col-md-12 ">  Start Section Title 
<div class="section-title wow fadeIn">
<h2>Health & Fitness</h2>
</div>
</div>  End Section Title 
</div>-->
<div class="row" style="margin-top: -179px;">                                
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="<?php echo $absolutePath;?>fitness-trainers"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath;?>assets/img/fit1.png"/>
<h3>Fitness Trainers</h3>
<!--desc-->
</div></a>
</div>
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="<?php echo $absolutePath;?>gymnasiums"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath;?>assets/img/fit2.png"/>
<h3>Gymnasiums</h3>
<!--desc-->
</div></a>
</div> 
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="<?php echo $absolutePath;?>nutritionists"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath;?>assets/img/fit3.png"/>
<h3>Nutritionists</h3>
<!--desc-->
</div></a>
</div>
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="#"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath;?>assets/img/fit4.png"/>
<h3>Fitness Activities</h3>
<!--desc-->
</div></a>
</div>
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="#"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath;?>assets/img/fit5.png"/>
<h3>Sports</h3>
<!--desc-->
</div></a>
</div>     
</div>
</div> <!-- End Container -->
</div> <!-- End Features Section -->                               
</div>
			</div> <!-- End Container -->
		</div> <!-- End Features Section -->
				
		<!-- Start Hero Section -->
		
		
		
				
		
		
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
                $(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
                </script>
	</body>
</html>