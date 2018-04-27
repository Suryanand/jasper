<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType!=1)
{
	header('location: index.php');
}

if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_video_gallery where videoId='".$_POST["delete"]."'");
}
$id="";
if(isset($_GET["id"]))
	$id=$_GET["id"];
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
<style>
iframe {
	width:236px !important;
	height:217px !important;	
}
</style>
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
		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Gallery Videos
				<a href="add-video.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a></h5>

				<form action="" method="post">
				<div style="margin-bottom:20px;">
				<a href="manage-video-gallery.php" class="btn <?php if($id=="") echo "btn-success";?>" style="margin-right:10px;">All</a>
				<?php
				
				$rslt=mysqli_query($con,"select * from tbl_gallery_titles");
				$i=0;
				while($row=mysqli_fetch_array($rslt))
				{?>
					<a href="manage-video-gallery.php?id=<?php echo $row["galleryTitleId"];?>" class="btn <?php if($id==$row["galleryTitleId"]) echo "btn-success";?>" style="margin-right:10px;"><?php echo $row["galleryTitle"]?></a>
				<?php }
				?>
				</div>
				<?php 
				$i=0;
				$rslt=mysqli_query($con,"select * from tbl_video_gallery order by videoSort asc");
				if(isset($_GET["id"]))
					$rslt=mysqli_query($con,"select * from tbl_video_gallery where album='".$_GET["id"]."' order by videoSort asc");
				if(mysqli_num_rows($rslt)>0)
				{
				while($row=mysqli_fetch_array($rslt))
				{
					if($i%4==0)
					{									
				?>
						<div class="media row-fluid">
                <?php } ?>						
							<div class="span3">
								<div class="widget">
									<div class="well">
										<div class="view">
										<?php 
										$queryString = parse_url($row['videoLink'], PHP_URL_QUERY);
										parse_str($queryString, $params);
										?>
										<iframe width="420" height="315"src="http://www.youtube.com/embed/<?php echo $params['v'];?>"></iframe>
										</div>
										<div class="item-info">
											<div class="input-append align-left" style="float:left;">
												<input  name="<?php echo "video".$i; ?>" value="<?php echo $row['videoSort']; ?>" class="input-mini" type="text">
												<input  name="<?php echo "videoId".$i; ?>" value="<?php echo $row['videoId']; ?>" class="input-mini" type="hidden">
											</div>
											<div class="align-right">												
												<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['videoId'];?>" class="btn btn-danger tip align-right" name="delete"><i class="icon-trash"></i></button>
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
                <div class="form-actions">
                    <button type="submit" class="btn btn-info" name="submit">Change  Order</button>
                    <button type="reset" class="btn">Reset</button>
                </div>
				<?php }
				else
				{
					echo "No Video added";
				}
				?>                				
				</form>
                <!-- /gallery images -->
				
				<!-- /Form submission -->
				<?php
					if(isset($_POST['submit']))
					{
						$set="";
						for($j=0; $j<$i; $j++)
						{
							$orderName="video".$j;
							$videoName="videoId".$j;
							$orderNo=$_POST[$orderName];
							$videoId=$_POST[$videoName];
							mysqli_query($con,"update tbl_video_gallery set videoSort='$orderNo' where videoId=$videoId ") or die(mysql_error());
						}
						echo "<script>location.href = 'manage-video-gallery.php'</script>;";															
					}
				?>
				<!-- /Form submission -->
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

</body>
</html>
