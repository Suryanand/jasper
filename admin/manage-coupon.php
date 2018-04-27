<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

$categoryId=$_GET["id"];
//delete Coupon
if(isset($_POST["delete"]))
{
	$id = $_POST["delete"];
	$coupon=$_POST["coupon"];
	$flagUsed=0;
	$rslt=mysqli_query($con,"select * from tbl_orders where coupon='".$coupon."' and paymentStatus=1");
	if(mysqli_num_rows($rslt)>0)
		$flagUsed=1;
	$rslt=mysqli_query($con,"SELECT * FROM `tbl_video_subscriptions` WHERE FIND_IN_SET('$coupon',coupons)");
	if(mysqli_num_rows($rslt)>0)
		$flagUsed=1;
	
	if($flagUsed==1)
	{
		$_SESSION["response"]="Sorry! Cannot delete this coupon";
		echo "<script>location.href = 'manage-coupon.php?id=".$categoryId."'</script>";exit();
	}
	else
	{
		mysqli_query($con,"delete from tbl_coupons where id='".$id."'")or die(mysqli_error($con));
		echo "<script>location.href = 'manage-coupon.php?id=".$categoryId."'</script>";exit();
	}
}

if (isset($_POST['upload'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		//echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		/* echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']); */
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
	$duplicate="";
	$i=0;
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$i++;
		if($i==1 || empty($data[0]))
			continue;
		$rslt=mysqli_query($con,"select * from tbl_coupons where couponCode='$data[0]'");
		if(!mysqli_num_rows($rslt)>0)
		{
			mysqli_query($con,"insert into tbl_coupons (couponCode,categoryId,discount,discountType,validFrom,validTill,forceDays,numDays,applyMode,activeStatus,createdOn,createdBy,updatedOn,updatedBy) values('".$data[0]."','".$categoryId."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."',NOW(),'".$CurrentUserId."',NOW(),'".$CurrentUserId."')") or die(mysqli_error($con));
		}
		else
		{
			$duplicate.=$data[0].'<br>';
		}
	}

	fclose($handle);
	//view upload form
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

			    <!-- Page header -->
				<br clear="all"/>
			  <h5 class="widget-name"><i class="icon-gift"></i>Manage Coupons
			  <a href="new-coupon.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add Coupon</a>
			  <a href="manage-coupon-category.php" style="float:right;color:#555 !important;margin-right:10px;"><i style="padding:2px;" class="icon-arrow-left"></i>Coupon Category</a>
			  </h5>
			    <!-- /page header -->

                
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget" style="margin-bottom: 0px;">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Import Coupon codes (CSV):<br>
									<a href="downloads/coupons.csv" download>Download CSV format sample</a>
									</label>
	                                <div class="controls">
	                                    <input type='file' name='filename'>
										<input type='submit' class="btn btn-info updt-btn" name='upload' value='Upload'>
	                                </div>
	                            </div>
	                            <?php if(isset($_POST["upload"])){?>
								<div class="control-group">
									<span style="color:#07A90E;">Import Done</span><br>
									<?php if(!empty($duplicate)) echo "<strong>Duplicate entries :</strong><br>".$duplicate;?>
								</div>
								<?php }?>
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Coupon Code</th>
                                    <th class="width10 align-center">Discount</th>
                                    <th class="width10 align-center">Discount Type</th>
                                    <th class="align-center">Valid From</th>
                                    <th class="align-center">Valid Till</th>
                                    <th class="align-center">Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$today=date('Y-m-d');
								$rslt=mysqli_query($con,"select * from tbl_coupons where validTill>='".$today."' and categoryId='".$categoryId."'");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["couponCode"]; ?>
									<input type="hidden" name="coupon" value="<?php echo $row["couponCode"]; ?>">
									</td>
			                        <td class="align-center"><?php echo $row["discount"]; ?></td>
			                        <td class="align-center"><?php if($row['discountType']=="percentage") echo '%'; else echo 'Amount'; ?></td>
			                        <td class="align-center"><?php echo date('d M Y',strtotime($row["validFrom"])); ?></td>
			                        <td class="align-center"><?php echo date('d M Y',strtotime($row["validTill"])); ?></td>
			                        <td class="align-center width10"><?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-coupon.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil idesign"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove idesign2"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                    </div>
					</form>
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
