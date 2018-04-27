<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
if(isset($_POST["submit"]))
{

	$password1	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password1"]));
	$password2	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password2"]));

	$rslt=mysqli_query($con,"select * from tbl_login where loginUsername='$username' and loginPassword1='$password1'");
	if(mysqli_num_rows($rslt)>0)
	{		
		mysqli_query($con,"update tbl_login set loginPassword1='$password2' where loginUsername='$username'") or die(mysqli_error($con));
		$_SESSION["response"]="Password Updated";
		echo "<script>location.href = 'index.php'</script>";
	}
	else
	{
		$_SESSION["response"]="Current Password Not Matching";
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
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});
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
			    <br>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>User Profile</h6></div></div>
	                    	<div class="well row-fluid">                            			                        
	                            <div class="control-group">
	                                <label class="control-label">Current Password: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="" class="validate[required,minSize[6]] input-large" name="password1" id="password1" />
	                                </div>
	                            </div>
	                        
	                            <div class="control-group">
	                                <label class="control-label">New Password: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="" class="validate[required,minSize[6],notEquals[password1]] input-large" name="password2" id="password2" />
	                                </div><br />
	                                <label class="control-label">Confirm password : <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="" class="validate[required,equals[password2]] input-large" name="pass2" id="pass2" />
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

<?php if(isset($_SESSION["response"]))
{
echo "<script>alert('".$_SESSION["response"]."');</script>";
unset($_SESSION["response"]);
}
?>
			</div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
