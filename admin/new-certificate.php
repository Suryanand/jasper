<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Getting logged in user details*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

//get product image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Home Page Banner'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= 1050;
$imageWidth		= 750;

// form submit
if(isset($_POST["submit"]))
{
	$title	= $_POST["title"];
	$flag		= 0;
	/* Image Upload Start */
	$path_to_image_directory = '../images/certificate/';
	if(isset($_FILES['certificate']) && !empty($_FILES['certificate']['name'])) 
	{     
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['certificate']['name'])) 
		{     
			$image_info = getimagesize($_FILES["certificate"]["tmp_name"]);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			if(1)
			{
				$flag		= 1;
				$filename 	= "certificate-";
				$path 		= $_FILES['certificate']['name'];
				$ext 		= pathinfo($path, PATHINFO_EXTENSION);
				$source 	= $_FILES['certificate']['tmp_name'];
				// Make sure the fileName is unique
				$count 		= 1;
				while (file_exists($path_to_image_directory.$filename.$count.".".$ext))
				{
					$count++;	
				}
				$filename = $filename . $count.".".$ext;
				$target = $path_to_image_directory . $filename;
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
	}

	/* insert into table*/
	mysqli_query($con,"insert into tbl_certificates (certificate,title)values('".$filename."','".$title."')") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-certificate.php'</script>;";																		
	
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Qualification</h6></div></div>
	                    	<div class="well row-fluid">								
                                <div class="control-group">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br><?php echo "w:".$imageWidth."px &nbsp;&nbsp; h:".$imageHeight."px"; ?></label>
	                                <div class="controls">
	                                    <input type="file" name="certificate" id="certificate" class="validate[required,custom[images]]">
                                        <span style="color:red;"><?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);}?></span>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xlarge" name="title" id="title"/>
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
                
                <!-- form submission -->
   
                <!-- /form submission -->             
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
