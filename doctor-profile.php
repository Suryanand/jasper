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
        $hierarchy=$row["hierarchy"];
        $specialist=$row["specialist"];
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
			<!--<div class="spinner"></div>-->
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
       
	   
<!-- Start Sidebar Area -->
<?php include_once("includes/side-bar.php");?>
<!-- End Sidebar Area -->

        <!-- Start Dortor Profile Section -->        
        <div class="health-care-content-block solid-color"> <!-- Start Content Block -->			
			<div class="container "> <!-- Start container --> 			
				<div class="doctor-details">

        <div class="row panel-accordion" id="accordion">
          <aside class="col-md-5 col-sm-6">
                
               
  
<div class="graybox clearfix">
    <div class="pad">
        <div class="name-title appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
            <h2 id="doctorTileHeading">
<?php echo $fullName;?></h2>
<!--<p class="role"><?php echo $qualification;?>
</p>-->
            
        </div>
        
        <div class="img-doctor appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
            <div id="ctl00_PlaceHolderMain_DoctorProfile_imgProfilePicture_label" style="display:none">Profile Picture</div><div id="ctl00_PlaceHolderMain_DoctorProfile_imgProfilePicture__ControlWrapper_RichImageField" class="ms-rtestate-field" style="display:inline" aria-labelledby="ctl00_PlaceHolderMain_DoctorProfile_imgProfilePicture_label"><div class="ms-rtestate-field"><img alt="<?php echo $fullName;?>" src="<?php echo $image;?>" width="350" style="border:0px solid"></div></div>
        </div>
        

        <ul class="list-docdetails appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
            
<li>
<div class="txt">Languages<br>Spoken</div>
<?php
$catArray=explode(',',$language);
$rslt=mysqli_query($con,"select * from tbl_language");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?> 
<span class="knowlang" title="<?php echo $row['Name'];?>"><?php echo strtoupper(substr($row['Name'],0,2));?></span>
<?php }}?> 
</li>
<?php
if($specialist!=''){ 
?>            
<li>
<div class="txt"><?php echo $specialist;?></div><div data-icon="x" class="icon"><i class="fa  fa-check"></i></div>
</li>
<?php } ?>
<?php 
if($age!=''){ ?>
<li>
<div class="txt">YEARS OF <br>EXPERIENCE</div>
<span class="num"><?php echo $age;?></span>
<?php } ?>
</li>


            
        </ul>
    </div>
    <!--<aside class="action appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">        
        <a href="http://pdfgen.ccaduae.ae?url=https://www.clevelandclinicabudhabi.ae/en/find-a-doctor/Pages/hicham-abada.aspx&amp;filename=hicham-abada-10302017" id="ctl00_PlaceHolderMain_DoctorProfile_lnkDownload" class="btn btn-blue btn-lg">
       DOWNLOAD PROFILE
            <i data-icon="y" class="icon"></i>
        </a>
        <a href="javascript:void(0);" onclick="javascript:CCAD.Print();" class="btn btn-darkgray btn-lg">
            PRINT PROFILE
            <i data-icon="i" class="icon"></i></a>
    </aside>-->
</div>

<aside class="diagnosis appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0" id="tags">
              
              

<div id="ctl00_PlaceHolderMain_Diseases_EditModePanel1">
	
<h2 id="ctl00_PlaceHolderMain_Diseases_EditModePanel1_headingDoctor"><?php echo $fullName;?> can help you with...</h2>

</div>
<!--<form method="post" action="http://demo.jaspermicron.com/alodawaa/final/firm-specialty">
<input type="hidden" name="comp" value="1">-->  
<?php
$catArray=explode(',',$specialized);
$rslt=mysqli_query($con,"select * from tbl_specialty");
while($row=mysqli_fetch_array($rslt))
{											
?>
<?php if(in_array($row["id"],$catArray)){?>
<button name="spec" value="10" class="tm"><?php echo $row['Name'];?></button>
<!--<input type="submit" name="firmsubmit" value="Anaesthesiology" class="tag-bt">-->
<?php }} ?>
<!--</form>-->

	
                <!--<div class="text-center hidden-xs"> 
                    
                    <a id="ctl00_PlaceHolderMain_Diseases_EditModePanel81_lnkSeeMore" class="link-seemore" data-js="seeMore" href="javascript:void(0);">See More</a>

                    <a id="ctl00_PlaceHolderMain_Diseases_EditModePanel81_lnkSeeLess" class="link-seemore" data-js="seeLess" href="javascript:void(0);" style="display:none">See Less</a>
                     
                </div>-->
            


            
           
            </aside>
            
            
            

            
            <div class="divider-dash appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0"></div>
            <aside class="diagnosis adjustFont appear rvfs-2 fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0" data-rvfs="2">
            
              
              <div id="ctl00_PlaceHolderMain_NoteField2_label" style="display:none">Achievements</div><div id="ctl00_PlaceHolderMain_NoteField2__ControlWrapper_RichHtmlField" class="ms-rtestate-field" style="display:inline" aria-labelledby="ctl00_PlaceHolderMain_NoteField2_label"></div>
              
              
                




            </aside>

            
          </aside>

          
          <aside class="col-md-7 col-sm-6">
            <aside class="panel-default appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
              <div class="biography leftp adjustFont rvfs-2" data-rvfs="2">
                <div class="panel-heading">
                  <h2 id="biographyheading">Biography</h2>
                </div>
                <div class="panel-body">
                <div id="ctl00_PlaceHolderMain_NoteField15_label" style="display:none">Biography</div><div id="ctl00_PlaceHolderMain_NoteField15__ControlWrapper_RichHtmlField" class="ms-rtestate-field" style="display:inline" aria-labelledby="ctl00_PlaceHolderMain_NoteField15_label">
