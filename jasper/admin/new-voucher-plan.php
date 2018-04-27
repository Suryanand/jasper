<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// new user submit
if(isset($_POST["submit"]))
{
	$voucherPlan 	= mysqli_real_escape_string($con,$_POST["voucherPlan"]);
	$amount			= mysqli_real_escape_string($con,$_POST["amount"]);
	$activationPeriod	= mysqli_real_escape_string($con,$_POST["activationPeriod"]);
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	// Check whether the Voucher Code already registered 
	$rslt=mysqli_query($con,"select * from tbl_vouchers where voucherPlan='".$voucherPlan."'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="Voucher code already Generated";
	}
	else
	{		
		mysqli_query($con,"insert into tbl_vouchers (voucherPlan,voucherAmount,activationPeriod,activeStatus,createdOn,createdBy) values('".$voucherPlan."','".$amount."','".$activationPeriod."','".$activeStatus."',NOW(),'".$CurrentUserId."')") or die(mysqli_error($con));
				
		$_SESSION["response"]="Voucher Created";
		echo "<script>location.href = 'manage-voucher-plan.php'</script>";
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
	                        <div class="navbar"><div class="navbar-inner"><h6>New Voucher</h6></div></div>
	                    	<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Voucher Plan: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-large" name="voucherPlan" id="voucherPlan"/>					
										<?php if(isset($_SESSION["response"])) /* if coupon already registered */
										{
										?>
											<span class="help-block" style="color:#F00;"><?php echo $_SESSION["response"]; ?></span>
										<?php
										unset($_SESSION["response"]);
										}
										?>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Amount: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value=""  class="validate[required,custom[number]] input-large" name="amount" id="amount"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Activation Period (in days): <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value=""  class="validate[required,custom[number]] input-large" name="activationPeriod" id="activationPeriod"/>
	                                </div>
	                            </div>                                                                
                                <div class="control-group">
	                                <label class="control-label">Status: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
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
