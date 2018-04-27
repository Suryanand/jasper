<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

// get privacy details
$rslt=mysqli_query($con,"select * from tbl_information");
if(mysqli_num_rows($rslt)>0)
{
	$flag=1;
	$row=mysqli_fetch_assoc($rslt);
	$termsCondition=$row["termsCondition"];
	$privacyPolicy=$row["privacyPolicy"];
	$refundPolicy=$row["refundPolicy"];
}
else
{
	$flag=0; // about details not saved
}


// form submit
if(isset($_POST["submit"]))
{
	$termsCondition=$_POST["termsCondition"];
	$privacyPolicy=$_POST["privacyPolicy"];
	$refundPolicy=$_POST["refundPolicy"];
	if($flag==0)
	{ // new  details
		mysqli_query($con,"insert into tbl_information (termsCondition,privacyPolicy,refundPolicy)values('$termsCondition','$privacyPolicy','$refundPolicy')") or die(mysqli_error($con));
		$_SESSION["response"]="Details Saved";
	}
	else
	{ // update details
		mysqli_query($con,"update tbl_information set termsCondition='$termsCondition',privacyPolicy='$privacyPolicy',refundPolicy='$refundPolicy'");	
		$_SESSION["response"]="Details Updated";
	}
	echo "<script>location.href = 'terms-policy.php'</script>;";																		
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
			    <br>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Informations</h6></div></div>
	                    	<div class="well row-fluid">                                
								<div class="control-group">
	                                <label class="control-label">Terms and Conditions:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="termsCondition" class="validate[required] span12"><?php if($flag==1) echo $termsCondition; ?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Privacy Policy:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="privacyPolicy" class="validate[required] span12"><?php if($flag==1) echo $privacyPolicy; ?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Refund Policy:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="refundPolicy" class="validate[required] span12"><?php if($flag==1) echo $refundPolicy; ?></textarea>
	                                </div>
	                            </div>
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>

	                        </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->
                
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
	<?php 
    // echo response 
    if(isset($_SESSION["response"]))
    {
        echo "<script>alert('".$_SESSION["response"]."');</script>";
        unset($_SESSION["response"]);
    }
    ?>
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
	<script type="text/javascript">
	CKEDITOR.replace('termsCondition', {height: '150px'});
	CKEDITOR.replace('privacyPolicy', {height: '150px'});
	CKEDITOR.replace('refundPolicy', {height: '150px'});
	</script>
</body>
</html>
