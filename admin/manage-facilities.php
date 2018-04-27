<?php 
include("session.php"); /*Check for session is set or not if not redirect to login  */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index  */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// remove affiliation
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
		$rslt = mysqli_query($con,"select image from tbl_facilties where id='$deleteId'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["image"]))
		{
			unlink("../images/facility/".$row["image"]);
		}
		mysqli_query($con,"delete from tbl_facilties where id='$deleteId'");
		$_SESSION['response'] = 'ECA Deleted';
			echo "<script>location.href = 'manage-facilities.php'</script>";exit();
	
}


//update order
if(isset($_POST["order"]))
{
	$id				= mysqli_real_escape_string($con,$_POST["order"]);
	$sortOrder 	= mysqli_real_escape_string($con,$_POST["sortOrder".$id]);

		mysqli_query($con,"update tbl_facilties set sortOrder='".$sortOrder."' where id='".$id."'") ;
		echo "<script>location.href = 'manage-facilities.php'</script>";
}

if(isset($_POST["update-all-order"]))
{
	$rslt=mysqli_query($con,"select * from tbl_facilties");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		if(!isset($_POST["sortOrder".$id]))
			continue;
		$sortOrder=mysqli_real_escape_string($con,$_POST["sortOrder".$id]);
		mysqli_query($con,"update tbl_facilties set sortOrder='".$sortOrder."' where id='".$id."'");
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

			    <br clear="all"/>

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage ECA
                <a href="new-facility.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
                
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>ECA</th>
                                    <th>Sort Order</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT * from tbl_facilties order by sortOrder asc");
								$i=0;
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["facility"]; ?></td>
			                        <td>
									<input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini" name="sortOrder<?php echo $row["id"];?>"/>
                                        <button type="submit" value="<?php echo $row["id"];?>" class="btn btn-info" name="order">Update</button>
									</td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-facility.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
							<tfoot>
							<td colspan="2"></td>
							<td><button type="submit" class="btn btn-info" name="update-all-order" value="">Update all order</button></td>
							<td colspan="1"></td>
							</tfoot>
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
