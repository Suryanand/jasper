<?php 
include_once('admin/config.php');
$urlName=$_GET["id"];
//$companyType=2;
$rslt=mysqli_query($con,"select * from tbl_category where urlName='$urlName'");
$row=mysqli_fetch_assoc($rslt);
$categoryName=$row["categoryName"];
$companyType=$row["id"];
$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
$menuImage=$row["menuImage"];
$description=$row["description"];
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
<?php if($menuImage!=''){ ?>
<div class="Breadcrumbs" style="background-image: url(<?php echo $absolutePath;?>uploads/images/category/<?php echo $menuImage;?>)"> <!-- Slider Image -->
<?php } else { ?> 
<div class="Breadcrumbs" style="background-image: url(<?php echo $absolutePath;?>assets/img/page_header_img_1.jpg)">  
<?php } ?>    
					<div class="bg-overlay opacity-9"></div> <!-- Slider Overlay -->
					<div class="slider-item-table">
						<div class="slider-item-table-cell">
							<div class="container">
								<div class="row">
									<div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
										<h2 class="wow fadeInDown"><?php echo $categoryName;?></h2>
                                                                                						<div class="container">
                                        <div class="newsletter">
										<form action="<?php echo $absolutePath;?>search-firm.php" method="get">
                                        <div class="col-md-3 col-xs-12 p-0 mr-5">
                                        <div class="input-group mb-20">
                                        <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                        <select required name="loc" class="form-control ico-01">
                                        <option value="">Emirates</option>
                                        <?php 
					$rslt=mysqli_query($con,"select * from tbl_locations order by region asc");
					while($row=mysqli_fetch_assoc($rslt))
					{?>
                                        <option value="<?php echo $row['region'];?>"><?php echo $row['region'];?></option>
                                        <?php } ?>
                                        </select>
                                        </div>
                                        </div>
					</div>
                                        <div class="col-md-3 col-xs-12 p-0 mr-5">
                                        <div class="input-group mb-20">
                                        <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                        <select required name="spec" class="form-control ico-01">
                                        <option value="">Specialties</option>
                                        <?php 
					$rslt=mysqli_query($con,"select * from tbl_specialty order by Name asc");
					while($row=mysqli_fetch_assoc($rslt))
					{?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['Name'];?></option>
                                        <?php } ?>
                                        </select>
                                        </div>
                                        </div>
					</div>
                                         <div class="col-md-3 col-xs-12 p-0 mr-5">
                                        <div class="input-group mb-20">
                                        <div class="subscribe-form wow fadeInUp">  <!-- Subscribe Form -->	
                                        <select required name="ins" class="form-control ico-01">
                                        <option value="">Insurance</option>
                                        <?php 
					$rslt=mysqli_query($con,"select * from tbl_insurance where activeStatus=1 order by insurance asc");
					while($row=mysqli_fetch_assoc($rslt))
					{?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['insurance'];?></option>
                                        <?php } ?>
                                        </select>
                                        </div>
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
                                <li><a href="<?php echo $absolutePath;?>">Home</a> / <?php echo $categoryName;?></li>                                          
                                
                                        </ol>       
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 
				                           
				<div class="row">
					<div class="col-md-4">
                    <div class="contact-info wow fadeIn">
                        <h4 class="sidebar-title1">Area</h4>
                        <input type="checkbox" id="mycheckbox" />
						<?php 
						$rslt=mysqli_query($con,"select distinct area from tbl_firm where activeStatus=1 and area!='' order by area asc limit 0,5");
						while($row=mysqli_fetch_assoc($rslt))
						{
						?>
						<label class="filter-label"><input type="checkbox" class="location" value="<?php echo $row["area"];?>"><?php echo $row["area"];?></label>
						<?php }?>
                                                <?php 
						$rslt=mysqli_query($con,"select distinct area from tbl_firm where activeStatus=1 and area!='' order by area asc limit 5,1000");
						while($row=mysqli_fetch_assoc($rslt))
						{
						?>
						<label class="filter-label moretext"><input type="checkbox" class="location" value="<?php echo $row["area"];?>"><?php echo $row["area"];?></label>
						<?php }?>
                                                 <label for="mycheckbox" class="showmore" style="float: right;"><i style="color: #727272;font-size: 12px !important;">more...</i></label>
                        </div>
						<br clear="all"/>
                      <div class="contact-info wow fadeIn">
                        <h4 class="sidebar-title1">Specialty</h4>
                        <input type="checkbox" id="mycheckbox2" />
						<?php 
						$rslt=mysqli_query($con,"select distinct specialty from tbl_firm where activeStatus=1 and specialty!=''");
						while($row=mysqli_fetch_assoc($rslt))
						{
                                                $specialty=$row['specialty'];    
						?>
<?php
$catArray=explode(',',$specialty);
$rslt=mysqli_query($con,"select * from tbl_specialty order by Name asc limit 0,5");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>     
<label class="filter-label moretext2"><input type="checkbox" class="spec" value="<?php echo $row["id"];?>"><?php echo $row['Name'];?></label>
<?php }}?>
<?php
$catArray=explode(',',$specialty);
$rslt=mysqli_query($con,"select * from tbl_specialty order by Name asc limit 5,1000");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>     
<label class="filter-label"><input type="checkbox" class="spec" value="<?php echo $row["id"];?>"><?php echo $row['Name'];?></label>
<?php }}}?>
<label for="mycheckbox2" class="showmore2" style="float: right;"><i style="color: #727272;font-size: 12px !important;">more...</i></label>
                        </div>  
                                                			<br clear="all"/>
