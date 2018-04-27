<?php include_once('admin/config.php');
//get about page details
$rslt=mysqli_query($con,"select t1.*,t2.description as desc2 from tbl_pages t1 left join tbl_page_description t2 on t1.id=t2.pageId where t1.id=2");
$row=mysqli_fetch_assoc($rslt);
$pageText=$row["description"];
$pageText2=$row["desc2"];
$pageTitle=$row["pageTitle"];
$pageImage=$row["image"];
$imageAlt=$row["altTag"];
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
      <div class="bg-overlay opacity-9"></div>
      <!-- Slider Overlay -->
      <div class="slider-item-table">
        <div class="slider-item-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
                <h2 class="wow fadeInDown">Insurance</h2>
                <ol class="breadcrumb">
                  <li><a href="<?php echo $absolutePath;?>">Home</a></li>
                  <li class="active">Insurance</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Breadcrumb Section --> 

<!-- Start Features Section -->
<div id="departments" class="health-care-content-block"> <!-- Start Content Block -->
  <div class="container"> <!-- Start container --> 
    <!--<div class="row">
					<div class="col-md-12 ">
						<div class="section-title wow fadeIn">
							<p>Our comprehensive</p>
							<h2>Insurance</h2>
						</div>
					</div> 
				</div>-->
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-4"> <!-- Feature 1 -->
        <div class="single-feature-item wow fadeIn mt-0"> 
          <!--<i class="icofont icofont-autism"></i>--> 
          <img src="<?php echo $absolutePath;?>uploads/images/<?php echo $pageImage;?>" alt="<?php echo $imageAlt;?>" style="    width: 100%"/> </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-8"> <!-- Feature 1 -->
        <div class="single-feature-item wow fadeIn text-left mt-0"> 
          <!--<i class="icofont icofont-autism"></i>-->
          <h3 class="mt-0"><?php echo $pageTitle;?></h3>
          <?php echo $pageText;?> </div>
      </div>
      <br clear="all"/>
      <br clear="all"/>
      <div class="col-xs-12 col-sm-12 col-md-12"> <!-- Feature 1 -->
        <div class="single-feature-item wow fadeIn text-left mt-0">
          <h3 class="mt-0">Insurance Providers</h3>
          <br clear="all">
          <div class="container bg">
            <div class="row">
