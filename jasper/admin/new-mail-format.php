<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_subscription)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_subscription_mails where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$subject=$row["subject"];
	$body=$row["body"];
	$signature=$row["signature"];	
}

if(isset($_POST["submit"]))
{
	$subject=mysqli_real_escape_string($con,$_POST["subject"]);
	$body=mysqli_real_escape_string($con,$_POST["body"]);
	$signature=mysqli_real_escape_string($con,$_POST["signature"]);
	// insert into table
	mysqli_query($con,"insert into tbl_subscription_mails (subject,body,signature,updatedOn)values('$subject','$body','$signature',NOW())") or die(mysqli_error($con));
	$rslt=mysqli_query($con,"select id from tbl_subscription_mails order by id desc limit 1");
	$row=mysqli_fetch_assoc($rslt);
	$id=$row["id"];

	echo "<script>location.href = 'news-subscription.php?id=".$id."'</script>;";																		
}

if(isset($_POST["update"]))
{
	$subject=mysqli_real_escape_string($con,$_POST["subject"]);
	$body=mysqli_real_escape_string($con,$_POST["body"]);
	$signature=mysqli_real_escape_string($con,$_POST["signature"]);
	mysqli_query($con,"update tbl_subscription_mails set subject='$subject',body='$body',signature='$signature',updatedOn=NOW() where id='".$_GET["id"]."'") or die(mysqli_error($con));
	echo "<script>location.href = 'news-subscription.php?id=".$_GET["id"]."'</script>;";																		
}

if(isset($_POST["submit-test"]))
{
	$subject=mysqli_real_escape_string($con,$_POST["subject"]);
	$body=mysqli_real_escape_string($con,$_POST["body"]);
	$signature=mysqli_real_escape_string($con,$_POST["signature"]);
	
	$body.="<br>".$signature;
	$email_to=mysqli_real_escape_string($con,$_POST["testMail"]);
	$toEmail=explode(",",$email_to);
	
	$rslt=mysqli_query($con,"select subscriptionEmail from tbl_settings");
	$row=mysqli_fetch_assoc($rslt);
	$emailFrom = $row["subscriptionEmail"];
	//die($body);
	require "mail.php";
	/* phpmail $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$emailFrom. "\r\n";
	@mail($email_to, $subject, $body, $headers); */
		
	if(!isset($_GET["id"]))
	{
		mysqli_query($con,"insert into tbl_subscription_mails (subject,body,signature)values('$subject','$body','$signature')") or die(mysqli_error($con));
		$rslt=mysqli_query($con,"select id from tbl_subscription_mails order by id desc limit 1");
		$row=mysqli_fetch_assoc($rslt);
		$id=$row["id"];
		echo "<script>location.href = 'new-mail-format.php?id=".$id."';</script>";																				
	}
	else
	{
	mysqli_query($con,"update tbl_subscription_mails set subject='$subject',body='$body',signature='$signature' where id='".$_GET["id"]."'") or die(mysqli_error($con));
	echo "<script>location.href = 'new-mail-format.php?id=".$_GET["id"]."';</script>";
	}	
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
<script>
/* confirm to delete user */
function clickMe()
{
var r=confirm("Are you sure to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
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
			  
			    <!-- /page header -->
				<br clear="all"/>
		    	<h5 class="widget-name"><i class="icon-th"></i>Email Groups
				</h5>
				
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								
								<div class="control-group">
	                                <label class="control-label">Subject:</label>
	                                <div class="controls"><input type="text" value="<?php if(isset($_GET["id"])) echo $subject;?>" name="subject" class="span12 validate[required]" /></div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Body: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="body" id="body" class="validate[required] span12"><?php if(isset($_GET["id"])) echo $body;?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Signature: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="signature" id="signature" class="validate[required] span12"><?php if(isset($_GET["id"])) echo $signature;?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xlarge" placeholder="Email" name="testMail" id="testMail"/>
										<input type="submit" value="Test Mail" name="submit-test" class="btn btn-info updt-btn" id="submit-test"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <div class="controls">
										<button type="submit" class="btn btn-info updt-btn2" name="<?php if(isset($_GET["id"])) echo "update"; else echo "submit";?>">Next</button>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
							
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
	CKEDITOR.replace('body');
	CKEDITOR.replace('signature');
	</script>
</body>
</html>
