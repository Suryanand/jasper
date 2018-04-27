<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}



//get image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Admin Logo'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];

$rslt=mysqli_query($con,"select * from admin_title");
$row=mysqli_fetch_assoc($rslt);
$adminTitle=$row["title"];
$adminLogo=$row["adminLogo"];


// new user submit
if(isset($_POST["submit"]))
{
	$absolutePath=$_POST["absolutePath"];	
	$adminTitle=$_POST["adminTitle"];	

	$path_to_image_directory="img/";
	if(isset($_FILES['adminLogo']) && !empty($_FILES['adminLogo']['name'])) 
	{     
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['adminLogo']['name'])) 
		{ 
			$adminLogo = "adminLogo";
			$path = $_FILES['adminLogo']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$adminLogo = $adminLogo.".".$ext;	
			$source = $_FILES['adminLogo']['tmp_name'];  
			$target = $path_to_image_directory . $adminLogo;
			if(!file_exists($path_to_image_directory)) 
			{
				if(!mkdir($path_to_image_directory, 0777, true)) 
				{
					die("There was a problem. Please try again!");
				}
			}        
			move_uploaded_file($source, $target);
		}
	}
	
	
	
		mysqli_query($con,"update tbl_settings set absolutePath='".$absolutePath."'");

	mysqli_query($con,"update admin_title set title='".$adminTitle."',adminLogo='".$adminLogo."'");
	echo "<script>location.href = 'absolute-path.php';</script>";exit();
}

//delete logand favicon
if(isset($_POST["deleteLogo"]))
{
	unlink("img/".$adminLogo);
	mysqli_query($con,"update admin_title set adminLogo=''") or die(mysql_error());
	echo "<script>location.href = 'absolute-path.php';</script>";
}
if(isset($_POST["deleteBanner"]))
{
	unlink("../images/".$topBanner);
	mysqli_query($con,"update tbl_settings set defaultTopBanner=''") or die(mysql_error());
	echo "<script>location.href = 'absolute-path.php'</script>;";																		
}
if(isset($_POST["deleteAudio"]))
{
	unlink("../audio/".$websiteAudio);
	mysqli_query($con,"update tbl_settings set websiteAudio=''") or die(mysql_error());
	echo "<script>location.href = 'absolute-path.php'</script>;";																		
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

			    <!-- Page header --><br><!-- /Page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>General Settings</h6></div></div>
	                    	<div class="well row-fluid" id="storeCurrency">                                
                                <div class="control-group">
	                                <label class="control-label">Absolute Path: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $absolutePath;?>" class="validate[required] input-large" name="absolutePath" id="absolutePath"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Admin Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $adminTitle;?>" class="validate[required] input-large" name="adminTitle" id="adminTitle"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Admin Logo:<br>w: <?php echo $imageWidth;?>px h: <?php echo $imageHeight;?>px</label>
	                                <div class="controls">
	                                    <?php if(!empty($adminLogo)) {?><img src="img/<?php echo $adminLogo; ?>" width="100" height="75" /> 
										<button type="submit" name="deleteLogo" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" name="adminLogo" id="adminLogo" class="validate[custom[images]]">									
	                                </div>									
	                            </div>
																
								<div class="control-group">
	                                <div class="controls">
										<button type="submit" class="btn btn-info" name="submit">Save</button>
									</div>
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