<?php echo $profile;?></div>
                </div>
              </div>
            </aside>
<?php if($awards!=''){ ?>              
            <aside class="panel-default appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
              <div class="biography leftp adjustFont rvfs-2" data-rvfs="2">
                <div class="panel-heading">
                  <h2 id="biographyheading">Awards & Recognitions</h2>
                </div>
                <div class="panel-body">
                <div id="ctl00_PlaceHolderMain_NoteField15_label" style="display:none">Awards</div><div id="ctl00_PlaceHolderMain_NoteField15__ControlWrapper_RichHtmlField" class="ms-rtestate-field" style="display:inline" aria-labelledby="ctl00_PlaceHolderMain_NoteField15_label">
<?php echo $awards;?></div>
                </div>
              </div>
            </aside>
<?php } ?>             
            <aside class="panel-default">
              <div class="prof-journey">
              
                  
<link rel="stylesheet" href="//s2.ccaduae.ae/fonts/families.css">
<link rel="stylesheet" href="//s2.ccaduae.ae/fonts/font-awesome.min.css">

<div id="ctl00_PlaceHolderMain_WorkExperience_plnContent">
<?php
$rslt6=mysqli_query($con,"select * from tbl_trainer_education where trainerId='".$doctorId."'");
$educationnum=mysqli_num_rows($rslt6);
$rslt7=mysqli_query($con,"select * from tbl_trainer_work where trainerId='".$doctorId."'");
$worknum=mysqli_num_rows($rslt7);
?>
<?php if($educationnum+$worknum!=0){?>    
<div class="panel-heading appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0">
<h3>
PROFESSIONAL JOURNEY</h3>
</div>
<?php } ?>    
    <div class="panel-body">
        <aside class="timeline">
<?php if($educationnum!=0) { ?>                  
<header class="head appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0"> <span>Education</span> </header>
<ul class="list-experience">
<?php
$rslt8=mysqli_query($con,"select * from tbl_trainer_education where trainerId='".$doctorId."'");
while($row8=mysqli_fetch_assoc($rslt8)){
?>    
<li class="appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0"><span class="year"><?php echo $row8['fromDate'];?></span>
<aside class="box">
<div class="duration"><?php echo $row8['fromDate'];?> - <?php echo $row8['toDate'];?> </div>
<div class="organisation"><?php echo $row8['Institute'];?></div>
<div class="position"><?php echo $row8['Department'];?></div>
</aside>
</li>
<?php } ?>
</ul>
<?php } ?>

<?php if($worknum!=0) { ?>   
<header class="head appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0"> <span>Work Experience</span> </header>
<ul class="list-experience">
<?php
$rslt9=mysqli_query($con,"select * from tbl_trainer_work where trainerId='".$doctorId."'");
while($row9=mysqli_fetch_assoc($rslt9)){
?>    
<li class="appear fadeInDown visible animated" data-animation="fadeInDown" data-animation-delay="0"><span class="year"><?php echo $row9['fromDate'];?></span>
<aside class="box">
<div class="duration"><?php echo $row9['fromDate'];?> - <?php echo $row9['toDate'];?> </div>
<div class="organisation"><?php echo $row9['Institute'];?></div>
<div class="position"><?php echo $row9['Department'];?></div>
</aside>
</li>
<?php } ?>
</ul>
<?php } ?>

                  </aside>
    </div>

