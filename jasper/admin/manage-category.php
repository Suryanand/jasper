<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('category-functions.php'); /* Geting logged in user details*/

// delete category
if(isset($_POST["delete"]))
{
	delete_category($_POST["delete"]);
	echo "<script>location.href = 'manage-category.php';</script>";exit();
}
if(isset($_POST["change"]))
{
	$catId	= $_POST["change"];
	$order	= $_POST["order".$catId];
	update_order($catId,$order);
	echo "<script>location.href = 'manage-category.php';</script>";exit();
}

if(isset($_POST["update-all-order"]))
{
	update_all_order($_POST);
	echo "<script>location.href = 'manage-category.php';</script>";exit();
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

		    	<h5 class="widget-name"><i class="icon-barcode"></i>Manage Category
                <a href="new-category.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
                
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Created On</th>
                                    <th class="align-center">Order</th>
                                    <th class="align-center">Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT t1.id AS catId,t1.lastUpdate,t1.categoryName AS catName,t1.activeStatus,t1.sortOrder
FROM tbl_category t1 WHERE t1.parentId=0 order by sortOrder asc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        
			                        <td><?php echo $row["catName"]; ?></td>
			                        <td><?php echo date('d M Y  H:i:s',strtotime($row["lastUpdate"])); ?></td>
			                        <td class="align-center"><input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini align-center" name="order<?php echo $row["catId"];?>" id="order<?php echo $row["catId"];?>"/>
                                    <button type="submit" value="<?php echo $row["catId"];?>" class="remove-button-icon tip" title="Update Order" name="change"><i class="fam-tick"></i></button>
                                    </td>
									<td class="align-center"><?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-category.php?id=<?php echo $row['catId'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['catId'];?>" class="remove-button-icon tip" name="delete"><i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
							<tfoot>
							<td colspan="3"></td>
							<td class="align-center"><button type="submit" class="btn btn-info" name="update-all-order" value="">Update All</button></td>
							<td colspan="2"></td>
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
