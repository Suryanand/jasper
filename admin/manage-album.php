<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_gallery)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_SESSION["gTitleId"]))
	unset($_SESSION["gTitleId"]);

if(isset($_POST["delete"]))
{
$deleteAlbumId=$_POST["delete"];
/* delete dish */
$path='../images/gallery/'.$deleteAlbumId;
deleteDir($path);

mysqli_query($con,"delete from tbl_gallery where gTitleId='$deleteAlbumId'");
mysqli_query($con,"delete from tbl_gallery_titles where galleryTitleId='$deleteAlbumId'");
$_SESSION['response'] ='Album Removed';
}
function deleteDir($path) {
    if (empty($path)) {
        return false;
    }
    return is_file($path) ?
            @unlink($path) :
            array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}

if(isset($_POST["update"]))
{
	$id=$_POST["update"];
	$albumTitle=mysqli_real_escape_string($con,$_POST["albumTitle".$id]);
	mysqli_query($con,"update tbl_gallery_titles set galleryTitle='".$albumTitle."' where galleryTitleId='".$id."'");
}
if(isset($_POST["enable"]))
{
	$id=$_POST["enable"];
	mysqli_query($con,"update tbl_gallery_titles set activeStatus= IF(activeStatus = '0', 1, 0) where galleryTitleId='".$id."'");
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
/* confirm to delete user */
function clickMe()
{
var r=confirm("It will delete all images under this Album. Are you sure to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
}
}
function editAlbum(i)
	{
		if ( $('#albumTitle'+i).is('[readonly]') )
		{ 
		$('#albumTitle'+i).prop('readonly', false);
		$('#update'+i).show();
		}
		else{
		$('#albumTitle'+i).prop('readonly', true);
		$('#update'+i).hide();		
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

				<h5 class="widget-name"><i class="icon-th"></i>Manage Album
                <a href="add-gallery.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
				<div class="table-overflow">
					<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Album Title</th>
                                    <th class="align-center width10"># of Images</th>
                                    <th class="align-center">Enable / Disable</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_gallery_titles");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$rslt1=mysqli_query($con,"select * from tbl_gallery where gTitleId='".$row["galleryTitleId"]."'");
									$num=mysqli_num_rows($rslt1);
									$i++;									
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td>
									<input type="text" style="float:left;" readonly value="<?php echo $row['galleryTitle'];?>" class="validate[required] input-xxlarge" name="albumTitle<?php echo $row['galleryTitleId'];?>" id="albumTitle<?php echo $row['galleryTitleId'];?>"/>
									<i class="icon-pencil" onClick="editAlbum(<?php echo $row['galleryTitleId'];?>)" style="margin-left:10px;cursor:pointer;margin-top:4px;"></i>
									<button type="submit" style="margin-top:4px;display:none;" title="Update"  value="<?php echo $row['galleryTitleId'];?>" class="remove-button-icon" id="update<?php echo $row['galleryTitleId'];?>" name="update"><i class="ico-ok"></i></button>
									</td>
			                        <td class="align-center"><?php echo $num;?></td>
			                        <td class="align-center">
										<button type="submit" title="Enable / Disable"  value="<?php echo $row['galleryTitleId'];?>" class="btn btn-<?php if($row["activeStatus"]==0) echo "info";else echo "danger";?>" id="update<?php echo $row['galleryTitleId'];?>" name="enable"><?php if($row["activeStatus"]==0) echo "Enable";else echo "Disable";?></button>
									</td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="manage-gallery.php?id=<?php echo $row['galleryTitleId'];?>" class="tip" title="View"><i class="icon-search"></i></a></li>

		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['galleryTitleId'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                          <?php } ?>
                            <!-- /Display All News and Events -->
                                
                            </tbody>
                        </table>
						</form>
                    </div>
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
