<?php include_once('admin/config.php');
$rslt			= mysqli_query($con,"select * from tbl_banners where bannerId='1'");
$row			= mysqli_fetch_assoc($rslt);
$bannerText1	= $row["bannerText1"];
$bannerText2	= $row["bannerText2"];
$bannerImage	= $row["bannerImage"];
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
<style>
.testimonial-icon a h4{
	color:#ffffff !important;
}
</style>		
	</head>
	
	<body>	
		<!-- Start Site Preloader Area -->
		<!--<div class="site-preloader">
			<div class="spinner"></div>
		</div>-->
		<!-- End Site Preloader Area -->
	
		<!-- Start Header Area -->
		<?php include_once("includes/header.php");?>
		<!-- Start Hero Section -->
		<div class="home-slider-wrapper" id="top"> 
			<div class="home-slider"> <!-- Start Slider -->
				<div class="single-slider-item slider-bg-1" style="background-image:url(<?php echo $absolutePath."uploads/images/banners/".$bannerImage;?>)"> <!-- Slider Image -->	
					<div class="bg-overlay opacity-9"></div> <!-- Slider Overlay -->
					<div class="slider-item-table">
						<div class="slider-item-table-cell p-100">
							<div class="container">
								<div class="row">
									<div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
										<h1 class="wow fadeInDown"><?php echo $bannerText1;?></h1>
										<p class="wow fadeInUp"><?php echo $bannerText2;?></p>
										<div class="container">
                                        <div class="newsletter">
										<form action="search.php" method="get">
                                        <div class="col-md-3 col-xs-12 p-0 mr-5">
                                        
									<div class="input-group mb-20">
                                        <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                            <input type="text" id="subscriber-email" name="loc" placeholder="Business Bay..." class="form-control ico-01">
                                        </div>
                                        
                                    </div>
								</div>
                                <div class="col-md-6 col-xs-12 p-0 mr-5 mb-20">
                                <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                            <input type="text" id="subscriber-email2" name="key" placeholder="Search Specialities, Doctors, Clinics, Hospitals..." class="form-control ico-02">												
                                        </div>
                                </div>
                                
                                <div class="col-md-2 col-xs-12 p-0">
                               <button type="submit" class="health-care-btn slider-btn bt-1 wow fadeInUp" style="padding:12px 30px;border:none;">Search Now</button> <!-- Button -->
                                        </div>
										</form>
                                </div>
               
                                </div>
                               
                                  <div class="row dn-mob">                       
