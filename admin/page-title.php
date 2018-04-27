<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');

// new user submit
if(isset($_POST["submit"]))
{
	$pageTitle		= mysqli_real_escape_string($con,$_POST["pageTitle"]);							
	$rslt=mysqli_query($con,"select * from admin_title");
	if(!empty($title)) 
	{
		//update page title
		mysqli_query($con,"update admin_title set title='$pageTitle'") or die(mysqli_error($con));
	}
	else
	{
		//insert page title
		mysqli_query($con,"insert into admin_title (title)values('$pageTitle')") or die(mysqli_error($con));
	}
		echo "<script>location.href = 'index.php'</script>";
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
	                        <div class="navbar"><div class="navbar-inner"><h6>New User</h6></div></div>
	                    	<div class="well row-fluid">
                                <div class="control-group">
	                                <label class="control-label">Page Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $title; ?>" class="validate[required] input-large" name="pageTitle" id="pageTitle"/>					
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

</body>
</html>
