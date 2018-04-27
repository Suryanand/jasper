<?php include_once("admin/config.php");?>
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
										<h2 class="wow fadeInDown">Latest HEALTH NEWS</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">News</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
       <!-- Start blog Post Section -->
		<div id="articals" class="health-care-content-block"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
				<?php 
		$rslt=mysqli_query($con,"select * from tbl_news where activeStatus=1 order by publishDate desc");
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
					<div class="col-sm-6 col-md-6 ">
						<div id="blog-page" class="blog-post-box wow fadeIn"> <!-- Post Box -->
							<div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/news/<?php echo $row["image"];?>);"></div> <!-- Post Image -->
							<div class="post-content">
								<h3><a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."news/".$row["urlName"];?>"><?php echo $row["title"];?></a></h3>						
								<p><?php echo $buff;?> </p>
								<!--&#x25cf; <li class="cs"> 203 Likes </li>
        						 &#x25cf; <li class="cs"> 21110 Views</li>-->
								 <p>
								<a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."news/".$row["urlName"];?>" class="health-care-btn view-all-btn wht">Read More
								</a>
                                </p>
							</div>
						</div>						
					</div>	
		<?php }?>
					
				</div>
                <!--Start Site Pageination-->
                <div class="row">
                    <div class="col-md-12">
                         <nav class="site-pageination" aria-label="Page navigation">
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div><!--End Site Pageination-->
			</div> <!-- End Container -->
		</div> <!-- End blog Post Section -->
		
		
		
				
		
		
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