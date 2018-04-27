<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
//get product image size
$rslt			= mysqli_query($con,"select * from tbl_payment_mode");
while($row = mysqli_fetch_assoc($rslt))
{
	if($row["gateway"] == "PayPal")
	{
		$paypalAccountIdLive	= $row["accountIdLive"];
		$notificationMail		= $row["notificationMail"];		
		$paypalActiveAccount	= $row["activeAccount"];
		$paypalActiveStatus		= $row["activeStatus"];
		$paypalSecretWord		= $row["secretWord"];
		$api_username			= $row["api_username"];
		$api_password			= $row["api_password"];
		$api_signature			= $row["api_signature"];
	}
	else if($row["gateway"] == "Credit Card")
	{
		$storeId				= $row["accountIdLive"];
		$authenticationKey		= $row["secretWord"];		
		$telrActiveAccount	= $row["activeAccount"];
		$telrActiveStatus	= $row["activeStatus"];
	}	
	else if($row["gateway"] == "Bank Transfer")
	{
		$wtAccountDetails	= $row["accountDetails"];
		$wtActiveStatus	= $row["activeStatus"];
	}

	//echo($row["gateway"]);
}
// new user submit
if(isset($_POST["submit"]))
{
	if($_POST["submit"] == "paypal")
	{
		$paypalAccountIdLive	= mysqli_real_escape_string($con,$_POST["accountIdLive"]);
		$notificationMail		= mysqli_real_escape_string($con,$_POST["notificationMail"]);
		$paypalSecretWord		= mysqli_real_escape_string($con,$_POST["paypalSecretWord"]);
		$api_username			= mysqli_real_escape_string($con,$_POST["api_username"]);
		$api_password			= mysqli_real_escape_string($con,$_POST["api_password"]);
		$api_signature			= mysqli_real_escape_string($con,$_POST["api_signature"]);
		$paypalActiveAccount	= $_POST["activeAccount"];
		$paypalActiveStatus		= $_POST["activeStatus"];
		mysqli_query($con,"update tbl_payment_mode set accountIdLive='".$paypalAccountIdLive."',notificationMail='".$notificationMail."',activeAccount='".$paypalActiveAccount."',activeStatus='".$paypalActiveStatus."',secretWord='".$paypalSecretWord."',api_signature='".$api_signature."',api_password='".$api_password."',api_username='".$api_username."' where gateway='PayPal'");
	}
	else if($_POST["submit"] == "Telr")
	{
		$checkoutAccountIdLive	= mysqli_real_escape_string($con,$_POST["accountIdLive"]);
		$secretWord				= mysqli_real_escape_string($con,$_POST["secretWord"]);
		$checkoutActiveAccount	= $_POST["activeAccount"];
		$checkoutActiveStatus	= $_POST["activeStatus"];
		mysqli_query($con,"update tbl_payment_mode set accountIdLive='".$checkoutAccountIdLive."',secretWord='".$secretWord."',activeAccount='".$checkoutActiveAccount."',activeStatus='".$checkoutActiveStatus."' where gateway='Credit Card'");
	}	
	else if($_POST["submit"] == "bank transfer")
	{
		$wtAccountDetails	= mysqli_real_escape_string($con,$_POST["wtAccountDetails"]);
		$wtActiveStatus	= $_POST["wtActiveStatus"];		
		mysqli_query($con,"update tbl_payment_mode set activeStatus='".$wtActiveStatus."',accountDetails='".$wtAccountDetails."' where gateway='Bank Transfer'");
	}
	echo "<script>location.href = 'gateway-settings.php'</script>";exit();
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
			 <br>
			    <!-- /page header -->

     <h5 class="widget-name"><i class="icon-envelope-alt"></i>Gateway setting</h5>

	                    <!-- Form validation -->
	                    <div class="widget">
	                  <!--      <div class="navbar"><div class="navbar-inner"><h6>Gateway Settings</h6></div></div>-->
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li class="active"><a href="#tab1" data-toggle="tab">PayPal</a></li>
	                                <li class=""><a href="#tab2" data-toggle="tab">Telr</a></li>
	                                <li class=""><a href="#tab3" data-toggle="tab">Bank Transfer</a></li>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane active" id="tab1">
                           <div class="well row-fluid">                            	                                
                        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                            <fieldset>
                                <div class="control-group">
	                                <label class="control-label">Live Account Id: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $paypalAccountIdLive;?>" class="validate[custom[email]] input-xlarge" name="accountIdLive" id="accountIdLive"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Notification Mail:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $notificationMail;?>" class="validate[custom[email]] input-xlarge" name="notificationMail" id="notificationMail"/>					
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Secure Merchant Account ID:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $paypalSecretWord;?>" class="validate[] input-xlarge" name="paypalSecretWord" id="paypalSecretWord"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">API Username:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $api_username;?>" class="validate[] input-xlarge" name="api_username" id="api_username"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">API Password:</label>
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $api_password;?>" class="validate[] input-xlarge" name="api_password" id="api_password"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">API Signature:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $api_signature;?>" class="validate[] input-xlarge" name="api_signature" id="api_signature"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Status:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($paypalActiveAccount == "live") echo "checked";?> name="activeAccount"  value="live" data-prompt-position="topLeft:-1,-5"/>
											Live
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="activeAccount" <?php if($paypalActiveAccount == "sandbox") echo "checked";?> value="sandbox" data-prompt-position="topLeft:-1,-5"/>
											Sandbox (Test Account)
										</label>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Payment Method:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($paypalActiveStatus == 1) echo "checked";?> name="activeStatus"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Enable
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="activeStatus" <?php if($paypalActiveStatus == 0) echo "checked";?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Disable
										</label>
	                                </div>
	                            </div>
                                <div class="form-actions align-right">
                                        <button type="submit" class="btn btn-info updt-btn" value="paypal" name="submit">Save</button>
                                        <button type="reset" class="btn btn-danger updt-btn bbq" value="" name="">Clear</button>
                                </div>
	                        </fieldset>
                        </form>
	                        </div>
                            
                            </div>
                            <!--Tab 2-->
                            <div class="tab-pane" id="tab2">
                           <div class="well row-fluid">                            	                                
                        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                            <fieldset>
                                <div class="control-group">
	                                <label class="control-label">Store Id: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $storeId;?>" class="validate[custom[email]] input-xlarge" name="accountIdLive" id="accountIdLive"/>
	                                </div>
	                            </div>
                                
								<div class="control-group">
	                                <label class="control-label">Authentication Key:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $authenticationKey;?>" class="validate[] input-xlarge" name="secretWord" id="secretWord"/>
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">Status:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($telrActiveAccount == "live") echo "checked";?> name="activeAccount"  value="live" data-prompt-position="topLeft:-1,-5"/>
											Live
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="activeAccount" <?php if($telrActiveAccount == "sandbox") echo "checked";?> value="sandbox" data-prompt-position="topLeft:-1,-5"/>
											Sandbox (Test Account)
										</label>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Payment Method:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($telrActiveStatus == 1) echo "checked";?> name="activeStatus"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Enable
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="activeStatus" <?php if($telrActiveStatus == 0) echo "checked";?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Disable
										</label>
	                                </div>
	                            </div>
                                <div class="form-actions align-right">
                                        <button type="submit" class="btn btn-info updt-btn" value="Telr" name="submit">Save</button>
                                        <button type="reset" class="btn btn-danger updt-btn bbq" value="" name="">Clear</button>
                                </div>
	                        </fieldset>
                        </form>
	                        </div>
                            
                            </div>
                            
                            <!--Tab 3-->                            
                            
                            <div class="tab-pane" id="tab3">
                           <div class="well row-fluid">                            	                                
                        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                            <fieldset>
                                <div class="control-group">
	                                <label class="control-label">Account Details: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea name="wtAccountDetails"><?php echo $wtAccountDetails;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Payment Method:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($wtActiveStatus == 1) echo "checked";?> name="wtActiveStatus"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Enable
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="wtActiveStatus" <?php if($wtActiveStatus == 0) echo "checked";?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Disable
										</label>
	                                </div>
	                            </div>
                                <div class="form-actions align-right">
                                        <button type="submit" class="btn btn-info updt-btn" value="bank transfer" name="submit">Save</button>
                                        <button type="reset" class="btn btn-danger updt-btn bbq" value="" name="">Clear</button>
                                </div>
	                        </fieldset>
                        </form>
	                        </div>
                            
                            </div>
							
							<!-- tab 4-->
							
                            </div>
                            </div>

	                    </div>
	                    <!-- /form validation -->

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
	CKEDITOR.replace('wtAccountDetails');
	</script>
</body>
</html>
