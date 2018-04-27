<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include("functions.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}


if(isset($_POST['submit']))
{
	/* Image Upload Start */	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads");
	if($image["imageName"]){
		$upload = $image->upload(); 
		if($upload){
			$imageName=$image->getName().".".$image->getMime();			
			mysqli_query($con,"insert into tbl_media_library(imageName) value('".$imageName."')");
		}else{
			echo $image["error"]; 
		}
	}
	echo "<script>location.href = 'media-library.php';</script>";															
}


if(isset($_POST['delete']))
{
	$id=$_POST['delete'];
	$rslt=mysqli_query($con,"select * from tbl_media_library where id='$id'");
while($row=mysqli_fetch_array($rslt))
{
	$image=$row['imageName'];
	$image_to_delete = '../uploads/'.$image;
	unlink($image_to_delete);
}
/* delete Image */
mysqli_query($con,"delete from tbl_media_library where id='$id'") or die(mysql_error());
echo "<script>alert('Image Deleted');</script>";												
echo "<script>location.href = 'media-library.php';</script>";												

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
<script>

/* confirm to delete image */
function clickMe()
{
var r=confirm("Are you sure to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
}
}
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

				<!-- /gallery images -->
		    	<h5 class="widget-name"><i class="icon-facetime-video"></i>Media Library
                </h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
					 <div class="control-group">
	                    <label class="control-label">Upload Image: <span class="text-error">*</span></label>
	                    <div class="controls">
	                        <input type="file" name="imageName" id="imageName" class="validate[required,custom[images]]">
							<button type="submit" class="btn btn-info" name="submit">Upload</button>
	                    </div>
	                </div>
				</form>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
				<div class="row-fluid">
				<hr>
				<?php 
				$i=0;
				$rslt=mysqli_query($con,"select * from tbl_media_library");
				if(mysqli_num_rows($rslt)>0)
				{
				while($row=mysqli_fetch_array($rslt))
				{
					$id=$row['id'];
					?>					
							<div class="span3" style="height:250px;    margin-left: 10px;">
								<div class="widget">
									<div class="well">
										<div class="view" style="min-height:150px;max-height: 150px;overflow: hidden;">
											<a href="<?php echo $absolutePath."uploads/".$row['imageName']; ?>" class="view-back lightbox"></a>
											<img src="<?php echo $absolutePath."uploads/".$row['imageName']; ?>" alt="" />
										</div>
										<div class="item-info">
										<div>
											<span onClick="selectText('img<?php echo $row['id']; ?>');" class="img<?php echo $row['id']; ?>"><?php echo $absolutePath."uploads/".$row['imageName']; ?></span>
											</div>
											<div class="align-right">
												<button value="<?php echo $row['id']; ?>" type="submit" name="delete" class="btn btn-danger tip align-right" onClick="return clickMe()" title="Delete"><i class="icon-trash"></i></button>
											</div>
										</div>
									</div>
								</div>						
							</div>
				<?php 
					
					$i++;
				}?>
				<?php }
				else
				{
					echo "No image is available";
				}
				?>                				
				</div>
				</form>
				<br clear="all"/>
                <!-- /gallery images -->
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script>

function selectText(img) {
    var el = document.getElementsByClassName(img)[0];
    var range = document.createRange();
    range.selectNodeContents(el);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
};
</script>
</body>
</html>
