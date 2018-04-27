<?php 
session_start();
error_reporting(0);
include_once('admin/config.php');
include_once('admin/functions.php');
$urlName=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_settings");
$row=mysqli_fetch_assoc($rslt);
$default_doctor_image=$row["default_doctor_image"];

$rslt=mysqli_query($con,"select * from tbl_trainers where urlName='".$urlName."' and type='3'");
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
	$gender=$row['gender'];
        $specialist=$row['specialist'];
        $age=$row['age'];
        $practice=$row['practice'];
        $language=$row['language'];
        $awards=$row['awards'];
        $experience=$row['experience'];
	if(!empty($row["image"]))
	{
		$image=$absolutePath."uploads/images/trainers/".$row["image"];
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
<?php
if(isset($_POST['sendcomment']))
{
$comment=$_POST['comment'];
$uid=$_POST['userId'];
$did=$_POST['doctorId'];
$ip=$_POST['Ip'];
$time=$_POST['time'];
mysqli_query($con,"insert into tbl_comments(userId,doctorId,Ip,Message,updatedOn,time) values('$uid','$did','$ip','$comment',NOW(),'$time')");
?>
<script type="text/javascript">alert("Thank You for your valuable feedback.");</script>
<?php
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
                 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
										<h2 class="wow fadeInDown">Doctor Profile</h2>
										<ol class="breadcrumb">
                                            <li><a href="<?php echo $absolutePath;?>">Home</a></li>                                            
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
       
        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="row">
<div class="col-md-12 contact-info wow fadeIn">
<div class="doctor-info2 right-side">
<h2><?php echo $fullName;?></h2>
<?php
$rslt5=mysqli_query($con,"select * from tbl_specialty where id='".$specialized."'");
$row5=mysqli_fetch_assoc($rslt5);
?>
<h3 class="mt-0"><?php echo $row5['Name'];?>  |  <?php if($gender=='1'){ echo 'Male';} else {echo 'Female';}?></h3>
<p class="mt-10"><label class="filter-label"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></label></p>
<div>
<?php
$smallprofile=strip_tags($profile);    
?>
<input type="checkbox" class="read-more-state" id="post-1" />
<p class="read-more-wrap mt-0"><?php echo substr($smallprofile,0,150);?><span class="read-more-target" style="color:#5e5e5e"><?php echo substr($smallprofile,150,200);?><a href='#detaiils'>...</a></span></p>
<label for="post-1" class="read-more-trigger"></label>
</div>
</div>
                    </div>
                    <div class="col-md-12 contact-info wow fadeIn p-0">
				           <!-- <a href="#appoiintments" style='width:45%;float:left;' class="health-care-btn view-all-btn"></a>-->
                            <a href="#appoiintments"> <div class="col-md-4 p-0 black-tab">
                 <span><h4><i class="fa fa-calendar" style="color:white" aria-hidden="true"></i>Book Appointment Now</h4></span>
                </div></a>
                           <!-- <a href=""  style='width:45%;float:right;' class="health-care-btn view-all-btn">Leave a Review</a>-->
<!--                           <a href="#" onclick="document.getElementById('id01').style.display='block'"> <div class="col-md-8 p-0 black-tab">-->
                            <a href="#commentsposition"> <div class="col-md-8 p-0 black-tab">
                 <span><h4> <i class="fa fa-star" style="color:white" aria-hidden="true"></i>Leave a Review</h4></span>
                </div></a>
                           </div>
					<div class="col-md-12 contact-info wow fadeIn">
                    <div class="col-md-3">
                    <h3><?php echo $fullName;?></h3>
<p> 
<?php if($specialist!=''){ echo $specialist; } else { ?>   
<?php
$catArray=explode(',',$specialized);
$rslt=mysqli_query($con,"select * from tbl_specialty");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>
<?php echo $row['Name'];?>
<?php }} }?></p>
                    <h3><?php echo $qualification;?></h3>
                    </div>
                      <div class="col-md-2" style="border-left: 1px solid #eee; border-right: 1px solid #eee;">
                       <div class="profile-img left-side">
                            <img src="<?php echo $image;?>" class="img-responsive" alt="<?php echo $fullName;?>">
                            <p><?php //echo $fullName;?></p>
                            
                        </div>
                    </div>