</div>

                
              </div>
            </aside>
          </aside>
        </div>
        <div class="row">
        <div class="col-sm-12">
        <!--<div class="event-back"><a href="javascript:window.history.back();" class="btn btn-black btn-lg"><div data-icon="h" class="icon englishicon"></div><div data-icon="f" class="icon arabicicon"></div>Back</a></div>-->
        </div>
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
        <style>
		.doctor-details .graybox {
    background: #e3e3e3;
    text-align: center;
}
.doctor-details .graybox .pad {
    padding: 4% 2%;
    z-index: 1;
    position: relative;
}
.doctor-details h1, .doctor-details .graybox h2 {
    font-size: 40px;
    color: #338ff2;
    margin: 0;
}
.doctor-details .role {
       font-size: 17px;
    font-family: Arial;
    margin: .25em 0;
}
.doctor-details .img-doctor {
    padding: 1em;
}
.doctor-details .img-doctor img {
 /*   border-radius: 50%;
    -moz-border-radius: 50%;*/
}
.list-docdetails {
    text-align: center;
    margin: 0;
	padding:0;
}
.list-docdetails>li:first-child {
    border-left: none;
}
.list-docdetails > li {
    padding: 0 .75em;
}
.list-docdetails>li {
    border-left: solid 1px #cecece;
    display: inline-block;
    vertical-align: top;
    padding: 0 .4em;
}
.list-docdetails .txt {
    font-size: 1.15em;
    text-transform: uppercase;
    min-height: 3em;
    font-weight: 700;
    line-height: 1.2;
}
.list-docdetails .knowlang {
    min-width: 35px;
}
.list-docdetails .knowlang {
    background: #3290f2;
    padding: .4em;
    color: #fff;
    font-size: 1.06em;
    text-transform: uppercase;
    display: inline-block;
    margin-top: .35em;
    vertical-align: top;
    text-align: center;
    cursor: default;
}
.list-docdetails .icon {
    font-size: 3.6em;
    line-height: 1;
    color: #3290f2;
}
.list-docdetails .num {
    font-size: 3.6em;
    color: #3290f2;
    line-height: 1;
    font-weight: 700;
    font-family: Arial;
}
.diagnosis h2, .biography .diagnosis h2 {
    font-size: 1.28em;
    color: #3290f2;
    font-weight: 700;
    text-transform: none;
    margin-top: 1em;
}
.diagnosis .btn-transparent {
    border-color: #cecece;
    background: #f5f5f5;
    color: #333 !important;
    margin: 0 .5em .75em 0;
    padding: 7px 1em;
    text-transform: capitalize;
    font-size: 1.04em;
    min-width: 6.5em;
}
.diagnosis .link-seemore {
    text-transform: uppercase;
    text-decoration: underline;
    color: #414141;
    display: inline-block;
    margin-top: .5em;
}
.biography.leftp {
    margin-left: .75em;
}
.biography h2, .biography h3, .biography h4, .prof-journey h3 {
    color: #1d7dca !important;
    font-size: 2.180232558em !important;
    text-transform: uppercase;
    font-weight: 400;
    margin: 0 0 .25em;
    line-height: 1;
}
.prof-journey {
    margin: 1.75em 0 0 .75em;
}
.timeline {
    border-left: solid 2px #777;
    margin: 1em 0 3em;
}
.prof-journey .head span {
    background: #eee;
    position: relative;
    z-index: 1;
    padding: 0 .5em 0 .75em;
}
.prof-journey .head:after {
    content: '';
    display: inline-block;
    border-bottom: dotted 2px #bfbfbf;
    width: 100%;
    position: absolute;
    left: 0;
    top: 45%;
}
.list-experience>li {
    padding: 2em 0 2em 7em;
    position: relative;
}
.list-experience .year {
    background: #979797;
    color: #fff;
    padding: .25em .5em;
    position: absolute;
    left: 0;
    top: 50%;
    min-width: 60px;
    text-align: center;
    margin-top: -13px;
    font-size: 1.1em;
}
.list-experience .duration {
    color: #757575;
    font-size: .95em;
}
.list-experience .organisation {
    font-size: 1.162790698em;
    color: #007647;
    text-transform: uppercase;
}
.list-experience .position {
    font-weight: 700;
    font-size: 1.01744186em;
}
.search.btn {
    padding: 4px 10px 10px 10px !important;
}
ul.list-experience {
    margin: 0 0 10px;
    padding: 0;
    list-style: none;
}
.tm{
border-color: #cecece;
    background: #f5f5f5;
    color: #333 !important;
    margin: 0 .5em .75em 0;
    padding: 7px 1em;
    text-transform: capitalize;
    font-size: 1.04em;
    min-width: 6.5em;	
}
.doctor-details .img-doctor {
    padding: 2em;
}
		</style>
       
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