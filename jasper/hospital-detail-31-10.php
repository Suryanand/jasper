<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_firm where urlName='$urlName'");
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
	$url="clinics/";
if($companyType==2)
	$url="hospitals/";
if($companyType==3)
	$url="pharmacy/";
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
										<form action="<?php echo $absolutePath;?>search-firm.php" method="get">
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
                                            <li><a href="<?php echo $absolutePath;?>">Home</a>/</li>                                            
                                            <li><?php if($companyType==1) echo "Hospitals / ";elseif($companyType==2) echo "Clinics / ";else echo "Pharmacies / ";echo $companyName;?></li>
                                        </ol>      
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
					<div class="col-md-3">
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
						                  
                    </div>					
					<div class="col-md-5">					
                       
						<h3><?php echo $companyName;?></h3>
                                                 <?php if(!empty($firmImage)){?><img src="<?php echo $absolutePath."uploads/images/firms/".$firmImage;?>" style="width:100%"><?php }?><br clear="all"/>
						<div style="text-align:justify"><?php echo $profile;?></div>
						<br clear="all"/>
						<?php echo $googleMap;?>
                    					
                    </div>
<div class="col-md-4">
<?php
$rslt=mysqli_query($con,"select * from tbl_category where id='$companyType'");
while($row=mysqli_fetch_assoc($rslt)){
?>    
<h4 class="sidebar-title" style="background: #fafafa;color:black;"><i class="fa fa-building-o" aria-hidden="true"></i>
Other <?php echo $row['categoryName'];?></h4>
<?php } ?>
<?php
$rslt=mysqli_query($con,"select * from tbl_firm where companyType='$companyType' and id!=$uid and activeStatus=1 limit 4");
while($row=mysqli_fetch_assoc($rslt)){
$image=$absolutePath."uploads/images/firms/".$row["image"];
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
        
	</body>
</html>