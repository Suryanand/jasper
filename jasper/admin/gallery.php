<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/


if(isset($_SESSION["gTitleId"]))
{
$gTitleId=$_SESSION["gTitleId"];
}
else if(isset($_GET["id"]))
{
$gTitleId=$_GET["id"];	
}
else
{
header('location: add-gallery-album.php');
}
$_SESSION["gTitleId"]=$gTitleId;
$rslt			= mysqli_query($con,"select galleryTitle from tbl_gallery_titles where galleryTitleId='".$gTitleId."'")or die(mysql_error());
$row			= mysqli_fetch_assoc($rslt);
$galleryTitle	= $row["galleryTitle"];
//get image size
$imageHeight	= 504;
$imageWidth		= 565;
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
			    
			    <!-- /page header -->
				<br>
				<h5 class="widget-name"><i class="icon-th"></i><?php echo 'Album : '.$galleryTitle;?> - Images: 565px X 504px (Max 5 files, total size <5MB)
                </h5>
                
                <!-- Image Uploader -->
				<div class="widget">
                    <div id="file-uploader-gallery" class="well">You browser doesn't have HTML 4 support.</div>
                </div>
                <!-- /Image Uploader -->                
                
				<!-- /form validation -->
                
                <!-- form submition -->

                <!-- /form submition -->  
<a href="manage-album.php" class="btn btn-info">Continue</a>				
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
