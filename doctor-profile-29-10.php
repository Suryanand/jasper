<?php include_once('admin/config.php');
$urlName=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_doctor_image=$row["default_doctor_image"];

$rslt=mysqli_query($con,"select * from tbl_doctors where urlName='".$urlName."'");
$row=mysqli_fetch_assoc($rslt);
	$address = $row["address"];
	$doctorId=$row["id"];
	$area = $row["area"];
	$specialized = $row["specialized"];
	$qualification = $row["qualification"];
	$location=$row["location"];
	$fullName	=$row["fullName"];
	$profile	=$row["profile"];
	$email	=$row["email"];
	$contactNo	=$row["contactNo"];
	//$fax	=$row["fax"];
	$googleMap	=$row["googleMap"];
	$activeStatus=$row["activeStatus"];
	
	if(!empty($row["image"]))
	{
		$image=$absolutePath."uploads/images/doctors/".$row["image"];
	}
	else
	{
		$image=$absolutePath."uploads/images/".$default_doctor_image;
	}
	
	$titleTag=$row["titleTag"];
	$metaDescription=$row["metaDescription"];
	$metaKeywords=$row["metaKeywords"];
	$urlName=$row["urlName"];

	if(isset($_POST["submit"]))
	{
		$companyName='Alodawaa';
	/* Get email id to submit contact form -starts*/
	$rslt=mysqli_query($con,"select subscriptionEmail from tbl_settings");
	$row=mysqli_fetch_array($rslt);
	$toEmail	= $row['subscriptionEmail']; // email id to submit contact form
	$toName		= $companyName;
	/* Get email id to submit contact form -ends*/
	
	
	$subject	= "Appointment Booking - ".$companyName;
	$fromName	= mysqli_real_escape_string($con,$_POST['fullName']);
    $fromEmail 	= mysqli_real_escape_string($con,$_POST['email']); // email id
	$phone		= mysqli_real_escape_string($con,$_POST['contactNo']); // phone number
	$comment	= mysqli_real_escape_string($con,$_POST['subject']);  // comments
	$appointmentDate	= date('Y-m-d',strtotime($_POST["appointmentDate"]));

	/* body of mail starts*/	
	$body='
	<div>This is an email from '.$companyName.' website appointment form, details are given below </div><br>
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
	mysqli_query($con,"insert into tbl_appointments(fullName,email,contactNo,appointmentDate,doctorId,subject,registrationDate) values('$fromName','$fromEmail','$phone','$appointmentDate','$doctorId','$comment',NOW())");
	/* body of mail ends*/
	$response="Your booking is successfully completed";
	require "includes/mail.php";
	echo "<script>location.href = '".$absolutePath."doctors/$urlName'</script>;";

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
			<div class="wrapper">
	<img class="logo-svg" src="assets/img/fav_icon.png" />
		</div>
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
										<h2 class="wow fadeInDown">Doctor Profile</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Doctor Profile</li>
                                        </ol>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div> <!-- End Breadcrumb Section -->
       
	   		
			
<!-- Start Sidebar Area -->
<?php include_once("includes/side-bar.php");?>
<!-- End Sidebar Area -->
	   
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
					<div class="col-md-5">
                        <div class="profile-img left-side">
                            <img src="<?php echo $image;?>" class="img-responsive" alt="Doctor Profile Image">
                            
                        </div>
                    </div>					
					<div class="col-md-7">
                        <div class="doctor-info right-side">
				            <table class="content-table">
								<h3><?php echo $fullName;?></h3>
								<tbody>
								    <tr>
								        <td>Specialty</td>
                                                                          <?php
                           
                                                $rslt5=mysqli_query($con,"select * from tbl_specialty where id=$specialized");
						$row5=mysqli_fetch_assoc($rslt5);
                        ?>
								            <td><?php echo $row5['Name'];?></td>
								        </tr>
								        <tr>
								            <td>Educations</td>
								            <td><?php echo $qualification;?></td>
								        </tr>
								        <tr>
								            <td>Profile</td>
								            <td><?php echo $profile;?></td>
								        </tr>
										<tr>
											<td>Doctor Status</td>
											<td><i class="fa fa-circle" aria-hidden="true"></i><?php if($activeStatus==1) echo "Accept New Patients";else echo "Not Available";?></td>
										</tr>										
								</tbody>
				            </table>
				            <a href="#appoiintments" class="health-care-btn view-all-btn">Book Appointment Now</a>							
				        </div>
                    </div>
				</div>
			</div> <!-- End container --> 
		</div> <!-- End Dortor Profile Section -->
        
        
        
		
        <!-- Start Contact Form Section -->
		<div id="appoiintments" class="health-care-content-block solid-color"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
					<div class="col-md-12"> <!-- Start Section Title -->
						<div class="section-title wow fadeIn">
							<p>Now Book Your</p>
							<h2>Appointment</h2>
						</div>
					</div> <!-- End Section Title -->
				</div>
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
					</div> <!-- End Form Group -->
				</div>
				
			</div> <!-- End Container -->
		</div> <!-- End Contact Form Section -->
       
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
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
		<script>
var tl = new TimelineMax({
  repeat: -1
});

tl.add(
  TweenMax.from(".logo-svg", 2, {
    scale: 0.5,
    rotation: 360,
    ease: Elastic.easeInOut
  })
);

tl.add(
  TweenMax.to(".logo-svg", 2, {
    scale: 0.5,
    rotation: 360,
    ease: Elastic.easeInOut
  })
);
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>	
        
	</body>
</html>