<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_gymnasium where urlName='$urlName'");
$row=mysqli_fetch_assoc($rslt);
$address = $row["address"];
$uid=$row['id'];
	$firmImage = $row["image"];
	$companyType = $row["companyType"];
	$email  = $row["email"];
	$country = $row["country"];
	$area = $row["area"];
	$network1 = $row["network1"];
        $service = $row["service"];
        $specialty = $row["specialty"];
        $insurance = $row["insurance"];
	$network2 = $row["network2"];
	$location=$row["location"];
	$companyName	=$row["companyName"];
	$profile	=$row["profile"];
	//$email	=$row["email"];
	$contactNo	=$row["contactNo"];
	$fax	=$row["fax"];
	$googleMap	=$row["googleMap"];
	$activeStatus=$row["activeStatus"];
	$branchId=$row["branchId"];
	$website=$row["website"];
	//$password=encryptIt($row["password"]);
	
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];

//$companyType=2;
if($companyType==1)
	$url="gymnasiums/";

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_firm_image=$row["default_firm_image"];
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
			font-weight:bold;
			cursor:pointer;
			padding-left:15px;
		}
		iframe{
			width:100%;
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
										<h2 class="wow fadeInDown"><?php echo $companyName;?></h2>
<?php
$rslt6=mysqli_query($con,"select * from tbl_category where id='$companyType'");
$row6=mysqli_fetch_assoc($rslt6)
?>                                                                                 
                                                   						<div class="container">
                                        <div class="newsletter">
										<form action="<?php echo $absolutePath;?>search-gymnasium.php" method="get">
                                        <div class="col-md-3 col-xs-12 p-0 mr-5">
                                        
									<div class="input-group mb-20">
                                        <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                            <input type="text" id="subscriber-email" name="loc" placeholder="Business Bay..." class="form-control ico-01">
                                        </div>
                                        
                                    </div>
								</div>
                                <div class="col-md-6 col-xs-12 p-0 mr-5 mb-20">
                                <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                            <input type="text" id="subscriber-email2" name="key" placeholder="Search <?php echo $row6['categoryName']?>..." class="form-control ico-02">												
                                        </div>
                                </div>
                                
                                <div class="col-md-2 col-xs-12 p-0">
                               <button type="submit" class="health-care-btn slider-btn bt-1 wow fadeInUp" style="padding:12px 30px;border:none;">Search Now</button> <!-- Button -->
                                        </div>
                                                                                    <input type="hidden" name="fid" value="<?php echo $companyType;?>">
										</form>
                                </div>
               
                                </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
 					<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">home</a> / <a href="<?php echo $absolutePath;?>gymnasiums.php">gymnasiums</a> / <?php echo $urlName;?></li>                                            
                                            
                                        </ol>      
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
										
					<div class="col-md-8">	
                    				
                       <div class=" col-md-12 contact-info wow fadeIn" style=" margin-bottom:10px">
                       
                       <div class="col-md-4 p-0">
                       <?php if(!empty($firmImage)){?><img src="<?php echo $absolutePath."uploads/images/gymnasium/".$firmImage;?>" style="width:100%"><?php }?>
                       </div>
<div class="col-md-6">
<h3 class="m-0"><?php echo $companyName;?></h3>
<p class="mt-10"><?php echo $area;?>, <?php echo $location;?></p>                       
<p class="mt-10"><?php echo $address;?></p>
<p class="mt-10"><?php echo $email;?></p>
<p class="mt-10"><?php echo $contactNo;?>, <?php echo $fax;?></p>
</div>
<div class="col-md-2 p-0">
<br clear="all"><br clear="all">   
<!--<a href="#"><i class="fa fa-facebook-square fa-2x wht mb-10" aria-hidden="true" style=" line-height: 2.3;  font-size: 35px; color: #333 !important;"></i></a>
<a href="#"> <i class="fa fa-twitter-square fa-2x wht" aria-hidden="true" style="    font-size: 35px; color: #333 !important;"></i></a>-->
<a href="callto:<?php echo $contactNo;?>" class="health-care-btn view-all-btn wht" style="    padding: 10px 13px !important; ">Call Now</a>
</div>
</div>
                            
                            
                            
<div class="col-md-12 contact-info wow fadeIn" style=" margin-bottom:10px">
<div class="tab">
<button class="tablinks" onclick="openCity(event, '1')" id="defaultOpen">About Us</button>
<button class="tablinks" onclick="openCity(event, '2')">Location</button>
<button class="tablinks" onclick="openCity(event, '3')">Insurance</button>
</div>
<div id="1" class="tabcontent">
<div style="text-align:justify"><p><?php echo $profile;?></p></div>
</div>
<div id="2" class="tabcontent">
<?php echo $googleMap;?>
</div>
<div id="3" class="tabcontent">
<?php
$catArray=explode(',',$insurance);
$rslt=mysqli_query($con,"select * from tbl_insurance");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>
<a href="<?php echo $absolutePath;?>insurance-detail.php?id=<?php echo $row['id']?>"><img src="<?php echo $absolutePath;?>uploads/images/insurance/<?php echo $row['logo'];?>" style="width:200px;height:100px"></a>
<?php }}?>
</div>                     
</div>
<?php
$rslt6=mysqli_query($con,"select * from tbl_gymnasium_timing where gymid='$uid'");
$row6=mysqli_fetch_assoc($rslt6);
$num6=mysqli_num_rows($rslt6);
if($num6!='0'){
?>
<div class=" col-md-12 contact-info wow fadeIn" style=" margin-bottom:10px">
<div class="col-md-12">
<h3 class="m-0">Working Hours</h3>
<?php if($row6["sat_alt"]==''){ ?>
<p class="mt-10">Saturday: <?php echo $row6['sat_hour'];?>:<?php echo $row6['sat_min'];?>&nbsp;<?php echo $row6['sat_text'];?>&nbsp;to&nbsp;<?php echo $row6['sat_hour2'];?>:<?php echo $row6['sat_min2'];?>&nbsp;<?php echo $row6['sat_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Saturday: <?php echo $row6['sat_alt'];?></p>
<?php }?>
<?php if($row6["sun_alt"]==''){ ?>
<p class="mt-10">Sunday: <?php echo $row6['sun_hour'];?>:<?php echo $row6['sun_min'];?>&nbsp;<?php echo $row6['sun_text'];?>&nbsp;to&nbsp;<?php echo $row6['sun_hour2'];?>:<?php echo $row6['sun_min2'];?>&nbsp;<?php echo $row6['sun_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Sunday: <?php echo $row6['sun_alt'];?></p>
<?php }?>
<?php if($row6["mon_alt"]==''){ ?>
<p class="mt-10">Monday: <?php echo $row6['mon_hour'];?>:<?php echo $row6['mon_min'];?>&nbsp;<?php echo $row6['mon_text'];?>&nbsp;to&nbsp;<?php echo $row6['mon_hour2'];?>:<?php echo $row6['mon_min2'];?>&nbsp;<?php echo $row6['mon_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Monday: <?php echo $row6['mon_alt'];?></p>
<?php }?>
<?php if($row6["tue_alt"]==''){ ?>
<p class="mt-10">Tuesday: <?php echo $row6['tue_hour'];?>:<?php echo $row6['tue_min'];?>&nbsp;<?php echo $row6['tue_text'];?>&nbsp;to&nbsp;<?php echo $row6['tue_hour2'];?>:<?php echo $row6['tue_min2'];?>&nbsp;<?php echo $row6['tue_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Tuesday: <?php echo $row6['tue_alt'];?></p>
<?php }?>
<?php if($row6["wed_alt"]==''){ ?>
<p class="mt-10">Wednesday: <?php echo $row6['wed_hour'];?>:<?php echo $row6['wed_min'];?>&nbsp;<?php echo $row6['wed_text'];?>&nbsp;to&nbsp;<?php echo $row6['wed_hour2'];?>:<?php echo $row6['wed_min2'];?>&nbsp;<?php echo $row6['wed_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Wednesday: <?php echo $row6['wed_alt'];?></p>
<?php }?> 
<?php if($row6["thu_alt"]==''){ ?>
<p class="mt-10">Thursday: <?php echo $row6['thu_hour'];?>:<?php echo $row6['thu_min'];?>&nbsp;<?php echo $row6['thu_text'];?>&nbsp;to&nbsp;<?php echo $row6['thu_hour2'];?>:<?php echo $row6['thu_min2'];?>&nbsp;<?php echo $row6['thu_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Thursday: <?php echo $row6['thu_alt'];?></p>
<?php }?>  
<?php if($row6["fri_alt"]==''){ ?>
<p class="mt-10">Friday: <?php echo $row6['fri_hour'];?>:<?php echo $row6['fri_min'];?>&nbsp;<?php echo $row6['fri_text'];?>&nbsp;to&nbsp;<?php echo $row6['fri_hour2'];?>:<?php echo $row6['fri_min2'];?>&nbsp;<?php echo $row6['fri_text2'];?></p> 
<?php } else { ?>
<p class="mt-10">Friday: <?php echo $row6['fri_alt'];?></p>
<?php }?>
</div>
</div>     
<?php } ?> 
<?php 
if($specialty!=''){
?>                                            
<div class=" col-md-12 contact-info wow fadeIn" style=" margin-bottom:10px">
<div class="col-md-12">
<h3 class="m-0">Specialties</h3><br>
<?php
$catArray=explode(',',$specialty);
$rslt=mysqli_query($con,"select * from tbl_fitness_specialty");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>     
<input type="submit" value="<?php echo $row['Name'];?>" style="background:#2591fd;color:white">
<?php }}?>
</div>
</div>
<?php } ?>                                            
                    					
                    </div>
<div class="col-md-4">
<?php
$rslt=mysqli_query($con,"select * from tbl_category where id='$companyType'");
while($row=mysqli_fetch_assoc($rslt)){
?>    
<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-building-o" aria-hidden="true"></i>
Other Gymnasiums</h4>
<?php } ?>
<?php
$rslt=mysqli_query($con,"select * from tbl_gymnasium where companyType='$companyType' and id!=$uid and activeStatus=1 limit 4");
while($row=mysqli_fetch_assoc($rslt)){
$image=$absolutePath."uploads/images/gymnasium/".$row["image"];
if(empty($row["image"]))
$image=$absolutePath."uploads/images/".$default_firm_image;    
?>
<div class="doc_class" data-location="<?php echo $row["location"];?>">
<div class="col-md-3">
<img src="<?php echo $image;?>" width="80px" height="85px">
</div>
<div class="col-md-9">
<a href="<?php echo $absolutePath.$urlName."/".$row["urlName"];?>"><b style="margin:0px;"><?php echo substr($row["companyName"],0,20);?></b></a>
<p style="margin-bottom:0px;"><?php if(!empty($row["area"])) echo $row["area"].", ";echo $row["location"];?></p>
<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
<?php if($row['profile']!=''){echo substr($row['profile'],0,30);?>...<?php } ?>
</div>
<br clear="all"/><hr>
</div>
<?php } ?>
</div>
<?php /*?><div class="col-md-3">
                        <h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-map-marker" aria-hidden="true"></i> Address</h4>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $address;?></label>
						<br clear="all"/>
			<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-phone" aria-hidden="true"></i> Phone</h4>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $contactNo;?></label>
						<br clear="all"/>
			<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-fax" aria-hidden="true"></i> Fax</h4>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $fax;?></label>
						<br clear="all"/>
			<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</h4>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $email;?></label>
						<br clear="all"/>
						<?php if(!empty($website)){?>
			<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-globe" aria-hidden="true"></i> Website</h4>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $website;?></label>
						<br clear="all"/>
						<?php }?>
			<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-file-text-o" aria-hidden="true"></i> Networks</h4>
						<?php if(!empty($network1)){?><label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $network1;?></label><?php }?>
						<label class="filter-label" style="font-size: 14px;font-weight: normal;"><?php echo $network2;?></label>
<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-briefcase" aria-hidden="true"></i> Services</h4>
<?php if(!empty($service)){?>
<?php
$catArray=explode(',',$service);
$rslt=mysqli_query($con,"select * from tbl_services");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>
<h5 style="background: #fafafa;color:black;float: left;padding: 0px 11px 3px 21px;" title="<?php echo $row['name'];?>"><?php echo $row['icon'];?></h5>
<?php }}}?>
						                  
                    </div><?php */?>
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

<style>
/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 16px;
	font-family: 'Ubuntu', sans-serif;
	    border: 1px solid #dedede;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}
div.tab button.active {
    background-color: #2591fd;
    color: #fff;
    font-family: 'Ubuntu', sans-serif;
}
</style>
        
	</body>
</html>