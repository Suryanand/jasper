<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_mails where id='".$id."'");
if(mysqli_num_rows($rslt)>0)
{
	while($row=mysqli_fetch_array($rslt))
	{
		$emailFrom=$row['emailFrom'];
		$subject=$row['subject'];
		$signature=$row['signature'];
		$body=$row['body'];
		$typeofMail=$row["templateName"];
	}
}
else
{
header('location: index.php');
}

// update mail template
if(isset($_POST["submit"]))
{
	$signature 	= mysqli_real_escape_string($con,$_POST["signature"]);
	$body	= mysqli_real_escape_string($con,$_POST["mailBody"]);
	$typeofMail	= mysqli_real_escape_string($con,$_POST["typeofMail"]);
	$subject	= mysqli_real_escape_string($con,$_POST["subject"]);
	$emailFrom	= mysqli_real_escape_string($con,$_POST["emailFrom"]);
	mysqli_query($con,"update tbl_mails set templateName='".$typeofMail."',emailFrom='".$emailFrom."',subject='".$subject."',body='".$body."',signature='".$signature."' where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'mail-settings.php'</script>";
}
if(isset($_POST["submit-test"]))
{
	
	$signature 	= $_POST["signature"];
	$body		= $_POST["mailBody"];
	$typeofMail	= mysqli_real_escape_string($con,$_POST["typeofMail"]);
	$subject	= mysqli_real_escape_string($con,$_POST["subject"]);
	$emailFrom	= mysqli_real_escape_string($con,$_POST["emailFrom"]);
	$userEmail 	= mysqli_real_escape_string($con,$_POST["testMail"]);
	$clientName="Test User";
require 'mail.php';	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
function saveButton(tab)
{
	if(tab=="template")
	{
		$("#submit").show();
		$("#reset").show();
	}
	else{
		$("#submit").hide();
		$("#reset").hide();
	}
}
</script>
</head>
<body>

	<!-- Fixed top -->
	<?php include_once('top-bar.php'); ?>
	<!-- /fixed top -->


	<!-- Content container -->
	<div id="container">

		<!-- Sidebar -->
		<?php include_once('side-bar.php'); ?>
		<!-- /sidebar -->


		<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">

			    <!-- Breadcrumbs line -->
			    <?php include_once('bread-crumbs.php'); ?>
			    <!-- /breadcrumbs line -->

			    <!-- Page header -->
			    <div class="page-header">
			    	<div class="page-title">
				    	<a href="index.php"><h5>Mail Settings</h5></a>
				    	
			    	</div>
			    </div>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        
                            </div>
						<div class="tabbable">
							<ul class="nav nav-tabs">
                                <li class=""><a href="#tab1" onClick="saveButton('template')" data-toggle="tab">Template</a></li>
                                <li><a href="#tab2" data-toggle="tab" onClick="saveButton('variable')" >Variables</a></li>

								<div class="form-actions align-right" style="padding:4px 16px;">
                                    <button type="submit" class="btn btn-info" value="submit" id="submit" name="submit">Save</button>
                                    <button type="reset" class="btn btn-danger" value="" id="reset" name="reset">Reset</button>
								</div>
							</ul>
                            <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                            <div class="well row-fluid">
								<div class="control-group">
	                                <label class="control-label">Template Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $typeofMail;?>" class="validate[required] input-xlarge" name="typeofMail" id="typeofMail"/>
	                                </div>
	                            </div>                                
                                <div class="control-group">
	                                <label class="control-label">From Email: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $emailFrom;?>" class="validate[required] input-xlarge" name="emailFrom" id="emailFrom"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Subject: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $subject;?>" class="validate[required] input-xlarge" name="subject" id="subject"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Mail Body</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="mailBody" id="mailBody" class="validate[required] span12"><?php echo $body;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Signature</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="signature" id="signature" class="validate[] span12"><?php echo $signature;?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xlarge" placeholder="Email" name="testMail" id="testMail"/>
										<input type="submit" value="Test Mail" name="submit-test" class="btn btn-info" id="submit-test"/>
	                                </div>
	                            </div>
	                        </div>
                            
                            </div>
                            <!--Tab 2-->
                            <div class="tab-pane" id="tab2">
							<div class="well row-fluid">
								<ul class="control-group">
	                                <li><i class="icon-th-large"></i>{{$c.full_name}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$c.login_username}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$c.login_user_password}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$c.confirmation_link}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$c.click_here}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$i.order_id}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$i.order_details}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$i.order_address}}</li><br>
	                                <li><i class="icon-th-large"></i>{{$i.order_total}}</li><br>
									<li><i class="icon-th-large"></i>{{$i.order_payment_method}}</li><br>
	                                <!--<li><i class="icon-th-large"></i>{{$i.delivery_date}}</li><br>-->
	                            </ul>								
								</div>	                            
								</div>
                            <!--Tab 3-->
                            
                            </div>
                            </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->
				<!-- form submition - add new user-->                
				<?php
				?>  
				<!-- /form submition -->                              
		    </div>
		    <!-- /content wrapper -->
		</div>
		<!-- /content -->
	</div>
	<!-- /content container -->

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script type="text/javascript">	
CKEDITOR.replace('mailBody');
CKEDITOR.replace('signature');
</script>
</body>
</html>