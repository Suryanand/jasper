<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];
mysqli_query($con,"update tbl_articles set views=views+1 where urlName='".$urlName."'");
$rslt=mysqli_query($con,"select * from tbl_articles where urlName='".$urlName."'");
$row=mysqli_fetch_assoc($rslt);
$blogTitle=$row["title"];
$author=$row["author"];
$description=$row["description"];			
$image=$row["image"];			
$views=$row["views"];			
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
							 <!-- Post Image -->
							<div class="post-content">
								<h3 style="text-align:center"><?php echo $blogTitle;?></h3>
                               <div style="text-align:center"> <ul>
                                    <li><i class="fa fa-calendar"></i> <a><?php echo date('d F, Y',strtotime($publishDate));?></a><span>|</span></li>
                                    <li><i class="fa fa-user"></i> <a>By <?php echo $author;?></a><span>|</span></li>
                                    <li><i class="fa fa-eye"></i> <a><?php echo $views;?> Views</a></li>
                                </ul></div>
                                <div class="blog-post" style="background-image:url(<?php echo $absolutePath;?>uploads/images/blog/<?php echo $image;?>);"></div><br>                                
								<?php echo $description;?>
							</div>
                           
                           
                            <div class="divider"></div>                          
                           </div>                        
					</div>	<!-- End Full Post-->
<div class="col-md-4" style="margin-top: 99px;">                                        
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
<?php echo substr($row5['description'],0,45);?>...
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
                            <?php /*<div class="comments-section left-right-padding">
                                <h3 class="single-page-heading">03 Comments</h3>
                                <ul class="comment-list">
									<li class="comment">
										<div class="the-comment">
											<div class="avatar">
												<img src="<?php echo $absolutePath;?>assets/img/avater1.png" alt="avater"/>
											</div>
											<div class="comment-box">
												<div class="comment-author meta">
                                                    <h4><strong>Admin, Health Care</strong></h4>
                                                    <p>13 Fab 2017  /  at 9: 57 pm</p>                                                    
												</div>
												<div class="comment-text">
													<p>But I must explain to you how all this  i mistaken idea of denouncing pleasure and praising pain was i born and  will give you a complete But I must explain to you how all this mistaken idea of denouncing pleasure and praising </p>
                                                    <a rel="nofollow" class="comment-reply-link" href="#"> Reply</a>
												</div>
											</div>
										</div>
										
										<ul class="children">
											<li class="comment">
												<div class="the-comment">
													<div class="avatar">
														<img src="<?php echo $absolutePath;?>assets/img/avater2.png" alt="avater"/>
													</div>
													<div class="comment-box">
                                                        <div class="comment-author meta">
                                                            <h4><strong>User Name</strong></h4>
                                                            <p>13 Fab 2017  /  at 9: 57 pm</p>                                                    
                                                        </div>
                                                        <div class="comment-text">
                                                            <p>But I must explain to you how all this  i mistaken idea of denouncing pleasure and praising pain was i born and  will give you a complete But I must explain to you how all this mistaken </p>
                                                            <a rel="nofollow" class="comment-reply-link" href="#"> Reply</a>
                                                        </div>
                                                    </div>
												</div>
                                                <ul class="children">
                                                    <li class="comment">
                                                        <div class="the-comment">
                                                            <div class="avatar">
                                                                <img src="<?php echo $absolutePath;?>assets/img/avater3.png" alt="avater"/>
                                                            </div>
                                                            <div class="comment-box">
                                                                <div class="comment-author meta">
                                                                    <h4><strong>Doctor</strong></h4>
                                                                    <p>13 Fab 2017  /  at 9: 57 pm</p>                                                    
                                                                </div>
                                                                <div class="comment-text">
                                                                    <p>But I must explain to you how all this  i mistaken idea of denouncing pleasure and praising pain was i born and  will give you a complete But I must explain to you how all this mistaken </p>
                                                                    <a rel="nofollow" class="comment-reply-link" href="#"> Reply</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
											</li>
										</ul>
									</li>
								</ul>
                            </div>
                            
                            <div class="divider"></div> 
                            
                            <div class="comments-form-section left-right-padding">
                                <h3 class="single-page-heading">Leave A Reply</h3>
                                <div class="comments-form input-box left"> <!-- Name Box -->
                                    <p><input type="text" class="form-control" placeholder="Your Full Name"></p>							
                                </div>
                                 <div class="comments-form input-box right"> <!-- Email Box -->
                                    <p><input name="email" type="email" class="form-control" placeholder="Your Email Address"></p>							
                                </div>
                                 <div class="comments-form text-area"> <!-- Text Area Box -->
                                    <p><textarea name="comment" class="form-control textarea-box" placeholder="Comment" required></textarea></p>						
                                </div> 
                                <div class="comments-form submit-button"> <!-- Submit Button -->
                                    <input type="submit" class="health-care-btn submit-btn" value="Submit Now">					
                                </div>
                            </div>                            
						*/?>
						
                    
<!--                    <div class="col-sm-4 col-md-4">  Right Sidebar
                        <div class="right-sidebar categories-widgets">  Post Box 
                            <h3 class="sidebar-widgets-heading">Categoriess</h3>
                            <ul>
								<?php $rslt=mysqli_query($con,"select * from tbl_articles_category");
								while($row=mysqli_fetch_assoc($rslt))
								{?>
								<li><a href="<?php echo $absolutePath;?>article-category/<?php echo $row["id"];?>"><i class="fa fa-caret-right" aria-hidden="true"></i>
								<?php echo $row["category"];?></a></li>
								<?php }?>
                            </ul>
						</div>
                        <div class="right-sidebar popular-Post-widgets">  Post Box 
                            <h3 class="sidebar-widgets-heading">Latest Post</h3>
                            <ul>
								<?php 
							$rslt=mysqli_query($con,"select * from tbl_articles where activeStatus=1 and urlName!='$urlName' order by publishDate desc");
							while($row=mysqli_fetch_assoc($rslt))
							{
								
								?>
									<li><div class="side-bar-post-image"><img src="<?php echo $absolutePath;?>assets/img/sidebar_post_image1.jpg"></div><a href="<?php if($row["postType"]==3) echo $absolutePath."uploads/pdf/".$row["link"]; elseif($row["postType"]==2) echo $row["link"]; else echo $absolutePath."article/".$row["urlName"];?>"><?php echo $row["title"];?></a></li>
							<?php }?> 
                            </ul>
						</div>	
					</div>	 End Right Sidebar									-->
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