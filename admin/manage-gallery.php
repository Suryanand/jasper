<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_gallery)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$gTitleId=$_GET['id'];

$rslt			= mysqli_query($con,"select galleryTitle from tbl_gallery_titles where galleryTitleId='".$gTitleId."'")or die(mysql_error());
$row			= mysqli_fetch_assoc($rslt);
$galleryTitle	= $row["galleryTitle"];

if(isset($_POST['submit']))
{
$set="";
$rslt=mysqli_query($con,"select * from tbl_gallery where gTitleId='$gTitleId' order by gallerySort asc");
while($row=mysqli_fetch_assoc($rslt))
{
$orderName="image".$row["galleryId"];
$orderNo=$_POST[$orderName];
$captionName="caption".$row["galleryId"];
$caption=$_POST[$captionName];

mysqli_query($con,"update tbl_gallery set gallerySort='$orderNo',caption='$caption' where galleryId='".$row["galleryId"]."' ") or die(mysql_error());
}
echo "<script>location.href = 'manage-gallery.php?id=$gTitleId'</script>;";															
}

if(isset($_POST['delete']))
{
	$id=$_POST['delete'];
	$rslt=mysqli_query($con,"select * from tbl_gallery where galleryId='$id'");
while($row=mysqli_fetch_array($rslt))
{
	$image=$row['galleryImage'];
	$album=$row['gTitleId'];
	$thumbnail_to_delete = '../images/gallery/'.$album.'/'.'thumbnail/'.$image;
	$image_to_delete = '../images/gallery/'.$album.'/'.$image;
	unlink($thumbnail_to_delete);
	unlink($image_to_delete);
}
/* delete Image */
mysqli_query($con,"delete from tbl_gallery where galleryId='$id'") or die(mysql_error());
echo "<script>alert('Image Deleted');</script>";												
echo "<script>location.href = 'manage-gallery.php?id=$album';</script>";												

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
		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Gallery Images - <?php echo $galleryTitle;?>
                <a href="gallery.php?id=<?php echo $gTitleId;?>" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>

				<form action="" method="post">
				<div class="form-actions align-right">
                    <button type="submit" class="btn btn-info" name="submit">Update</button>
                    <button type="reset" class="btn">Reset</button>
                </div>
				<?php 
				$i=0;
				$rslt=mysqli_query($con,"select * from tbl_gallery where gTitleId='$gTitleId' order by gallerySort asc");
				if(mysqli_num_rows($rslt)>0)
				{
				while($row=mysqli_fetch_array($rslt))
				{
					$id=$row['galleryId'];
					if($i%4==0)
					{									
				?>
						<div class="media row-fluid">
                <?php } ?>						
							<div class="span3">
								<div class="widget">
									<div class="well">
										<div class="view">
											<a href="../uploads/images/gallery/<?php echo $gTitleId.'/'.$row['galleryImage']; ?>" class="view-back lightbox"></a>
											<img src="../uploads/images/gallery/<?php echo $gTitleId.'/'; ?><?php echo $row['galleryImage']; ?>" alt="" />
										</div>
										<div class="item-info">
											<input  name="<?php echo "caption".$row['galleryId']; ?>" value="<?php echo $row['caption']; ?>" placeholder="Caption" class="span12" type="text">
											<div class="input-append align-left" style="float:left;">
												<span style="/* display: block; *//* color: rebeccapurple; */font-size: 12px;display:block;padding-top:5px;float:left;">Sort order</span>
												<input  name="<?php echo "image".$row['galleryId']; ?>" value="<?php echo $row['gallerySort']; ?>" class="input-mini" type="text">
											</div>
											<div class="align-right">
												<button value="<?php echo $row['galleryId']; ?>" type="submit" name="delete" class="btn btn-danger tip align-right" onClick="return clickMe()" title="Delete"><i class="icon-trash"></i></button>
											</div>
										</div>
									</div>
								</div>						
							</div>
				<?php 
					if(($i+1)%4==0)
					{
				?>
						</div>
				<?php }
					$i++;
				}?>

				<br clear="all">
                <div class="form-actions align-right">
                    <button type="submit" class="btn btn-info" name="submit">Update</button>
                    <button type="reset" class="btn">Reset</button>
                </div>
				<?php }
				else
				{
					echo "No image is added in this album";
				}
				?>                				
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

</body>
</html>
