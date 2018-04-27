<?php include_once("admin/config.php");
if(isset($_GET["id"]))
	$category=$_GET["id"];
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
		<title>Alodawa Medical & Medicine Portal</title>  
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
	</head>
	
	<body>	
		<!-- Start Site Preloader Area -->
		<div class="site-preloader">
		<!--	<div class="spinner"></div>-->
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
										<h2 class="wow fadeInDown">Latest Articels</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Articels</li>
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
       <!-- Start blog Post Section -->
		<div id="articals" class="health-care-content-block"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
				<?php 
				if(isset($_GET["id"]))
					$rslt=mysqli_query($con,"select * from tbl_articles where activeStatus=1 and category='$category' order by publishDate desc");
				else
					$rslt=mysqli_query($con,"select * from tbl_articles where activeStatus=1 order by publishDate desc");
				while($row=mysqli_fetch_assoc($rslt))
				{
					$crop_str='...';
						$n_chars=150;
						$buff=strip_tags($row['description']);
						 if(strlen($buff) > $n_chars)
						{
							$cut_index=strpos($buff,' ',$n_chars);
							$buff=trim(substr($buff,0,($cut_index===false? $n_chars: $cut_index+1))).$crop_str;
						}
					?>
					<div class="col-sm-4 col-md-4 ">
						<div id="blog-page" class="blog-post-box wow fadeIn"> <!-- Post Box -->
							<div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/blog/<?php echo $row["image"];?>);"></div> <!-- Post Image -->
							<div class="post-content">
								<h3><a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>"><?php echo $row["title"];?></a></h3>						
								<p class="mt-10 mb-10"><?php echo $row["author"];?></p>   								
         									
								<p><?php echo $buff;?></p>
								<a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" class="health-care-btn view-all-btn wht">Read More
								</a>
							</div>
						</div>						
					</div>
				<?php }?>
					</div>
                                <!--Start Site Pageination-->                
			</div> <!-- End Container -->
		</div> <!-- End blog Post Section -->
		
				
		
		
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
				
	</body>
</html>