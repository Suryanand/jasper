<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}


$col = mysqli_query($con,"SELECT footerText FROM tbl_company_profile");
if (!$col){
    
    mysqli_query($con,"ALTER TABLE tbl_company_profile ADD footerText TEXT NULL");
}

// get header details starts
$seoSet=0; 
$rslt=mysqli_query($con,"select * from tbl_company_profile") or die(mysqli_error($con));
if(mysqli_num_rows($rslt)>0)
{
	$flag=1; // header details is set
	while($row=mysqli_fetch_array($rslt))
	{
		$logo=$row['logo'];
		$logoAlt=$row['logoAlt'];
		$favicon=$row['favicon'];
		$faviconAlt=$row["faviconAlt"];
		$footerText=$row["footerText"];
	}
}
else
{
	$flag=0; // header details not saved
}
// get header details end

//get image size start
$rslt			= mysqli_query($con,"SELECT * FROM image_size WHERE imageName='favicon' OR imageName='logo'");
while($row = mysqli_fetch_assoc($rslt))
{
	if($row["imageName"]=="favicon")
	{
		$faviconHeight	= $row["height"];
		$faviconWidth	= $row["width"];
	}
	else{
		$logoHeight	= $row["height"];
		$logoWidth	= $row["width"];
		$mandatory	= $row["mandatory"];
	}
}

//get image size ends


// save header details
if(isset($_POST["submit"]))
{
	$logoAlt=mysqli_real_escape_string($con,$_POST["logoAlt"]);
	$faviconAlt=mysqli_real_escape_string($con,$_POST["faviconAlt"]);
	$footerText=mysqli_real_escape_string($con,$_POST["footerText"]);
	
	$path_to_image_directory="../images/";
	if(isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) 
	{     
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['logo']['name'])) 
		{ 
			$image_info = getimagesize($_FILES["logo"]["tmp_name"]);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			if(1)
			{
				$logo = "logo";
				$path = $_FILES['logo']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);		
				$logo = $logo.".".$ext;	
				$source = $_FILES['logo']['tmp_name'];  
				$target = $path_to_image_directory . $logo;
				if(!file_exists($path_to_image_directory)) 
				{
					if(!mkdir($path_to_image_directory, 0777, true)) 
					{
						die("There was a problem. Please try again!");
					}
				}        
				move_uploaded_file($source, $target);
			}
			else
			{
				echo "<script>alert('Dimension not matching. Image will not be uploaded');</script>";
			}
		}
	}
	
	if(isset($_FILES['favicon']) && !empty($_FILES['favicon']['name'])) 
	{     
		if(preg_match('/[.](ico)|(png)$/', $_FILES['favicon']['name'])) 
		{ 
			$favicon = "favicon";
			$path = $_FILES['favicon']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$favicon = $favicon.".".$ext;	
			$source = $_FILES['favicon']['tmp_name'];  
			$target = $path_to_image_directory . $favicon;
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
	
	if($flag==0)
	{ // new about details
		mysqli_query($con,"insert into tbl_company_profile (logo,logoAlt,favicon,faviconAlt)values('$logo','$logoAlt','$favicon','$faviconAlt')") or die(mysqli_error($con));
		$_SESSION["response"]="Header Details Saved";
	}
	else
	{ // update about details
		mysqli_query($con,"update tbl_company_profile set logo='$logo',logoAlt='$logoAlt',favicon='$favicon',faviconAlt='$faviconAlt',footerText='$footerText'");	
		$_SESSION["response"]="Header Details Updated";
	}
	echo "<script>location.href = 'manage-header.php'</script>";exit();
}

//delete logo and favicon
if(isset($_POST["deleteLogo"]))
{
	unlink("../images/".$logo);
	mysqli_query($con,"update tbl_company_profile set logo=''") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-header.php#settings'</script>;";																		
}
if(isset($_POST["deleteFavicon"]))
{
	unlink("../images/".$favicon);
	mysqli_query($con,"update tbl_company_profile set favicon=''") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-header.php#settings'</script>;";																		
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
			 <!--   <div class="page-header">
			    	<div class="page-title">
				    	<h5>Dashboard</h5>
				    	
			    	</div>
			    </div>-->
			    <!-- /page header -->
	<h5 class="widget-name"><i class="icon-credit-card"></i>Header</h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                      <!--  <div class="navbar"><div class="navbar-inner"><h6>Header</h6></div></div>-->
	                    	<div class="well row-fluid">                                
								<div class="control-group">
	                                <label class="control-label">Upload Logo:<br>w: <?php echo "120";?>px h: <?php echo "100";?>px</label>
	                                <div class="controls">
	                                    <?php if($flag==1 && !empty($logo)) {?><img src="../images/<?php echo $logo; ?>" width="100" height="75" /> 
										<button type="submit" name="deleteLogo" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" name="logo" id="logo" class="validate[custom[images]]">									
	                                </div>
									<br clear="all"/>
	                                <label class="control-label">Alt Tag</label>
									<div class="controls">
										<input type="text" value="<?php if($flag==1) {echo $logoAlt;}?>" class="validate[] input-xlarge" name="logoAlt" id="logoAlt"/>
									</div>
	                            </div>
                                <div class="control-group hide">
	                                <label class="control-label">Upload Favicon:<br>w: <?php echo $faviconWidth;?>px h: <?php echo $faviconHeight;?>px</label>
	                                <div class="controls">
	                                    <?php if($flag==1 && !empty($favicon)) {?><img src="../images/<?php echo $favicon; ?>" width="16" height="16" /> 
										<button type="submit" name="deleteFavicon" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" name="favicon" id="favicon" class="validate[]">									
	                                </div>
									<br clear="all"/>
									<div class="controls hide">
										<label>Alt Tag : <input type="text" value="<?php if($flag==1) {echo $faviconAlt;}?>" class="validate[] input-xlarge" name="faviconAlt" id="faviconAlt"/></label>
									</div>
	                            </div>								
								<div class="control-group">
	                                <label class="control-label">About Text Footer: </label>
	                                <div class="controls">
	                                    <textarea rows="" cols="5" name="footerText" class="validate[] span12"><?php echo $footerText;?></textarea>
	                                </div>
	                            </div>
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info updt-btn" name="submit">Submit</button>
	                                <button type="reset" class="btn updt-btn bbq" style="color: #fff;">Reset</button>
	                            </div>

	                        </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->
                
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
	<?php 
    // echo response 
    if(isset($_SESSION["response"]))
    {
        echo "<script>alert('".$_SESSION["response"]."');</script>";
        unset($_SESSION["response"]);
    }
    ?>
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script>
	CKEDITOR.replace('footerText');
</script>
</body>
</html>
