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

	$userType		= mysqli_real_escape_string($con,$_POST["type"]);
//	$department		= mysqli_real_escape_string($con,$_POST["department"]);
	$department		= "";
	$email 			= mysqli_real_escape_string($con,$_POST["email"]);
	$password1	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password1"]));
	$password2	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password2"]));
						
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_users where userEmail='$email'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["err-email"]="email already registered";
	}
	else
	{
		/* insert user details to user table and login table*/
		mysqli_query($con,"insert into tbl_users (userEmail,userDepartment)values('$email','$department')") or die(mysqli_error($con));
		mysqli_query($con,"insert into tbl_login (loginUsername,loginPassword,loginType)values('$email','$password1','$userType')") or die(mysqli_error($con));
		$_SESSION["response"]="User Registered";
		echo "<script>location.href = 'manage-user.php'</script>";
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
				<h5 class="widget-name"><i class="icon-picture"></i>New User</h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">
                            	<div class="control-group">
	                                <label class="control-label">User Type: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="type" id="type1" value="1" data-prompt-position="topLeft:-1,-5"/>
											Admin
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="type" id="type2" value="2" data-prompt-position="topLeft:-1,-5"/>
											Normal User 
										</label>
	                                </div>
	                            </div>
                                <!--<div class="control-group">
	                                <label class="control-label">Department: <span class="text-error">*</span></label>
	                                <div class="controls">
                                    <?php 
									$rslt = mysqli_query($con,"select departmentName from tbl_department");
									while($row = mysqli_fetch_assoc($rslt))
									{
									?>
										<label class="radio inline">
											<input class="validate[minCheckbox[1]] styled" type="radio" name="department" id="type2" value="<?php echo $row["departmentName"]; ?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["departmentName"]; ?>
										</label>
                                      <?php }?>
	                                </div>
	                            </div>-->
                                <div class="control-group">
	                                <label class="control-label">Email: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required,custom[email]] input-large" name="email" id="email"/>					
										<?php if(isset($_SESSION["err-email"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">email id already registered</span>
										<?php
										unset($_SESSION["err-email"]);
										}
										?>
	                                </div>
	                            </div>
	                        
	                            <div class="control-group">
	                                <label class="control-label">Password : <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" class="validate[required,minSize[6]] input-large" name="password1" id="password1" />
	                                </div><br />
	                                <label class="control-label">Confirm password : <span class="text-error">*</span></label>                                    
	                                <div class="controls">
	                                    <input type="password" class="validate[required,equals[password1]] input-large" name="pass1" id="pass1" />
	                                </div>
	                            </div>
	                        
	                            <div class="control-group hide">
	                                <label class="control-label">Password 2: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" class="validate[minSize[6],notEquals[password1]] input-large" name="password2" id="password2" />
	                                </div><br />
	                                <label class="control-label">Confirm password 2: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" class="validate[equals[password2]] input-large" name="pass2" id="pass2" />
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
