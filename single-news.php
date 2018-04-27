<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];

$rslt=mysqli_query($con,"select * from tbl_news where urlName='".$urlName."'");
$row=mysqli_fetch_assoc($rslt);
$newsTitle=$row["title"];			
$description=$row["description"];			
$image=$row["image"];			
$publishDate=$row["publishDate"];	
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
										<h2 class="wow fadeInDown">Blog Read Page</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li><a href="blog-list.php">Blog</a></li>                                            
                                            <li class="active">Single Post</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
       <!-- Start Single Post Section -->
		<div class="health-care-content-block solid-color no-padding"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
					<div class="col-md-8"> <!-- Full Post-->
						<div class="blog-single-page"> <!-- Post Box -->
							<div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/news/<?php echo $row["image"];?>);"></div> <!-- Post Image -->
							<div class="post-content">
								<h3><?php echo $newsTitle;?></h3>
                                <ul>
                                    <li><i class="fa fa-calendar"></i> <a ><?php echo date('d F, Y',strtotime($publishDate));?></a></li>
                                </ul>
								<?php echo $description;?>
							</div>
                            <!--<div class="arrow-button">
                                <a href="" class="health-care-btn left">Prev</a> 
                                <a href="" class="health-care-btn right">Next</a> 
                            </div>-->
                           
                            <div class="divider"></div>                          
                           
                           
                            
                            <div class="divider"></div> 
                            
                                                      
						</div>                        
					</div>	<!-- End Full Post-->
                    
                    <div class="col-sm-4 col-md-4"> <!-- Right Sidebar-->
                        
                        <div class="right-sidebar popular-Post-widgets"> <!-- Post Box -->
                            <h3 class="sidebar-widgets-heading">Latest News</h3>
                            <ul>
							<?php 
		$rslt=mysqli_query($con,"select * from tbl_news where activeStatus=1 and urlName!='$urlName' order by publishDate desc");
		while($row=mysqli_fetch_assoc($rslt))
		{
			
			?>
				<li><div class="side-bar-post-image"><img src="<?php echo $absolutePath;?>assets/img/sidebar_post_image1.jpg"></div><a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."news/".$row["urlName"];?>"><?php echo $row["title"];?></a></li>
		<?php }?>                                
                            </ul>
						</div>	
					</div>	<!-- End Right Sidebar-->									
				</div>                
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
		
		<script>
			$(document).ready(function(){
			  $('.nav li a, .home-slider a, .single-service-item a').click(function() {
				if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
				&& location.hostname == this.hostname) {
				  var $target = $(this.hash);
				  $target = $target.length && $target
				  || $('[name=' + this.hash.slice(1) +']');
				  if ($target.length) {
					var targetOffset = $target.offset().top;
					$('html,body')
					.animate({scrollTop: targetOffset}, 1000);
				   return false;
				  }
				}
			  });
			});
		</script>
	</body>
</html>