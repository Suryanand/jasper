<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}


$imageHeight	= 240;
$imageWidth		= 170;
// new user submit
if(isset($_POST["submit"]))
{
	$client 	= mysqli_real_escape_string($con,$_POST["client"]);
	$url	= mysqli_real_escape_string($con,$_POST["url"]);
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_clients where client='$client'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="client already created";
	}
	else
	{	
	
	if(isset($_FILES['clientImage']) && !empty($_FILES['clientImage']['name'])) 
	{     
		$path_to_image_directory = '../uploads/images/brands/';
		if(preg_match('/[.](jpg)|(gif)|(png)|(JPG)|(GIF)|(PNG)$/', $_FILES['clientImage']['name'])) 
		{ 
			$image_info = getimagesize($_FILES["clientImage"]["tmp_name"]);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			if(1)
			{
				$path = $_FILES['clientImage']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);		
				$source = $_FILES['clientImage']['tmp_name'];
				$clientImage = "client-"; //Image name
				// Make sure the fileName is unique
				$count = 1;
				while (file_exists($path_to_image_directory.$clientImage.$count.".".$ext))
				{
					$count++;	
				}
				$clientImage = $clientImage . $count.".".$ext;
				$target = $path_to_image_directory . $clientImage;
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
	else
	{
		$clientImage="";
	}	
		mysqli_query($con,"insert into tbl_clients (client,url,clientImage,altTag,activeStatus,createdOn)values('".$client."','".$url."','".$clientImage."','".$altTag."','".$activeStatus."',NOW())") or die(mysqli_error($con));	
		echo "<script>location.href = 'manage-client.php'</script>";
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
				<h5 class="widget-name"><i class="icon-user-md"></i>New Client <a href="manage-client.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Client Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="client" id="client"/>					
										<?php if(isset($_SESSION["response"])) /* if category already registered */
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
	                                <label class="control-label">URL:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[custom[url]] input-xlarge" name="url" id="url"/>					
	                                </div>
	                            </div>                                
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br><?php echo "w:".$imageWidth."px &nbsp;&nbsp; h:".$imageHeight."px"; ?></label>
	                                <div class="controls">
										<input type="file" name="clientImage" id="clientImage" class="validate[custom[images]]">
										<br><br><label>Alt Tag : <input type="text" value="" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" checked name="activeStatus" id="activeStatus" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="activeStatus" id="activeStatus" value="1" data-prompt-position="topLeft:-1,-5"/>
											Publish
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
