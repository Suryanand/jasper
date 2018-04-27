<?php 
error_reporting(0);
include_once('admin/config.php');
$loc=$_GET["loc"];
$key=$_GET["key"];

$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_firm_image=$row["default_firm_image"];
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
		<meta name="description" content="Health Care - Medical & Doctor Html5 Template">
		<meta name="keywords" content=" clinic, dental, family doctor, health, hospital, medical, medicine">
		<meta name="developer" content="Arpon Das">
		<meta name="author" content="UI Cafe">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 		
		<!-- Site Title -->
		<title>Alodawa Medical & Medicine Portal</title>  <!-- Site Favicon --> 
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
										<h2 class="wow fadeInDown"><?php echo "Search Result: ".$key;?></h2>
										<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">Home</a></li>                                            
                                            <li class="active"><?php echo "Search Result";?></li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
										
					<div class="col-md-12">
					<?php 
					
					if(!empty($loc))
						$qry=" or location like '%".$loc."%' or area like '%".$loc."%'";
					else
						$qry="";
					$rslt=mysqli_query($con,"select * from tbl_firm where activeStatus=1 and (companyName like '%".$key."%' OR profile like '%".$key."%'".$qry.")");
					while($row=mysqli_fetch_assoc($rslt))
					{
						$image=$absolutePath."uploads/images/firms/".$row["image"];
						if(empty($row["image"]))
							$image=$absolutePath."uploads/images/".$default_firm_image;
						$crop_str='...';
						$n_chars=200;
						$buff=strip_tags($row['profile']);
						
						 if(strlen($buff) > $n_chars)
						{
							$cut_index=strpos($buff,' ',$n_chars);
							$buff=trim(substr($buff,0,($cut_index===false? $n_chars: $cut_index+1))).$crop_str;
						}
					?>
					<div class="col-md-2">
                        <img src="<?php echo $image;?>" style="width:180px;height:180px">
                    </div>
					<div class="col-md-10">
                        <a href="<?php echo $absolutePath.$url.$row["urlName"];?>"><h3><?php echo $row["companyName"];?></h3></a>
						<p><?php echo $row["area"].", ".$row["location"];?></p>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>
						<?php echo $buff;?>
                    </div>
					<br clear="all"/>
					<hr>
					<?php }					
					?>
					<?php 
					if(!empty($loc))
						$qry=" or location like '%".$loc."%' or area like '%".$loc."%'";
					else
						$qry="";
					$rslt=mysqli_query($con,"select * from tbl_trainers where activeStatus=1 and (fullName like '%".$key."%' OR specialized like '%".$key."%' OR profile like '%".$key."%'".$qry.")");
					while($row=mysqli_fetch_assoc($rslt))
					{
                                            $type=$row["type"];
                                            $spec=$row["specialized"];
                                            
						if(!empty($row["image"]))
						{
							$image=$absolutePath."uploads/images/trainers/".$row["image"];
						}
						else
						{
							$image=$absolutePath."uploads/images/".$default_doctor_image;
						}
					?>
					<div class="doc_class" data-gender="<?php echo $row["gender"];?>" data-specialized="<?php echo $row["specialized"];?>" data-location="<?php echo $row["location"];?>">
					<div class="col-md-2">
                        <img src="<?php echo $image;?>" alt="<?php echo $row["fullName"];?>" style="width:100%;">
                    </div>
					<div class="col-md-10">
                        <?php
                        if($type==3){
                        ?>                    
                        <a href="<?php echo $absolutePath;?>doctors/<?php echo $row["urlName"];?>"><h3><?php echo $row["fullName"];?></h3></a>
                        <?php } elseif($type==0){?>
                        <a href="<?php echo $absolutePath;?>trainers/<?php echo $row["urlName"];?>"><h3><?php echo $row["fullName"];?></h3></a>
                        <?php } else{?>
                        <a href="<?php echo $absolutePath;?>nutritionist/<?php echo $row["urlName"];?>"><h3><?php echo $row["fullName"];?></h3></a>
                        <?php } ?>
                        <?php
                        if($type==3){
                        $rslt6=mysqli_query($con,"select * from tbl_specialty where id=$spec");    
                        }
                        else {
                        $rslt6=mysqli_query($con,"select * from tbl_fitness_specialty where id=$spec");      
                        }
                        $row6=mysqli_fetch_assoc($rslt6);
                        ?>
						<p><?php echo $row6["Name"];?></p>
							<p><?php echo $row["qualification"];?></p>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>						
                    </div>
                    </div>
					<br clear="all"/>
					<hr>
					<?php }
					//if(mysqli_num_rows($rslt)==0) echo "No list available";
					?>
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