<?php 
$rslt=mysqli_query($con,"SELECT * from tbl_insurance order by insurance asc");
while($row=mysqli_fetch_assoc($rslt))
{
$iid=$row['id'];    
?>
<div class="col-xs-12 col-sm-6 col-md-3 rwrapper">
<label>
<input type="checkbox"  /> 
<div class="card" id="ins1" onclick="flip(&#39;ins1&#39;)">
<div class="front">
<div class="department-itemc doctor-item">
<h2><?php echo substr($row['insurance'],0,20);?></h2>
<img class="margin-bottom-20" src="<?php echo $absolutePath;?>uploads/images/insurance/<?php echo $row['logo'];?>" alt="<?php echo $row["insurance"]; ?>"> 
<a class="btn-primary1 margin-bottom-20">Discover more</a>
</div></div>
<div class="back">
<h2 class="pink"><?php echo $row['insurance'];?></h2>
<table class="mb-40">
<tbody><tr class="text-center">
<th>Network</th>
<th>Inpatient</th>
<th>Outpatient</th>
</tr>
</tbody><tbody>
<?php 
$rslt6=mysqli_query($con,"SELECT * from tbl_insurance_status where insuranceId='".$iid."'");
while($row6=mysqli_fetch_assoc($rslt6))
{
$nid=$row6['networkId'];    
?>    
<tr class="text-center">
<?php
$rslt7=mysqli_query($con,"SELECT * from tbl_network where id='".$nid."'");
$row7=mysqli_fetch_assoc($rslt7);
?>    
<td align="left"><?php echo $row7['Name'];?></td>
<td><?php if($row6['inPatient']==1){ ?><i class="fa  fa-check"></i><?php } else { ?><i class="fa  fa-times" style="color:red!important"></i><?php } ?></td>
<td><?php if($row6['outPatient']==1){ ?><i class="fa  fa-check"></i><?php } else { ?><i class="fa  fa-times" style="color:red!important"></i><?php } ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<a class="btn-primary1 mt-20">close</a></div>
</div>
</label>
</div>
<?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Container --> 
</div>
<!-- End Features Section --> 

<!-- Start Hero Section --> 

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
<style>
                 .bg{background-color: #ffffff;}
.rwrapper{padding: 5px;}
.rlisting{background-color: #fff;overflow: hidden;}
.rlisting img{width: 100%}
.nopad{padding:0;}
.rfooter{	
			background: #f1f3f5;
			border-top: 1px #ebebeb solid;
width: 100%;padding:10px 15px;
    text-align: center;}
.rlisting h5,.rlisting p{padding:0 15px;} 
.img-box{    
		height: 150px; 
		width: 280px;
		    text-align: center;
			    margin-left: 12%;
}
.img-box img{
	    width: 280px !important;
    height: 150px;
}


.card {
    width: 100%;
    height: 350px;
   /* position: absolute;*/
    -webkit-transition: -webkit-transform 1s;
    -moz-transition: -moz-transform 1s;
    -o-transition: -o-transform 1s;
    transition: transform 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -o-transform-style: preserve-3d;
    transform-style: preserve-3d;
    -webkit-transform-origin: 50% 50%;
}
.card div {
       display:inline-block;
    height: 100%;
    width: 100%;
  
    color: white;
    text-align: center;
 
    font-size: 16px;
  /*position: absolute;*/
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -o-backface-visibility: hidden;
    backface-visibility: hidden;
}
.department-itemc.doctor-item img {
    width: 100%;
}
.card .front {
      text-align: center;
    cursor: pointer;
    background-color: #fff;
}
.card .back {
   cursor: pointer;
    padding: 20px;
    background-color: #fff;
    position: absolute;
    display: block;
    color: #333;
    top: 0px;
    height: 100%;
    width: 100%;
    -webkit-transform: rotateY( 180deg );
    -moz-transform: rotateY( 180deg );
    -o-transform: rotateY( 180deg );
    transform: rotateY( 180deg );
	-webkit-box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
    -moz-box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
    box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
}
.card.flipped {
    -webkit-transform: rotateY( 180deg );
    -moz-transform: rotateY( 180deg );
    -o-transform: rotateY( 180deg );
    transform: rotateY( 180deg );
}

.department-itemc {
    margin-top: 0px;
    background-color: #fff;
    -webkit-box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
    -moz-box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
    box-shadow: 1px 1px 1px 1px rgba(64,64,64,.3);
    cursor: pointer;
}
.department-itemc h2 {
       color: #338ff2!important;
    font-size: 24px!important;
    margin-top: 30px!important;
    letter-spacing: 1px;
}
.back h2 {
       color: #338ff2!important;
    font-size: 24px!important;
   
    letter-spacing: 1px;
}
.btn-primary1 {
     background-color: #2591fc !important;
    font-size: 16px !important;
    text-transform: uppercase;
    background-image: none;
    border: 0px;
    border-radius: 0px;
    padding: 11px !important;
	    color: #fff;
}
.card .back table {
    text-align: left;
    font-size: 12px;
    width: 100%;
    line-height: 18px;
}
.single-feature-item i {
    font-size: 16px !important;
    color: #79d600;
}



input {
    display: none;
}

:checked + .card {
    transform: rotateY(180deg);
    -webkit-transform: rotateY(180deg);
}

label:checked + .card {
    transform: rotateY(160deg);
    -webkit-transform: rotateY(160deg);
    box-shadow: 0 20px 20px rgba(255,255,255,.2);
}


                </style>
                
                <!--<script>
				function flip() {
    $('.card').toggleClass('flipped');
}
				</script>-->
</body>
</html>