<div class="col-md-12" style="margin-left: 119px;">
<?php 
$rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1 and showBanner=1");
$num=mysqli_num_rows($rslt);
if($num<6){
while($row=mysqli_fetch_assoc($rslt))
{
?>
<div class="single-testimonial-item mt-40" style="float: left;padding: 0px 11px 3px 21px;"> <!-- Start Single Testimonial -->
<div class="testimonial-icon" style="border-right: 1px solid rgba(255, 255, 255, 0.06)"> <!-- Reating Icon -->
<a href="<?php echo $absolutePath;?>category/<?php echo $row["urlName"];?>" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0 0;"><img src="<?php echo $absolutePath."uploads/images/category/".$row["banner"];?>" style="margin-left: 50px" alt="<?php echo $row["categoryName"];?>"/>
<h4 style="margin-left: 54px;"><?php echo $row["categoryName"];?></h4></a>
</div>
</div>    
<?php } ?>
<div class="single-testimonial-item mt-40" style="float: left;padding: 0px 11px 3px 21px;"><!-- Start Single Testimonial -->
<div class="testimonial-icon" style="border-right: 1px solid rgba(255, 255, 255, 0.06)"> <!-- Reating Icon -->
<a href="<?php $absolutePath;?>doctors.php" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0 0;"><img src="assets/img/icon-06.png" style="margin-left: 50px">
<h4 style="margin-left: 54px;">Doctors </h4></a>
</div>
</div><!-- End Single Testimonial -->
<div class="single-testimonial-item mt-40" style="float: left;padding: 0px 11px 3px 21px;"><!-- Start Single Testimonial -->
<div class="testimonial-icon" style="border-right: 1px solid rgba(255, 255, 255, 0.06)"> <!-- Reating Icon -->
<a href="#" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0 0;"><img src="assets/img/ic-04.png" style="margin-left: 50px">
<h4 style="margin-left: 54px;">Others</h4></a>
</div>
</div> 
<div class="single-testimonial-item mt-40" style="float: left;padding: 0px 11px 3px 21px;"><!-- Start Single Testimonial -->
<div class="testimonial-icon" style="border-right: 1px solid rgba(255, 255, 255, 0.06)"> <!-- Reating Icon -->
<a href="health-fitness.php" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0 0;"><img src="assets/img/ftr.png" style="margin-left: 50px">
<h4 style="margin-left: 54px;">Health and Fitness</h4></a>
</div>
</div> 
<?php } else {  ?>    
<div class="testimonial owl-carousel owl-theme"><!-- Testimonial Slider Start -->
<?php 
$rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1 and showBanner=1");
$num=mysqli_num_rows($rslt);
while($row=mysqli_fetch_assoc($rslt))
{
?>
<div class="single-testimonial-item mt-40"> <!-- Start Single Testimonial -->
<div class="testimonial-icon"> <!-- Reating Icon -->
<a href="<?php echo $absolutePath;?>category/<?php echo $row["urlName"];?>"><img src="<?php echo $absolutePath."uploads/images/category/".$row["banner"];?>" style="margin-left: 50px" alt="<?php echo $row["categoryName"];?>"/>
<h4><?php echo $row["categoryName"];?></h4></a>
</div>
</div>
<?php }?>
<div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
<div class="testimonial-icon"> <!-- Reating Icon -->
<a href="<?php $absolutePath;?>doctors.php"><img src="assets/img/icon-06.png" style="margin-left: 50px">
<h4>Doctors </h4></a>
</div>
</div><!-- End Single Testimonial -->
<div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
<div class="testimonial-icon"> <!-- Reating Icon -->
<a href="#"><img src="assets/img/ic-04.png" style="margin-left: 50px">
<h4>Others</h4></a>
</div>
</div><!-- End Single Testimonial --> 
<div class="single-testimonial-item mt-40" style="float: left;padding: 0px 11px 3px 21px;"><!-- Start Single Testimonial -->
<div class="testimonial-icon" style="border-right: 1px solid rgba(255, 255, 255, 0.06)"> <!-- Reating Icon -->
<a href="health-fitness.php" style="background: rgba(255, 255, 255, 0.01) none repeat scroll 0 0;"><img src="assets/img/ftr.png" style="margin-left: 50px">
<h4>Health and Fitness</h4></a>
</div>
</div>
</div>	<!-- Testimonial Slider End -->
<?php } ?>
                    </div> 
                    </div>
                    			
									</div>
								</div>
							</div>
                           
						</div>
					</div>
				</div>
                 
			</div>		
		</div> <!-- End Hero Section -->
        <?php /*
        <div class="row dn-desk ml-0" style="width:100%">                       
                    <div class="col-md-12">
                        <div class="testimonial owl-carousel owl-theme"><!-- Testimonial Slider Start -->
                            <div class="single-testimonial-item mt-40"> <!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                    <img src="assets/img/icon-03.png"/>
                                    <h4>Insurance</h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                    <img src="assets/img/icon-04.png"/>
                                    <h4>Hospitals</h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                   <img src="assets/img/icon-05.png"/>
                                   <h4>Pharmacies </h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                    <img src="assets/img/icon-06.png"/>
                                    <h4>Doctors </h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                    <img src="assets/img/icon-07.png"/>
                                    <h4>Alternative Medicines</h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                                
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                   <img src="assets/img/icon-06.png"/>
                                   <h4>Doctors </h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                               
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                   <img src="assets/img/icon-05.png"/>
                                   <h4>Pharmacies </h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                            <div class="single-testimonial-item mt-40"><!-- Start Single Testimonial -->
                              
                                <div class="testimonial-icon"> <!-- Reating Icon -->
                                    <img src="assets/img/icon-07.png"/>
                                    <h4>Alternative Medicines</h4>
                                </div>
                            </div><!-- End Single Testimonial -->
                        </div>	<!-- Testimonial Slider End -->				
                    </div> 
                    </div>
		
		*/?>
<!--weather plugin                -->
<div style="width:200px;position: absolute;">
<a href="https://www.accuweather.com/en/ae/dubai/323091/weather-forecast/323091"  class="aw-widget-legal">
<!--
By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at https://www.accuweather.com/en/privacy.
-->
</a><div id="awcc1508917224490" class="aw-widget-current"  data-locationkey="323091" data-unit="c" data-language="en-us" data-useip="false" data-uid="awcc1508917224490"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>                    
</div>	
<!--weather plugin                -->
		<!-- Start Features Section -->
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
<!--					<div class="col-xs-12 col-sm-6 col-md-4">  Feature 2 
						<div class="single-feature-item wow fadeIn">
							 <img src="assets/img/ic-03.png" alt=""/>
							<h3>laproscopy</h3>
							<p>Concern about affordable medicall care Please feel free to contact us.</p>
						</div>
					</div>-->
