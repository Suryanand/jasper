<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('category-functions.php'); /* Geting logged in user details*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

$companyType=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_category where id='$companyType'");
$row=mysqli_fetch_assoc($rslt);
$categoryName=$row["categoryName"];
// delete category
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_firm where id='".$_POST["delete"]."'");
	echo "<script>location.href = 'manage-firm.php?id=$companyType';</script>";exit();
}
if(isset($_POST["change"]))
{
	$catId	= $_POST["change"];
	$order	= $_POST["order".$catId];
	mysqli_query($con,"update tbl_firm set sortOrder='$order' where id='$catId'");
	echo "<script>location.href = 'manage-firm.php';</script>";exit();
}

if(isset($_POST["update-all-order"]))
{
	$rslt=mysqli_query($con,"select * from tbl_firm");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		if(!isset($_POST["order".$id]))
			continue;
		$sortOrder=mysqli_real_escape_string($con,$_POST["order".$id]);		
		mysqli_query($con,"update tbl_firm set sortOrder='".$sortOrder."' where id='".$id."'");
	}
	echo "<script>location.href = 'manage-firm.php';</script>";exit();
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Firm - <?php echo $categoryName;?>
<?php
if($companyType=='1'||$companyType=='2'||$companyType=='3'){
?> 
<a href="new-hospitals.php?id=<?php echo $companyType;?>" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>                            
<?php
} else {
?>
<a href="new-firm.php?id=<?php echo $companyType;?>" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
<?php } ?>
                <a href="export-firm.php?id=2" style="float:right;color:#555 !important;margin-right:10px;"><i style="padding:4px;" class="icon-download"></i>Export</a>
                </h5>
                
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>User</th>
                                    <th>Location</th>
                                    <th style="width: 10%;">Contact No</th>
                                    <th class="align-center">Order</th>
                                    <th>Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT t1.*,t2.fullName from tbl_firm t1 left join tbl_user_login t2 on t1.userId=t2.id where t1.companyType='$companyType' ORDER BY sortOrder asc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["companyName"]; ?></td>
			                        <td><?php if($row["userId"]==0) echo "Admin";else echo $row["fullName"]; ?></td>
                                                <td class="align-center"><?php echo $row["location"]; ?></td>
			                        <td><?php echo $row["contactNo"]; ?></td>
			                        <td class="align-center"><input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini align-center" name="order<?php echo $row["id"];?>" id="order<?php echo $row["id"];?>"/>
                                    <button type="submit" value="<?php echo $row["id"];?>" class="remove-button-icon tip" title="Update Order" name="change"><i class="fam-tick"></i></button>
                                    </td>
									<td><?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
<?php
if($companyType=='1'||$companyType=='2'||$companyType=='3'){
?>
<li><a href="edit-hospitals.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>                                                    
<?php } else {?>
<li><a href="edit-firm.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
<?php } ?>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
							<tfoot>
							<td colspan="4"></td>
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
