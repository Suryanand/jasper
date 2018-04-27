<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
$loginId=$_GET["id"];

//get User details
$rslt=mysqli_query($con,"select * from tbl_login,tbl_users where loginId='$loginId' and userEmail=loginUsername");
$row=mysqli_fetch_assoc($rslt);
$department=$row["userDepartment"];
$userId=$row["userId"];
$email=$row["userEmail"];
$type=$row["loginType"];
$password1=decryptIt($row["loginPassword"]);
//$password2=decryptIt($row["loginPassword2"]);
$fname=$row["userFirstName"];
$lname=$row["userLastName"];
$avatar=$row["userAvatar"];
$active=$row["loginActive"];
if(isset($_POST["submit"]))
{
	$fname 			= mysqli_real_escape_string($con,$_POST["fname"]);
	$lname 			= mysqli_real_escape_string($con,$_POST["lname"]);
	$userType		= mysqli_real_escape_string($con,$_POST["type"]);
//	$department		= mysqli_real_escape_string($con,$_POST["department"]);
	$department		= "";
	$email 			= mysqli_real_escape_string($con,$_POST["email"]);
	$password1	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password1"]));
	$password2	 	= encryptIt(mysqli_real_escape_string($con,$_POST["password2"]));
	$active			= mysqli_real_escape_string($con,$_POST["active"]);
	//Upload Avatar
	if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) 
	{     
		$path_to_image_directory = 'user/';
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['avatar']['name'])) 
		{ 
			$path = $_FILES['avatar']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$source = $_FILES['avatar']['tmp_name'];
			if(empty($avatar))
			{  
			$avatar = "avatar-"; //Image name
			// Make sure the fileName is unique
			$count = 1;
			while (file_exists($path_to_image_directory.$avatar.$count.".".$ext))
			{
				$count++;	
			}
			$avatar = $avatar . $count.".".$ext;
			}
			$target = $path_to_image_directory . $avatar;
			if(!file_exists($path_to_image_directory)) 
			{
				if(!mkdir($path_to_image_directory)) 
				{
					die("There was a problem. Please try again!");
				}
			}        
			move_uploaded_file($source, $target);
		}
	}	
	
		
		mysqli_query($con,"update tbl_users set userFirstName='$fname',userLastName='$lname',userDepartment='$department',userAvatar='$avatar' where userEmail='$email'") or die(mysqli_error($con));
		mysqli_query($con,"update tbl_login set loginPassword='$password1',loginType='$userType',loginActive='$active' where loginId='$loginId'") or die(mysqli_error($con));
		$_SESSION["response"]="User Profile Updated";
		echo "<script>location.href = 'manage-user.php'</script>";
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
				<h5 class="widget-name"><i class="icon-picture"></i>User Profile</h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">
                            		<div class="control-group <?php if($CurrentUserId==$userId) echo "hide";?>">
	                                <label class="control-label">User Type: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($type==1) echo "checked";?> name="type"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Admin
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($type==2) echo "checked";?> name="type" value="2" data-prompt-position="topLeft:-1,-5"/>
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
											<input class="validate[minCheckbox[1]] styled" type="radio" <?php if($department==$row["departmentName"]) echo "checked";?> name="department" value="<?php echo $row["departmentName"]; ?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["departmentName"]; ?>
										</label>
                                      <?php }?>
	                                </div>
	                            </div>-->
                                <div class="control-group <?php if($CurrentUserId==$loginId) echo "hide";?>">
	                                <label class="control-label">Active: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($active==1) echo "checked";?> name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($active==0) echo "checked";?> name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">First Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $fname;?>" class="validate[required,custom[onlyLetterSp]] input-large" name="fname" id="fname"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Last Name:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $lname;?>" class="validate[custom[onlyLetterSp]] input-large" name="lname" id="lname"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Email: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $email;?>" readonly class="validate[required,custom[email]] input-large" name="email" id="email"/>					
	                                </div>
	                            </div>	                        
	                            <div class="control-group">
	                                <label class="control-label">Password: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $password1?>" class="validate[required,minSize[6]] input-large" name="password1" id="password1" />
	                                </div><br />
	                                <label class="control-label">Confirm password: <span class="text-error">*</span></label>                                    
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $password1?>" class="validate[required,equals[password1]] input-large" name="pass1" id="pass1" />
	                                </div>
	                            </div>
	                        
	                            <div class="control-group hide">
	                                <label class="control-label">Password 2: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $password2?>" class="validate[minSize[6],notEquals[password1]] input-large" name="password2" id="password2" />
	                                </div><br />
	                                <label class="control-label">Confirm password 2: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="password" value="<?php echo $password2?>" class="validate[equals[password2]] input-large" name="pass2" id="pass2" />
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Avatar:<br> w:400px &nbsp;&nbsp; h:440px</label>
	                                <div class="controls">
                                    <?php if(!empty($avatar))
									{?>
                                    	<img src="user/<?php echo $avatar; ?>" width="75" height="100" />
                                    <?php } 
									else
									{
									?>
                                    	<img src="user/default-profile.png" width="75" height="100" />                                    
                                    <?php }?>
										<input type="file" name="avatar" id="avatar" class="validate[custom[images]]">									
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
