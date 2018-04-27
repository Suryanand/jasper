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
       
       <!-- Start blog Post Section -->
		<div id="articals" class="health-care-content-block"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
                <div class="col-md-8">
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
                    
					<div class="col-sm-6 col-md-6" style="padding:5px !important">
						<div id="blog-page" class="blog-post-box wow fadeIn"> <!-- Post Box -->
                        <a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>">
							<div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/blog/<?php echo $row["image"];?>);"></div> <!-- Post Image -->
							<div class="post-content">
								<h3><?php echo substr($row["title"],0,20);?></a></h3>						
								<p class="mt-10 mb-10"><?php echo $row["author"];?></p>   								
         									
								<p><?php echo $buff;?></p>
								<?php /*?><a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" class="health-care-btn view-all-btn wht">Read More
								</a><?php */?>
                                 <div class="ta">
                                 <a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" class="">Read More</a>
                                 <div class="ta1">
                                                                <a  style="text-align:right" href="http://www.facebook.com/sharer.php?u=<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                                                <a style="text-align:right" href="http://twitter.com/share?url=<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                               </div>
                                                                </div>
							</div>
						</div>						
					</div>
                    
				<?php }?>
					</div>
                    <div class="col-md-4" style="    margin-top: 56px;">                                        
<div class="tab">
<button class="tablinks" onclick="openCity(event, '1')" id="defaultOpen">Most Popular</button>
<button class="tablinks" onclick="openCity(event, '2')">Most Discussed</button>
</div>
<div id="1" class="tabcontent">
<?php
$rslt5=mysqli_query($con,"select * from tbl_articles where activeStatus=1 order by views DESC limit 5");
while($row5=mysqli_fetch_assoc($rslt5)){
?>
<h4><?php echo substr($row5['title'],0,30);?></h4>
<p><?php echo substr($row5['description'],0,45);?>...</p>
<hr>
<?php } ?>
</div>
<div id="2" class="tabcontent">
<?php
$rslt5=mysqli_query($con,"select * from tbl_articles where activeStatus=1 order by id DESC limit 5");
while($row5=mysqli_fetch_assoc($rslt5)){
?>
<h4><?php echo substr($row5['title'],0,30);?></h4>
<?php echo substr($row5['description'],0,45);?>...
<hr>
<?php } ?>
</div>
</div>
                    </div>
                    
                    
                                <!--Start Site Pageination-->                
			</div> <!-- End Container -->
		</div> <!-- End blog Post Section -->
		
			<style>


/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    font-weight: 700;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 16px;
	font-family: 'Ubuntu', sans-serif;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #2591fd;
    color: #fff;
    font-family: 'Ubuntu', sans-serif;
}

/* Style the tab content */
.tabcontent {
    display: none;
        padding: 17px 30px;
    border: 1px solid #ccc;
    border-top: none;
	    background: #fff;
}
.tabcontent h4{
	font-family: 'Montserrat', sans-serif;
    font-weight: 300;
}
</style>  	
		
		
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
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
	</body>
</html>