<div class="col-md-7 pl-30">
<h3>Practice Locations</h3>
<ul class="ul-cs mt-20">
<?php
$catArray=explode(',',$practice);
$rslt=mysqli_query($con,"select * from tbl_firm");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>    
<a href="<?php echo $absolutePath.hopitals."/".$row["urlName"];?>"><li style="color: #5e5e5e;font-family: 'Ubuntu';font-size: 16px;text-transform: capitalize;"><?php echo $row['companyName'];?>, <?php echo $row['area'];?></li></a>
<?php }}?>
</ul>  
<h3>Languages Known</h3>
<br clear="all">
<?php
$catArray=explode(',',$language);
$rslt=mysqli_query($con,"select * from tbl_language");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>    
<span title="<?php echo $row['Name'];?>" style="font-family: 'Ubuntu', sans-serif;font-size: 16px;line-height: 26px;color:#5e5e5e">[<?php echo $row['Name'];?>]</span>
<?php }}?> 
<?php if($age!=''){ ?>
<h3>Years of Experience</h3>
<br clear="all">   
<span style="font-family: 'Ubuntu', sans-serif;font-size: 16px;line-height: 26px;color:#5e5e5e"><?php echo $age;?></span>
<?php } ?>
</div>					
					
				</div>
                           
			</div> <!-- End container --> 
<div class="row" id='detaiils'>
<div class="col-md-12 mt-20 contact-info wow fadeIn">
<h3><i class="fa fa-file-text-o" style="color:#737573" aria-hidden="true"></i> Learn about <?php echo $fullName;?></h3>
<p style="text-align:justify"><?php echo $profile;?></p>
<hr>
<?php if($experience!=''){?>
<h3><i class="fa fa-briefcase" style="color:#737573" aria-hidden="true"></i> Work Experience</h3>
<p style="text-align:justify"><?php echo $experience;?></p>
<hr><?php } ?>
<?php if($qualification!=''){?>
<h3><i class="fa fa-graduation-cap" style="color:#737573" aria-hidden="true"></i> Education</h3>
<p style="text-align:justify"><?php echo $qualification;?></p>
<hr><?php } ?>
<?php if($awards!=''){?>
<h3><i class="fa fa-trophy" style="color:#737573" aria-hidden="true"></i> Awards & Recognition</h3>
<p style="text-align:justify"><?php echo $awards;?></p>
<hr><?php } ?>
</div>
            <div class="col-md-12 contact-info wow fadeIn mt-20" id="commentsposition">
<div class="comments-section left-right-padding">
<?php    
$rslt1=mysqli_query($con,"select * from tbl_comments where doctorId=$doctorId and activeStatus='1'");
$num1=mysqli_num_rows($rslt1);
?>    
<h3 class=""><?php echo $num1;?> Comments</h3>
<ul class="comment-list">
<?php    
$rslt=mysqli_query($con,"select * from tbl_comments where doctorId=$doctorId and activeStatus='1'");
while($row=mysqli_fetch_array($rslt)){
$userId=$row['userId'];
?>
<li class="comment">
<div class="the-comment">
<div class="avatar">
<img src="<?php echo $absolutePath;?>assets/img/avater1.png">
</div>
<div class="comment-box">
<div class="comment-author meta">
<?php    
$rslt7=mysqli_query($con,"select * from tbl_users where userId=$userId");
$row7=mysqli_fetch_array($rslt7);
?>
<h4><strong><?php echo $row7['userFirstName'];?>&nbsp;&nbsp;<?php echo $row7['userLastName'];?></strong></h4>
<p><?php echo date('d M Y', strtotime($row["updatedOn"]));?>  /  at <?php echo $row['time'];?></p>                                                    
</div>
<div class="comment-text">
<p><?php echo $row['Message'];?></p>
<!--<a rel="nofollow" class="comment-reply-link" href="#"> Reply</a>-->
</div>
</div>
</div>
</li>
<?php } ?>
</ul>
</div>
<div class="divider"></div>
<?php if($_SESSION["user_id"]!=''){?>
<div class="comments-form-section left-right-padding">
<h3 class="single-page-heading">Leave a Comment</h3><br>
<form method="post">
<!--<div class="comments-form input-box left">  Name Box 
<p><input type="text" class="form-control" placeholder="Your Full Name"></p>							
</div>-->
<!--<div class="comments-form input-box left ml-20">  Email Box 
<p><input name="email" type="email" class="form-control" placeholder="Your Email Address"></p>							
</div>-->
<div class="comments-form text-area"> <!-- Text Area Box -->
<p><textarea name="comment" required class="form-control textarea-box" placeholder="Comment" required></textarea></p>						
</div> 
<input type="hidden" name="userId" value="<?php echo $_SESSION["user_id"];?>">
<input type="hidden" name="doctorId" value="<?php echo $doctorId;?>">
<input type="hidden" name="Ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>">
<input type="hidden" name="time" value="<?php echo date("h:i a");?>">
<div class="comments-form submit-button"> <!-- Submit Button -->
<input type="submit" class="health-care-btn submit-btn" name="sendcomment" value="Submit">					
</div>
</form>
</div>
<?php } else{ ?>
<div class="comments-form submit-button"> <!-- Submit Button -->
<a href='<?php echo $absolutePath;?>login.php'><input type="submit" class="health-care-btn submit-btn" value="Post your Response"></a>					
</div>
<?php } ?>

            </div>
            </div>
		</div> <!-- End Dortor Profile Section -->
        </div>
