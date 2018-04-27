<?php include_once('admin/config.php');
if(isset($_POST["submit"]))
	{
		$companyName='Alodawaa';
	/* Get email id to submit contact form -starts*/
	$rslt=mysqli_query($con,"select subscriptionEmail from tbl_settings");
	$row=mysqli_fetch_array($rslt);
	$toEmail	= $row['subscriptionEmail']; // email id to submit contact form
	$toName		= $companyName;
	/* Get email id to submit contact form -ends*/
	
	
	$subject	= "Enquiry - ".$companyName;
	$fromName	= mysqli_real_escape_string($con,$_POST['fullName']);
    $fromEmail 	= mysqli_real_escape_string($con,$_POST['email']); // email id
	$phone		= mysqli_real_escape_string($con,$_POST['contactNo']); // phone number
	$comment	= mysqli_real_escape_string($con,$_POST['subject']);  // comments
	$appointmentDate	= date('Y-m-d',strtotime($_POST["appointmentDate"]));

	/* body of mail starts*/	
	$body='
	<div>This is an email from '.$companyName.' website contact form, details are given below </div><br>
	<table border="1" cellpadding="1" cellspacing="1" style="width:500px">
		<tbody>
			<tr>
				<td>Name</td>
				<td>&nbsp;'.$fromName.'</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>&nbsp;'.$fromEmail.'</td>
			</tr>';			
				
			
			if(isset($phone))
			{
				$body.='<tr>
					<td>Phone</td>
					<td>&nbsp;'.$phone.'</td>
				</tr>';
			}
			/*$body.='<tr>
					<td>Region</td>
					<td>&nbsp;'.$region.'</td>
				</tr>';*/
			$body.='<tr>
					<td>Subject</td>
					<td>&nbsp;'.$comment.'</td>
				</tr>';
				$body.='<tr>
					<td>Appointment date</td>
					<td>&nbsp;'.$appointmentDate.'</td>
				</tr>
		</tbody>
	</table>

	<p>&nbsp;</p>
	';
	/* body of mail ends*/
	$response="Your booking is successfully completed";
	require "includes/mail.php";
	echo "<script>location.href = '".$absolutePath."appointment'</script>;";

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
										<h2 class="wow fadeInDown">Now Book Your Appointment</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Appointment</li>
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
					<div class="contact-form"> <!-- Start Form Group -->
					<form action="" method="post">
						<div class="col-sm-6 col-md-6"> 
							<div class="appoiintments-form"> <!-- Select Menu -->	
								<p><input type="text" name="subject" class="form-control" placeholder="I would like to discuss"></p>
							</div>						
						</div>
						<div class=""> <!-- Start Input Box -->		
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Name Box -->
									<p><input type="text" class="form-control" name="fullName" placeholder="Your Full Name"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Phone Number Box -->						
									<p><input  type="tel" class="form-control" name="contactNo" placeholder="Your Phone Number"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Visit Date Box -->	 						
									<p><input name="appointmentDate" type="date" class="form-control"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Email Box -->							
									<p><input name="email" type="email" class="form-control" placeholder="Your Email Address"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6"> <!-- Submit Button Box -->
								<div class="appoiintments-form">
									<input type="submit" name="submit" class="health-care-btn submit-btn" value="Book Appointment Now">
								</div>						
							</div>
						</div> <!-- End Input Box -->
						</form>
					</div> </div>
				<div class="row"> <!-- Start Contact Information -->
					<div class="contact-info-section">
						<div class="col-sm-6 col-md-6">
							<div class="contact-info wow fadeIn">
								<i class="icofont icofont-doctor"></i>
								<h3> Medical Address</h3>
								<p>350 Lorem ipsum dolor <br/>
								adipiscing elit</p>							
							</div>
						</div>	
						<div class="col-sm-6 col-md-6">
							<div class="contact-info wow fadeIn">
								<i class="icofont icofont-ambulance"></i>
								<h3>Emergency Contact</h3>
								<p>Call Now:  <a href="#">+05 234567</a>
								<br>Email:  <a href="#">contact@alodawaa.com</a></p>							
							</div>
						</div>
						<!--<div class=" col-sm-12 col-md-4">
							<div class="contact-info wow fadeIn">
								<i class="icofont icofont-wall-clock"></i>
								<h3>Opening Hours</h3>
								<p>Monday - Friday <span>8.00 - 17.00</span>
								<br>Saturday - Sunday <span>8.00 - 17.00</span></p>
							</div>
						</div>-->
					</div>
				</div> <!-- End Contact Information -->
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