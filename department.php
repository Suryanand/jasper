<?php 
include_once('admin/config.php');

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_doctor_image=$row["default_doctor_image"];
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
			font-family: 'Ubuntu', sans-serif;
			
    font-weight: 300;
			cursor:pointer;
		}
		.contact-info h4{
			font-weight:800;
			font-family: 'Ubuntu', sans-serif;
		}
		</style>
	</head>
	
	<body>	
		<!-- Start Site Preloader Area -->
		<div class="site-preloader">
			<div class="wrapper">
	<img class="logo-svg" src="assets/img/fav_icon.png" />
		</div>
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
										<h2 class="wow fadeInDown">OUR DEPARTMENTS</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Our Departments</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
		
			<!-- Start Sidebar Area -->
<?php include_once("includes/side-bar.php");?>
<!-- End Sidebar Area -->
       
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->

			<div class="container "> <!-- Start container --> 	
                           
<div class="row">
<div id="departments" class="health-care-content-block"> <!-- Start Content Block -->
<div class="container"> <!-- Start container -->
<div class="row">
<div class="col-md-12 "> <!-- Start Section Title -->
<div class="section-title wow fadeIn">
<p>Our Departments</p>
<h2>Practice Areas</h2>
</div>
</div> <!-- End Section Title -->
</div>
<div class="row">
<?php 
$rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1 and showBanner=0");
while($row=mysqli_fetch_assoc($rslt))
{
?>                                    
<div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
<a href="<?php echo $absolutePath;?>category/<?php echo $row["urlName"];?>"><div class="single-feature-item wow fadeIn">
<img src="<?php echo $absolutePath."uploads/images/category/".$row["banner"];?>" alt="<?php echo $row['categoryName'];?>"/>
<h3><?php echo $row['categoryName'];?></h3>
<?php
if($row['description']!=''){
?>
<?php echo substr($row['description'],0,50);?>
<?php } else {?>
<p><?php echo $row['categoryName'];?></p>
<?php } ?>
</div></a>
</div>
<?php } ?>                                    
</div>
</div> <!-- End Container -->
</div> <!-- End Features Section -->                               
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
		<script>
var tl = new TimelineMax({
  repeat: -1
});

tl.add(
  TweenMax.from(".logo-svg", 2, {
    scale: 0.5,
    rotation: 360,
    ease: Elastic.easeInOut
  })
);

tl.add(
  TweenMax.to(".logo-svg", 2, {
    scale: 0.5,
    rotation: 360,
    ease: Elastic.easeInOut
  })
);
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
        <script>
		$(".gender").change(function(){
			filter();
		});
		$(".specialized").change(function(){
			filter();
		});
		$(".location").change(function(){
			filter();
		});
		function filter()
		{
			var gender = [];
			var loc = [];
			var spec = [];
				
				var i=0;
				$('input.gender:checkbox:checked').each(function () {
					i=1;
					gender.push($(this).val());					
				});
				$('input.location:checkbox:checked').each(function () {
					i=1;					
					loc.push($(this).val());
				});
				$('input.specialized:checkbox:checked').each(function () {
					i=1;
					spec.push($(this).val());
				});
				
					$.ajax({
						 type: "POST",
						 url: "ajx-scripts.php",
						 data: {gender:gender,loc:loc,spec:spec,doctor:i},
						 success: function(data) {
							 //alert(data);
						 $(".doctors_list").html(data);
						},
						error: function(x,a,y){ //add this error function
						alert(JSON.stringify(x)+" "+a);
						}
					});
								
				
		}
		</script>

	</body>
</html>