<?php
if(isset($_POST['submitform']))
{
$usrname=$_POST['usrname'];
$usremail=$_POST['usremail'];
$usrcomment=$_POST['usrcomment'];
$docid=$_POST['docId'];
$ip=$_POST['Ip'];
mysqli_query($con,"insert into tbl_review (docId,Ip,Name,Email,Comment,updatedOn)values('".$docid."','".$ip."','".$usrname."','".$usremail."','".$usrcomment."',NOW())") ;
?>
<script type="text/javascript">alert("Thank you for your valuable feedback.")</script>                
<?php
}
?>                
<div id="id01" class="w3-modal">
<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
<div class="w3-center"><br>
<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
<img src="<?php echo $image;?>" alt="<?php echo $row["fullName"];?>" style="width:18%" class="w3-circle w3-margin-top"><br clear='all'><h4><?php echo $fullName;?></h4>
</div>
<form class="w3-container" method="POST">
<div class="w3-section">
<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Your Name" name="usrname" required>
<input class="w3-input w3-border" type="email" placeholder="Your Email" name="usremail" required><br>
<textarea name="usrcomment" placeholder="Your Comments" class="w3-input w3-border" required></textarea>
<input type="hidden" name="Ip" value="<?php echo $_SERVER['REMOTE_ADDR'];?>">
<input type="hidden" name="docId" value="<?php echo $doctorId;?>">
<input class="w3-button w3-block w3-section w3-padding" style="background:#3586d6;color:white" type="submit" name="submitform" value="Submit">
</div>
</form>
</div>
</div>        

<!-- Start Contact Form Section -->
		<div id="appoiintments" style='margin-top: -107px;' class="health-care-content-block solid-color pt-30"> <!-- Start Content Block -->
			<div class="container">	<!-- Start Container -->			
				<div class="row">
					<div class="col-md-12"> <!-- Start Section Title -->
						<div class="section-title wow fadeIn">
							<p>Now Book Your</p>
							<h2>Appointment</h2>
						</div>
					</div> <!-- End Section Title -->
				</div>
				<div class="row" style='margin-top: -76px;'>
					<div class="contact-form"> <!-- Start Form Group -->
					<form action="" method="post">
						<div class="col-sm-6 col-md-6"> 
							<div class="appoiintments-form"> <!-- Select Menu -->	
								<p><input type="text" required name="subject" class="form-control" placeholder="I would like to discuss"></p>
							</div>						
						</div>
						<div class=""> <!-- Start Input Box -->		
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Name Box -->
									<p><input type="text" required class="form-control" name="fullName" placeholder="Your Full Name"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Phone Number Box -->						
									<p><input  type="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required class="form-control" name="contactNo" placeholder="Your Phone Number"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Visit Date Box -->	 						
									<p><input name="appointmentDate" required type="date" class="form-control"></p>
								</div>						
							</div>
							<div class="col-sm-6 col-md-6">
								<div class="appoiintments-form"> <!-- Email Box -->							
									<p><input name="email" required type="email" class="form-control" placeholder="Your Email Address"></p>
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
        
	</body>
</html>