<!--					<div class="col-xs-12 col-sm-6 col-md-4">  Feature 3 
						<div class="single-feature-item wow fadeIn">
							 <img src="assets/img/ic-04.png" alt=""/>
							<h3>colonoscopy</h3>
							<p>Concern about affordable medicall care Please feel free to contact us.</p>
						</div>
					</div>-->
                 <!--   <div style="clear:both;"></div>	-->
<!--					<div class="col-xs-12 col-sm-6 col-md-4">  Feature 4 
						<div class="single-feature-item wow fadeIn">
							 <img src="assets/img/ic-05.png" alt=""/>
							<h3>sigmoidoscopy</h3>
							<p>Concern about affordable medicall care Please feel free to contact us.</p>
						</div>
					</div>-->
                  
<!--					<div class="col-xs-12 col-sm-6 col-md-4">  Feature 5 
						<div class="single-feature-item wow fadeIn">
							 <img src="assets/img/ic-06.png" alt=""/>
							<h3>Abdominal abscess</h3>
							<p>Concern about affordable medicall care Please feel free to contact us.</p>
						</div>
					</div>-->
                      
<!--					<div class="col-xs-12 col-sm-6 col-md-4">  Feature 6 
						<div class="single-feature-item wow fadeIn">
							 <img src="assets/img/ic-07.png" alt=""/>
							<h3>surgery</h3>
							<p>Concern about affordable medicall care Please feel free to contact us.</p>
						</div>
					</div>-->
                   
				</div>
			</div> <!-- End Container -->
		</div> <!-- End Features Section -->
		
		
		
		<!-- Start Testimonial Section -->

		 <!-- End Testimonial Section -->		
		
		
		
		<!-- Start blog Post Section -->
		<div id="articals" class="health-care-content-block"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
					<div class="col-md-12"> <!-- Start Section Title -->
						<div class="section-title wow fadeIn">
							
							<h2 class="text-left green" >Blog Posts</h2>
						</div>
					</div> <!-- End Section Title -->
				</div>
				<div class="row">
				<?php 				
					$rslt=mysqli_query($con,"select * from tbl_articles where activeStatus=1 order by publishDate desc limit 3");
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
                                                    <a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>">
							<div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/blog/<?php echo $row["image"];?>);"></div> <!-- Post Image -->
							<div class="post-content">
								<h3><?php echo substr($row["title"],0,25);?>..</h3></a>						
								<p class="mt-10 mb-10"><?php echo $row["author"];?></p>   								
         									
								<p><?php echo $buff;?></p>
                                                                <a href="http://www.facebook.com/sharer.php?u=<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                                                <a href="http://twitter.com/share?url=<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a><br><br>
								<a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" class="health-care-btn view-all-btn wht">Read More
								</a>
							</div>
						</div>						
					</div>
				<?php }?>
					</div>
<!--<div class="row">  Start Center Button -->
					<!--<div class="col-md-12"> 
						<div class="section-btn wow fadeInUp">
							<a href="blog-list.php" class="health-care-btn view-all-btn">All Post</a>
						</div>
					</div> 
				</div> --><!--End Center Button -->
			</div> <!-- End Container -->
		</div> <!-- End blog Post Section -->
        <div class="health-care-content-block section-image-2"> <!-- Start Content Block -->	
			<div class="section-overlay2"></div> <!-- Start container -->
            
			<div class="container">
        <div class="row">
            <div class="col-md-12 t-center">
            <h2 class="t-center green mt-0 mb-30" >Testimonials</h2>
                <div class="tcb-simple-carousel">
                    <div id="myCarousel" class="carousel slide">
                     <!-- Indicators -->         
                        <div class="carousel-inner">           
                            <?php
							$i=0;
							$rslt=mysqli_query($con,"select * from tbl_testimonials where activeStatus=1");
							while($row=mysqli_fetch_assoc($rslt))
							{
								$i++;
							?>
							<div class="item <?php if($i==1) echo "active";?> wht">
                               
                                  <?php echo $row["remarks"];?>
                                  <small><?php echo $row["fullName"];?>  <cite title="Source Title"><?php echo $row["designation"];?></cite></small>
                               
                            </div>
							<?php }?>
                                                                                                               
                        </div> 
                       <div class="carousel-controls">
                          <a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="fa fa-angle-double-left"></span></a>
                          <a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="fa fa-angle-double-right"></span></a>
                      </div>               
                    </div>
                </div>
            </div>
        </div>
  
    <br />
  
    </div> 
		</div>		
		<!-- Start Footer Section -->
		<?php include_once("includes/footer.php");?>		
        
        <script>

		</script>
        
		
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