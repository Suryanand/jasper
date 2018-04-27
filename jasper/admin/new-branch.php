<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["submit"]))
{
	$address = mysqli_real_escape_string($con,$_POST["address"]);
	$branchName	=mysqli_real_escape_string($con,$_POST["branchName"]);
	$email	=mysqli_real_escape_string($con,$_POST["email"]);
	$contactNo	=mysqli_real_escape_string($con,$_POST["contactNo"]);
	$fax	=mysqli_real_escape_string($con,$_POST["fax"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$location=mysqli_real_escape_string($con,$_POST["location"]);
	$timing=mysqli_real_escape_string($con,$_POST["timing"]);

	if($_POST["submit"]=="save")
	{ /* inser into table first time*/
	mysqli_query($con,"insert into tbl_branches (location,branchName,address,contactNo,email,fax,googleMap,activeStatus,timing)values('".$location."','$branchName','$address','$contactNo','$email','$fax','$googleMap','$activeStatus','".$timing."')") or die(mysqli_error($con));
	$_SESSION["response"]='Branch Saved';
	}
	
	echo "<script>location.href = 'manage-branch.php'</script>";exit();
}

?>
<!doctype html>
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
			    <br>
			    <!-- /page header -->

				<h5 class="widget-name"><i class="icon-sitemap"></i>New Branch <a href="manage-branches.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
							<div class="tabbable"><!-- default tabs -->
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
	                    	<div class="well row-fluid">
							
								<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
							<div class="span6 well">
									<div class="control-group">
										 <label class="control-label">Location: <span class="text-error">*</span> </label>
										 <div class="controls">
											<select name="location" class="validate[required] styled">
											<?php $rslt=mysqli_query($con,"select * from tbl_locations");
											while($row=mysqli_fetch_assoc($rslt))
											{												
											?>
												<option value="<?php echo $row["id"];?>"><?php echo $row["region"];?></option>
											<?php 
											}?>
											</select>
										 </div>
									</div>
									<div class="control-group">
										 <label class="control-label">Branch Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[required] input-xlarge"  name="branchName" id="branchName"/>
										 </div>
									</div>									
									<div class="control-group">
										<label class="control-label">Address: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea rows="5" cols="5" name="address" class="validate[required] input-xlarge"></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[required] input-xlarge"  name="contactNo" id="contactNo"/>
										 </div>
									 </div>
									 
									 <div class="control-group">
										 <label class="control-label">Fax: </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[] input-xlarge"  name="fax" id="fax"/>
										 </div>
									 </div>
								</div>
	                        <div class="span6 well">
									
									 <div class="control-group">
										 <label class="control-label">Company Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[required,custom[email]] input-xlarge"  name="email" id="email"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Opening Hours: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="" class="validate[required] input-xlarge"  name="timing" id="timing"/>
										 </div>
									 </div>
									 <div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" cols="5" name="googleMap" class="validate[] span12"></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
										<div class="controls">

											<label class="radio inline">
												<input class="styled" type="radio" name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
												Draft
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
												Publish
											</label>
										</div>
									</div>
									<div class="form-actions align-right">
										<button type="submit" class="btn btn-info" name="submit" value="save">Save</button>
									</div>
								</div>
									</form>
	                        
							</div>
							
							</div>
							
							</div>
							</div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				<!-- /form validation -->
                
                <!-- form submition -->  
                    <?php if(isset($_SESSION["response"]))
                     {
                     	echo "<script>alert('".$_SESSION["response"]."');</script>";
                        unset($_SESSION["response"]);
                      }
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
