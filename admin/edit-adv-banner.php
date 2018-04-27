<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include("functions.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

//get banner details
$id = $_GET["id"];
$rslt = mysqli_query($con,"select * from tbl_adv_banner where id='".$id."'");
$row  = mysqli_fetch_assoc($rslt);
$advBanner		= $row["imageName"];
$displayFrom	= $row["displayFrom"];
$displayTill	= $row["displayTill"];
$activeStatus	= $row["activeStatus"];
$title			= $row["title"];
$type			= $row["type"];
$link			= $row["link"];

//get product image size
$pageName="Home Advertisement ";
if($type=="Sidebar")
	$pageName="Sidebar Advertisement ";
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='$pageName'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];


// new user submit
if(isset($_POST["submit"]))
{
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	$title			= mysqli_real_escape_string($con,$_POST["title"]);
	$link			= mysqli_real_escape_string($con,$_POST["link"]);
	// Check whether the email already registered 
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads");
	if($image["advBanner"]){
		$upload = $image->upload(); 
		if($upload){
			$advBanner=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
		mysqli_query($con,"update tbl_adv_banner set imageName='".$advBanner."',title='".$title."',link='".$link."',activeStatus='".$activeStatus."',updatedOn=NOW(),updatedBy='".$CurrentUserId."' where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'new-adv-banner.php'</script>";	
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

			    <br clear="all"/>


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New Advertisement Banner</h6></div></div>
						<div class="well row-fluid">                            	                                
                                
                                <div class="control-group">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br> w:<?php echo $imageWidth;?>px &nbsp;&nbsp; h:<?php echo $imageHeight;?>px</label>
	                                <div class="controls">
	                                    <img src="../uploads/<?php echo $advBanner;?>" width="70" />
										<input type="file" name="advBanner" id="advBanner" class="validate[custom[images]]">									
	                                </div>
	                            </div>
                                <!--<div class="control-group">
		                            <label class="control-label">Display From: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $displayFrom;?>" name="displayFrom" id="displayFrom"/>
		                            </div>
		                        </div>
                                <div class="control-group">
		                            <label class="control-label">Display Till: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $displayTill;?>" name="displayTill" id="displayTill"/>
		                            </div>
		                        </div>-->
								<div class="control-group">
		                            <label class="control-label">Alt Tag:</label>
		                            <div class="controls">
		                                <input type="text" class="validate[] input-xlarge" value="<?php echo $title;?>" name="title" id="title"/>
		                            </div>
		                        </div>
                                <div class="control-group">
		                            <label class="control-label">Link:</label>
		                            <div class="controls">
		                                <input type="text" class="validate[] input-xlarge" value="<?php echo $link;?>" name="link" id="link"/>
		                            </div>
		                        </div>
                                <div class="control-group">
	                                <label class="control-label">Status:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == "1") echo "checked";?> name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" <?php if($activeStatus == "0") echo "checked";?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
                                <div class="form-actions align-right">
                                <button type="submit" class="btn btn-info" name="submit">Save</button>
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
