<?php 
session_start();
include_once('admin/config.php');
if(!isset($_SESSION["user_id"]) || $_SESSION["user_type"]!=2)
{
	header('location: '.$absolutePath);
}
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_appointments where id='".$_POST["delete"]."'");
}
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
.response{
	margin-top: 25px;
    background: #90e685;
    padding: 15px;
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
				<div class="Breadcrumbs page-header-img-1" style="height:350px;"> <!-- Slider Image -->	
					<div class="bg-overlay opacity-9"></div> <!-- Slider Overlay -->
					<div class="slider-item-table">
						<div class="slider-item-table-cell">
							<div class="container">
								<div class="row">
									<div class="col-md-12 slider-content"> <!-- Slider Text & Button -->
										<h2 class="wow fadeInDown">User Dashboard</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">User Dashboard</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
        <!-- Start Contact Form Section -->
		<div id="appoiintments" class="health-care-content-block solid-color no-padding-1"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				
				<div class="row">				
					<div class="contact-form col-md-3" style="margin-top:25px;"> <!-- Start Form Group -->
					<h3>Menu</h3>
						<?php include_once("includes/side-menu.php");?>
					</div> <!-- End Input Box -->
					
					<div class="contact-form col-md-9" style="margin-top:25px;"> <!-- Start Form Group -->
						<h3>Appointments</h3>
					<?php 
					$rslt=mysqli_query($con,"select t1.*,t2.fullName as doctor from tbl_appointments t1,tbl_doctors t2 where t1.doctorId=t2.id and t2.userId='".$_SESSION["user_id"]."' order by t1.appointmentDate asc");
					if(mysqli_num_rows($rslt))
					{
					?><form action="" method="post">
						<table class="table">
							<thead>
								<tr>
									<th>Sr. No.</th>
									<th>Name</th>
									<th>Doctor</th>
									<th>Date</th>
									<th>Email</th>
									<th>Contact No.</th>
									<th>Action</th>
								</tr>
							</thead>
							<thead>
								<?php 
								$i=0;
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
									?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $row["fullName"];?></td>
									<td><?php echo $row["doctor"];?></td>
									<td><?php echo $row["appointmentDate"];?></td>
									<td><?php echo $row["email"];?></td>
									<td><?php echo $row["contactNo"];?></td>
									<td><button style="background:transparent;border:none;" name="delete" type="submit" value="<?php echo $row["id"];?>"><i class="fa fa-close"></i></button></td>
								</tr>
								<?php }?>
							</thead>
						</table>
						</form>
					<br clear="all"/>
					<?php }?>
					
					</div> <!-- End Input Box -->
				</div> <!-- End Form Group -->
			</div>
		</div> <!-- End Container -->
	</div> <!-- End Contact Form Section -->
        
				
        
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