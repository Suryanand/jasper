<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 


if($userType==2 && !isset($m_banners)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

// form submit
if(isset($_POST["submit"]))
{
	$active			= $_POST["active"];
	$showCaption	= $_POST["showCaption"];
	$bannerText1		= mysqli_real_escape_string($con,$_POST["bannerText1"]);
	$bannerText2	= mysqli_real_escape_string($con,$_POST["bannerText2"]);
	$bannerLink		= mysqli_real_escape_string($con,$_POST["bannerLink"]);
	$bannerImageAlt		= mysqli_real_escape_string($con,$_POST["bannerImageAlt"]);
	$bannerLinkCaption		= mysqli_real_escape_string($con,$_POST["bannerLinkCaption"]);
	$flag		= 0;
	/* Image Upload Start */
	$bannerImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/banners");
	if($image["bannerImage"]){
		$upload = $image->upload(); 
		if($upload){
			$bannerImage=$image->getName().".".$image->getMime();
			/* insert into table*/
			mysqli_query($con,"insert into tbl_banners (bannerImage,bannerImageAlt,bannerText1,bannerText2,bannerLink,activeStatus,showCaption,updatedOn,bannerLinkCaption)values('".$bannerImage."','".$bannerImageAlt."','".$bannerText1."','".$bannerText2."','".$bannerLink."','".$active."','".$showCaption."',NOW(),'".$bannerLinkCaption."')") ;
		}else{
			echo $image["error"]; 
		}
	}
	/* Image upload Ends */	
	echo "<script>location.href = 'manage-banner.php'</script>";
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
				<h5 class="widget-name"><i class="icon-picture"></i>Slider Image <a href="manage-banner.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
                                <div class="control-group">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br><?php echo image_size('home_slider');?></label>
	                                <div class="controls">
	                                    <input type="file" name="bannerImage" multiple id="bannerImage" class="validate[required,custom[images]]">
                                        <span style="color:red;"><?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);}?></span>
	                                </div>
									<br clear="all"/>
	                                <label class="control-label">Alt Tag</label>
									<div class="controls">
										<input type="text" class="validate[] input-xlarge" name="bannerImageAlt" id="bannerImageAlt"/>
									</div>
	                            </div>
                                <div class="control-group ">
	                                <label class="control-label">Slider Caption 1:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xxlarge" name="bannerText1" id="bannerText1"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Slider Caption 2:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xxlarge" name="bannerText2" id="bannerText2"/>
	                                </div>
	                            </div>
								<div class="control-group ">
	                                <label class="control-label">Banner Button Caption:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xxlarge" name="bannerLinkCaption" id="bannerLinkCaption"/>
	                                </div>
	                            </div>
								<div class="control-group ">
	                                <label class="control-label">Banner Link:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $absolutePath;?>" readonly class="validate[] input-xlarge"/>
	                                    <input type="text" value="" class="validate[] input-xlarge" name="bannerLink" id="bannerLink"/>
	                                </div>
	                            </div>
                                <div class="control-group ">
	                                <label class="control-label">Show Caption:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="showCaption" id="active" value="1" data-prompt-position="topLeft:-1,-5"/>
											Show
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="showCaption" id="inactive" value="0" data-prompt-position="topLeft:-1,-5"/>
											Hide
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Active:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="active" id="active" value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" id="inactive" value="0" data-prompt-position="topLeft:-1,-5"/>
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
