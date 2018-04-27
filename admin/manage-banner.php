<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType==2 && !isset($m_banners)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["order"]))
{
	$id			= mysqli_real_escape_string($con,$_POST["order"]);
	$imageOrder 	= mysqli_real_escape_string($con,$_POST["imageOrder".$id]);

		mysqli_query($con,"update tbl_banners set bannerOrder='".$imageOrder."' where bannerId='".$id."'") ;
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}

if(isset($_POST["delete"]))
{
	$id			= mysqli_real_escape_string($con,$_POST["delete"]);
	$rslt=mysqli_query($con,"select * from tbl_banners where bannerId='".$id."'");
	$row=mysqli_fetch_assoc($rslt);
	unlink("../uploads/images/banners/".$row["bannerImage"]);
	mysqli_query($con,"delete from tbl_banners where bannerId='".$id."'") ;
	$_SESSION["response"]="Slider image deleted";
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}

if(isset($_POST["down"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["down"]);
	$i = mysqli_real_escape_string($con,$_POST["nextId".$id]);
	
	$rslt=mysqli_query($con,"select * from tbl_banners where activeStatus=1 order by bannerOrder asc");
	$j=0;
	while($row=mysqli_fetch_assoc($rslt))
	{
		$j++;
		if($i==$j)
		{
			$nextOrder=$row["bannerOrder"];
			if(empty($nextOrder))
				$nextOrder=0;
			break;
		}
	}
	if(isset($nextOrder))
	{
		$bannerOrder=$nextOrder+1;
		mysqli_query($con,"update tbl_banners set bannerOrder='$bannerOrder' where bannerId='$id'");
	}
}

if(isset($_POST["up"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["up"]);
	$i = mysqli_real_escape_string($con,$_POST["prevId".$id]);
	$rslt=mysqli_query($con,"select * from tbl_banners where activeStatus=1 order by bannerOrder asc");
	$j=0;
	while($row=mysqli_fetch_assoc($rslt))
	{
		$j++;
		if($i==$j)
		{
			$prevOrder=$row["bannerOrder"];
			if(empty($prevOrder))
				$prevOrder=0;
			break;
		}
	}
	$bannerOrder=$prevOrder-1;
	mysqli_query($con,"update tbl_banners set bannerOrder='$bannerOrder' where bannerId='$id'");
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

			    <!-- Page header --><br><!-- /Page header -->

		    	<h5 class="widget-name"><i class="icon-picture"></i>Manage Slider
                <a href="new-banner.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
                
				<div class="table-overflow">
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="width5">Sr.No.</th>
                                                            <th class="width20">Image</th>
                                                            <th>Caption</th>
                                                            <!--<th>Caption 2</th>-->
                                                            <th class="align-center width10">Order</th>
                                                            <th class="align-center width10">Status</th>
                                                            <th class="align-center width15">Last Update</th>
                                                            <th class="actions-column width10">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    <!-- Display All User Details -->
                                                    <?php
                                                        $rslt=mysqli_query($con,"SELECT * FROM tbl_banners order by bannerOrder asc");
                                                        $i=0;
														$num=mysqli_num_rows($rslt);
                                                        while($row=mysqli_fetch_array($rslt))
                                                        {
                                                            $i++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?></td>
                                                            <td><img src="../uploads/images/banners/<?php echo $row["bannerImage"];?>"  width="150" /></td>
                                                            <td><?php echo $row["bannerText1"];?></td>
                                                            <!--<td><?php echo $row["bannerText2"];?></td>-->
                                                            <td>
																<!--<input type="text" value="<?php echo $row["bannerOrder"];?>"  maxlength="65" class="validate[] input-small" name="imageOrder<?php echo $row["bannerId"];?>"/>
																<button type="submit" value="<?php echo $row["bannerId"];?>" class="btn btn-info" name="order">Update</button>-->
																<ul class="navbar-icons">
																	<?php if($i!=$num){?>
																	<li><button type="submit" title="Down" style="float:left;" value="<?php echo $row['bannerId'];?>" class="remove-button-icon" name="down"><i class="ico-arrow-down"></i></button>
																	<input type="hidden" name="nextId<?php echo $row['bannerId'];?>" value="<?php echo $i+1;?>"/>
																	</li>
																	<?php }?>
																	<?php if($i!=1){?>
																	<li><button type="submit" title="Up" style="float:left;" value="<?php echo $row['bannerId'];?>" class="remove-button-icon" name="up"><i class="ico-arrow-up"></i></button>
																	<input type="hidden" name="prevId<?php echo $row['bannerId'];?>" value="<?php echo $i-1;?>"/>
																	</li>
																	<?php }?>
																</ul>
                                                            </td>
															<td class="align-center"><?php if($row['activeStatus']==1) {
																	echo '<span style="color:#08A715;">Active</span>';
																} else {
																	echo '<span style="color:#c05343;">Inactive</span>';
														 } ?></td>
															<td class="align-center"><?php echo $row["updatedOn"]; ?></td>
                                                            <td>
																<ul class="navbar-icons">											
																	<li><a href="edit-banner.php?id=<?php echo $row['bannerId'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
																	<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["bannerId"];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>											
																</ul>
															</td>
                                                        </tr>
                                                        <?php } ?>
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

<?php if(isset($_SESSION["response"]))
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
