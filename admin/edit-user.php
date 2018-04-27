<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
$editUserId=$_GET["id"]; /* userId of user to be edited - get from url parameter */
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


                <!-- Form validation -->
				<form id="validate" class="form-horizontal" action="" method="post">
	                <fieldset>

	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New User</h6></div></div>
	                    	<div class="well row-fluid">
                            <!-- Select and display user details-->                            
                            <?php 
							$rslt=mysqli_query($con,"select * from tbl_users,tbl_login where userId='$editUserId' and tbl_users.userEmail=tbl_login.loginUsername");
							while($row=mysqli_fetch_array($rslt))
							{
							?>
								<div class="control-group">
	                                <label class="control-label">First Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row['userFirstName'];?>" class="validate[required,custom[onlyLetterSp]] input-large" name="fname" id="fname"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Last Name:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row['userLastName'];?>" class="validate[custom[onlyLetterSp]] input-large" name="lname" id="lname"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Mobile:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row['userMobile'];?>" class="validate[custom[phone]] input-large" name="mobile" id="mobile"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Email: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" readonly value="<?php echo $row['userEmail'];?>" class="validate[required,custom[email]] input-large" name="email" id="email"/>
	                                </div>
	                            </div>

	                            <div class="control-group">
	                                <label class="control-label">Password: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" class="validate[required,minSize[5]] input-large" value="<?php echo $row['loginPassword'];?>" name="password1" id="password1" />
	                                </div>
	                            </div>
	                        
	                            <div class="control-group">
	                                <label class="control-label">Repeat password: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $row['loginPassword'];?>" class="validate[required,equals[password1]] input-large" name="password2" id="password2" />
	                                </div>
	                            </div>
	                        	                            
	                            <div class="control-group">
	                                <label class="control-label">Active: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($row['loginStatus']==1) {?> checked <?php }?>name="active" id="active1" value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($row['loginStatus']==0) {?> checked <?php }?> name="active" id="active2" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>

	                            <div class="control-group">
	                                <label class="control-label">User Type: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($row['loginType']==1) {?> checked <?php }?> name="type" id="type1" value="1" data-prompt-position="topLeft:-1,-5"/>
											Admin
										</label>
										<label class="radio inline">
											<input class="styled" <?php if($row['loginType']==2) {?> checked <?php }?> type="radio" name="type" id="type1" value="2" data-prompt-position="topLeft:-1,-5"/>
											Normal User
										</label>
	                                </div>
	                            </div>
                                <?php } ?>
                            <!-- /Select and display user log-->

	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>

	                        </div>

	                    </div>

	                </fieldset>
				</form>
				<!-- /form validation -->
                
	            <!-- form submition - update user details -->
                <?php
					if(isset($_POST["submit"]))
					{
						$fname=$_POST["fname"];
						$lname=$_POST["lname"];
						$mobile=$_POST["mobile"];
						$email=$_POST["email"];					
						$password=$_POST["password1"];												
						$account=$_POST["active"];
						$type=$_POST["type"];
												
						mysqli_query($con,"update tbl_users set userFirstName='$fname',userLastName='$lname',userMobile='$mobile' where userId='$editUserId'") or die(mysqli_error($con));
						mysqli_query($con,"update tbl_login set loginType='$type',loginStatus='$account',loginPassword='$password' where loginUsername='$email'") or die(mysqli_error($con));
						echo "<script>alert('User details Updated');</script>;";
						echo "<script>location.href = 'manage-user.php'</script>;";												
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
