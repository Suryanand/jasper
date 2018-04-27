<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Order Status"] == 0) 
{
	header('location: index.php');
}

// new user submit
if(isset($_POST["submit"]))
{
	$status=$_POST["status"];
	$order=$_POST["order"];
	$rslt=mysqli_query($con,"select * from tbl_tracking_status where trackingStatus='".$status."'");
	if(mysqli_num_rows($rslt))
	{
		$_SESSION["err"]="1";
	}
	else
	{
		mysqli_query($con,"insert into tbl_tracking_status (trackingStatus,displayOrder) values('".$status."','".$order."')") or die(mysqli_error($con));
	}
}

if(isset($_POST["update"]))
{
	$id			= $_POST["update"];
	$status	= $_POST["status".$id];	
	$order	= $_POST["order".$id];	
	$rslt		= mysqli_query($con,"select * from tbl_tracking_status where trackingStatus='".$status."' and id!='".$id."'");
	if(mysqli_num_rows($rslt))
	{
		$_SESSION["err"]="1";
	}
	else
	{
		mysqli_query($con,"update tbl_tracking_status set trackingStatus='".$status."',displayOrder='".$order."' where id='".$id."'") or die(mysqli_error($con));
	}
}
if(isset($_POST["delete"]))
{
	$id			= $_POST["delete"];
	mysqli_query($con,"delete from tbl_tracking_status where id='".$id."'");
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
	                        <div class="navbar"><div class="navbar-inner"><h6>Order Tracking Status</h6></div></div>
	                    	<div class="well row-fluid" id="storestatus">                                
                                <div class="control-group">
	                                <label class="control-label">Status / Display Order: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-large" name="status" id="status"/>
                                        <input type="text" value="" class="validate[] input-mini" name="order" id="order"/>
										<button type="submit" class="btn btn-info" name="submit">Add</button>
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">status already added</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
	                                </div>
                                    <?php $rslt=mysqli_query($con,"select * from tbl_tracking_status order by displayOrder asc");
								while($row=mysqli_fetch_assoc($rslt))
								{
								 ?>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row["trackingStatus"]; ?>" class="validate[required] input-large" name="status<?php echo $row["id"]; ?>" id="status<?php echo $row["id"]; ?>"/>                                        
                                        <input type="text" value="<?php echo $row["displayOrder"]; ?>" class="validate[] input-mini" name="order<?php echo $row["id"]; ?>" id="order<?php echo $row["id"]; ?>"/>
										<button type="submit" value="<?php echo $row["id"]; ?>" class="btn btn-info" name="update">Update</button>
										<button type="submit" value="<?php echo $row["id"]; ?>" class="btn btn-danger" name="delete">Remove</button>
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
