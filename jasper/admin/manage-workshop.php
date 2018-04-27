<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

// delete category
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	/* delete category */
	mysqli_query($con,"update tbl_workshops set deleteStatus=1 where id='$deleteId'");
	$_SESSION['response'] = 'Workshop Deleted';
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}

if(isset($_POST["change"]))
{
	$id	= $_POST["change"];
	$order	= $_POST["order".$id];
	mysqli_query($con,"update tbl_workshops set sortOrder='".$order."' where id='".$id."'");
	echo "<script>location.href = 'manage-workshop.php';</script>";exit();
}
if(isset($_POST["update-all-order"]))
{ 
	$rslt=mysqli_query($con,"select * from tbl_workshops");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		if(!isset($_POST["order".$id]))
		{
			continue;
		}
		$sortOrder=mysqli_real_escape_string($con,$_POST["order".$id]);	
		mysqli_query($con,"update tbl_workshops set sortOrder='".$sortOrder."' where id='".$id."'") or die(mysqli_error($con));
	}
	//echo "<script>location.href = 'manage-workshop.php';</script>";exit();
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
<style>
.dataTable td:nth-last-child(2) { text-align: center; margin-right:0px;}
.dataTable th:nth-last-child(2) { text-align: center; }
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

		    	<h5 class="widget-name"><i class="icon-barcode"></i>Manage Workshop
                <a href="new-workshop.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
				</h5>

				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Workshop Name</th>
                                   
                                    <th class="width15">Sort Order</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
							$rslt=mysqli_query($con,"SELECT * FROM tbl_workshops t1 order by t1.sortOrder");
							
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo ($row['workshop']);?></td>
			                       
									<td><input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini" name="order<?php echo $row["id"];?>" id="order<?php echo $row["id"];?>"/>
									<button type="submit" value="<?php echo $row["id"];?>" class="btn btn-info" title="save" name="change">Update</button>
                                    </td>
			                        <td>
		                                <ul class="navbar-icons">
											
		                                    <li><a href="edit-workshop.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                   
											<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
											
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
							<tfoot>
							<td colspan="2"></td>
							<td class="align-center"><button type="submit" class="btn btn-info" name="update-all-order" value="">Update All</button></td>
							<td></td>
							</tfoot>
                        </table>
                        </form>
                        <?php if(isset($_SESSION["response"]))
						{
							echo "<script>alert('".$_SESSION["response"]."');</script>";
							unset($_SESSION["response"]);
						}
                        ?>
                    </div>
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
