<?php 
session_start();
$_SESSION['security_number']=rand(10000,99999);
include_once('admin/config.php');
include_once('admin/functions.php');
function send_mail($email,$fullName,$rand,$usr)
{
	global $absolutePath;	
	$emailHash	= urlencode(encryptIt($email));
	$userEmail=$email;
	$confirmLink="<a href='".$absolutePath."confirm-registration.php?ids=$rand&vI=$emailHash'>click here</a>";
	$link="<a href='".$absolutePath."confirm-registration.php?ids=$rand&vI=$emailHash'>".$absolutePath."confirm-registration.php?ids=".$rand."&vI=".$emailHash."</a>";
	
	
	$subject="Alodawaa Account Registration Confirmation";
	$body='<p>Hello '.$fullName.',</p>

<p>To activate your account, please take one of the following actions:<br />
&bull; '.$confirmLink.'<br />
OR<br />
&bull; Copy and paste the following link in your browser:<br />
'.$link.'<br />
<br />
Please Note: For security reason, this email has been sent only to your registered email addresses associated with your Dubai Jobs Club account.</p>
';

			$cleanedFrom="mail@alodawaa.com";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <'.$cleanedFrom.'>' . "\r\n";
			$mailto=$email;
			//$email="asif@jaspermicron.com";
			
			mail($mailto,$subject,$body,$headers);			
	
	$_SESSION["response"]="Account activation URL has been sent to your registered email address. Check your email account.";
}
if(isset($_POST['register']))
{
if($_POST['captcha'] == $_POST['captchaCode'])
	{    
	$fullName	= mysqli_real_escape_string($con,$_POST['fullName']); // first Name
	$email	= mysqli_real_escape_string($con,$_POST['email']); 
	$password	= encryptIt(mysqli_real_escape_string($con,$_POST['password']));
	$rand 		= rand();
	$rslt=mysqli_query($con,"select * from tbl_user_login where email='$email'");
	if(mysqli_num_rows($rslt)==0)
	{
   // insert candidate details into table
   	mysqli_query($con,"insert into tbl_user_login (fullName,email,password,confirmationCode,registeredOn,userType) values('".$fullName."','".$email."','".$password."','".$rand."',NOW(),'2')") or die(mysqli_error($con));
	$userId = $con->insert_id;
	
	//send confirmation link
	send_mail($email,$fullName,$rand,'1');	
	echo "<script>location.href = '".$absolutePath."login'</script>";exit();
	}
	else
	{
		echo "<script>alert('This email id already registered');</script>";		
		echo "<script>location.href = '".$absolutePath."login'</script>";exit();
	}
}
   
        else
	{
	echo "<script>alert('Invalid Captcha');</script>";		
		echo "<script>location.href = '".$absolutePath."login'</script>";exit();	
	}
}

if(isset($_POST["login"]))
{
	$username=mysqli_real_escape_string($con,$_POST["username"]);
	$password=encryptIt(mysqli_real_escape_string($con,$_POST["password"]));
	$rslt=mysqli_query($con,"select * from tbl_user_login where (email='$username' or username='$username') and password='$password' and activeStatus=1") or die(mysqli_error($con));
    $rows=mysqli_num_rows($rslt);
	if ($rows>0) 
    { 	/* logged in*/		
    	$row=mysqli_fetch_assoc($rslt);
        $_SESSION['user_id'] = $row["id"]; /*set user_id to session */
        $_SESSION['user_type'] = $row["userType"]; /*set user_type to session */
		$_SESSION['user_name']=$row["fullName"];
		echo "<script>location.href = '".$absolutePath."user-home';</script>";exit();
	}
	else
	{
		echo "<script>location.href = '".$absolutePath."login.php?err=1';</script>";exit();
	}
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
										<h2 class="wow fadeInDown">Now Login To Your Account</h2>
										<ol class="breadcrumb">
                                            <li><a href="index.php">Home</a></li>                                            
                                            <li class="active">Login</li>
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
				<?php 
				if(isset($_SESSION["response"]))
				{
					echo '<h4 class="response">'.$_SESSION["response"].'</h4>';
					unset($_SESSION["response"]);
				} ?>
					<div class="contact-form col-md-6" style="margin-top:25px;"> <!-- Start Form Group -->
						<h3>Already Registered?</h3>
						<form action="" method="post">
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Name Box -->
								<p><input type="text" name="username" required class="form-control" placeholder="Username"></p>							
							</div>						
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="password" required type="password" class="form-control" placeholder="Password"></p>
							</div>						
						</div>
						<?php if(isset($_GET["err"])){?>
             <p style="color:red;padding-left: 15px;">Invalid username or password</p>
			  <?php }?>
						<div class="col-sm-12 col-md-12"> <!-- Submit Button Box -->
							<div class="appoiintments-form">
								<input type="submit" name="login" class="health-care-btn submit-btn" value="Sign In">
							</div>
						</div>
						</form>
					</div> <!-- End Input Box -->
					
					<div class="contact-form col-md-6" style="margin-top:25px;"> <!-- Start Form Group -->
						<h3>Register Now</h3>
						<form action="" method="post">
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Name Box -->
								<p><input type="text" required name="fullName" class="form-control" placeholder="Your Name"></p>							
							</div>						
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Name Box -->
								<p><input type="email" required name="email" class="form-control" placeholder="Email"></p>							
							</div>						
						</div>
						<br clear="all"/>
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="password" required type="password" class="form-control" placeholder="Password"></p>
							</div>						
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="appoiintments-form"> <!-- Phone Number Box -->						
								<p><input name="conpass" required type="password" class="form-control" placeholder="Confirm Password"></p>
							</div>						
						</div>
						<br clear="all"/>
                                                <div class="col-sm-12 col-md-12">
                                                    
							<div class="appoiintments-form"> <!-- Phone Number Box -->
                                                            <p><img src="image.php" alt="well, this is out capcha image" height="50" width="100" />
								<input name="captcha" style="width:80%;float:right" required type="text" class="form-control" placeholder="Enter the code shown"></p>
                                                                <input id="captchaCode" name="captchaCode" value="<?php echo $_SESSION['security_number'] ?>" type="hidden">
							</div>						
						</div>
						<br clear="all"/>
						<div class="col-sm-12 col-md-12"> <!-- Submit Button Box -->
							<div class="appoiintments-form">
								<input type="submit" name="register" class="health-care-btn submit-btn" value="Sign Up">
							</div>
						</div>
						</form>
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