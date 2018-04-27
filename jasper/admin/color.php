<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// new user submit

if(isset($_POST["update"]))
{
	$activeStatus		= 0;
		$activeStatus	= 1;
		$id			= $_POST["update"];
		mysqli_query($con,"update tbl_settings set activeStatus=0");
		mysqli_query($con,"update tbl_settings set activeStatus='".$activeStatus."' where id='".$id."'") or die(mysqli_error($con));
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
				    	<a href="index.php"><h5>Settings</h5></a>
				    	
			    	</div>
			    </div>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Theme Color</h6></div></div>
	                    	<div class="well row-fluid" id="storecolor">                                
                                <div class="control-group">
	                                <label class="control-label">color: <span class="text-error">*</span></label>
	                                
                                    <?php $rslt=mysqli_query($con,"select * from tbl_settings where color is not null and color<>'' order by color asc");
								while($row=mysqli_fetch_assoc($rslt))
								{
								 ?>
	                                <div class="controls">
	                                    <label class="control-label" style="background:<?php echo $row["colorCode"]; ?>;color:#FFF; text-align:center;text-transform:capitalize"><?php echo $row["color"]; ?></label>
                                        <input type="radio" <?php if($row["activeStatus"]==1) echo "checked"; ?> value="<?php echo $row["color"]; ?>" class="validate[] input-mini" name="active" id="color<?php echo $row["id"]; ?>"/>
										<button type="submit" value="<?php echo $row["id"]; ?>" class="btn btn-info" name="update">Set</button>
	                                </div>
                                <?php }?>
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