<!--                      <div class="contact-info wow fadeIn">
                        <h4 class="sidebar-title1">Insurance</h4>
						<?php 
						$rslt=mysqli_query($con,"select distinct insurance from tbl_firm where activeStatus=1 and insurance!=''");
						while($row=mysqli_fetch_assoc($rslt))
						{
                                                $insurance=$row['insurance'];     
						?>
<?php
$catArray=explode(',',$insurance);
$rslt=mysqli_query($con,"select * from tbl_insurance");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>     
<label class="filter-label" title="<?php echo $row['insurance'];?>"><input type="checkbox" class="location" disabled value="<?php echo $row["id"];?>"><?php echo substr($row['insurance'],0,22);?>..</label>
<?php }}}?>
                        </div>-->
                    
                    </div>					
					<div class="col-md-8 hospital_list">
<div style="text-align:justify"><?php echo $description;?></div>
					<?php 
					$rslt=mysqli_query($con,"select * from tbl_firm where activeStatus=1 and companyType='$companyType' order by companyName asc");
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
					<div class="doc_class" data-location="<?php echo $row["location"];?>">
					<div class="col-md-5">
                        <img src="<?php echo $image;?>" width="264px" height="170px">
                    </div>
					<div class="col-md-7">
                        <a href="<?php echo $absolutePath.$urlName."/".$row["urlName"];?>"><h3 style="margin:0px;"><?php echo $row["companyName"];?></h3></a>
						<p style="margin-bottom:0px;"><?php if(!empty($row["area"])) echo $row["area"].", ";echo $row["location"];?></p>
						<label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label>
						<?php echo $buff;?>
                    </div>
					<br clear="all"/>
					<hr>
                    </div>
					<?php }
					if(mysqli_num_rows($rslt)==0) echo "No list available";
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
        <script>
		$(".area").change(function(){
			filter();
		});
                	$(".specialty").change(function(){
			filter();
		});
		function filter()
		{
			
				var loc = [];
                                var spec = [];
				var i=0;
				var companyType='<?php echo $companyType;?>';

				$('input.location:checkbox:checked').each(function () {
					i=1;
					loc.push($(this).val());
				});
				
				$.ajax({
						 type: "POST",
						 url: "ajx-scripts.php",
						 data: {companyType:companyType,loc:loc,spec:spec,hospital:i},
						 success: function(data) {
							 //alert(data);
						 $(".hospital_list").html(data);
						},
//						error: function(x,a,y){ //add this error function
//						alert(JSON.stringify(x)+" "+a);
//						}
					});
				
				
		}
		</script>
<style>
#mycheckbox:checked ~ .moretext {
  display: block;
}

.moretext{
  display: none;
}

#mycheckbox{
  display: none;
}
.showmore{
  cursor: pointer;
}    
</style> 
<style>
#mycheckbox2:checked ~ .moretext2 {
  display: block;
}

.moretext2{
  display: none;
}

#mycheckbox2{
  display: none;
}
.showmore2{
  cursor: pointer;
}    
</style> 
	</body>
</html>