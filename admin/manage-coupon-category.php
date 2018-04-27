<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Getting logged in user details*/


if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_coupon_category where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$category=$row["category"];
	$activeStatus=$row["activeStatus"];
	$description=$row["description"];
}

// new user submit
if(isset($_POST["submit"]))
{
	$Category = mysqli_real_escape_string($con,$_POST["Category"]);
	$activeStatus = mysqli_real_escape_string($con,$_POST["active"]);
	$description = mysqli_real_escape_string($con,$_POST["description"]);
						
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_coupon_category where category='$Category'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["err"]="Category already created";
	}
	else
	{						
		mysqli_query($con,"insert into tbl_coupon_category (category,description,activeStatus)values('$Category','$description','$activeStatus')") or die(mysqli_error($con));
		$_SESSION["response"]="Category Created";
		echo "<script>location.href = 'manage-coupon-category.php'</script>";
	}
}

if(isset($_POST["update"]))
{
	$category=mysqli_real_escape_string($con,$_POST["Category"]);
	$activeStatus = mysqli_real_escape_string($con,$_POST["active"]);
	$description = mysqli_real_escape_string($con,$_POST["description"]);
	$categoryId=$_POST["update"];
	mysqli_query($con,"update tbl_coupon_category set category='$category',activeStatus='$activeStatus',description='$description' where id='$categoryId'") or die(mysqli_error($con));							
	
	echo "<script>location.href = 'manage-coupon-category.php'</script>;";
}
if(isset($_POST["delete"]))
{
$id=mysqli_real_escape_string($con,$_POST["delete"]);

$rslt=mysqli_query($con,"select * from tbl_coupons where categoryId='$id' and activeStatus=1");
if(mysqli_num_rows($rslt)>0)
{
	$_SESSION['response'] = 'Coupon List in use. Cannot be deleted';	
}
else
{
	mysqli_query($con,"delete from tbl_coupon_category where id='$id'");
	mysqli_query($con,"delete from tbl_coupons where categoryId='$id'");
	$_SESSION['response'] = 'Coupon List Deleted';
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
<?php include_once('js-scripts.php'); ?>

<style>
.ui-datepicker-append{display:none;}
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
			<!--    <div class="page-header">
			    	<div class="page-title">
				    	<h5>Dashboard</h5>				    	
			    	</div>
			    </div>-->
				<br clear="all"/>
				<h5 class="widget-name"><i class="icon-gift"></i>Coupon Category</h5>
			    <!-- /page header -->
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>
	                    <!-- Form validation -->
	                    <div class="widget" style="margin-bottom: 0px;">
	                    	<div class="well row-fluid">
								<div class="control-group">
	                                <label class="control-label">Coupon Category Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $category;?>" class="validate[required] input-xlarge" name="Category" id="Category"/>					
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">Coupon List already created</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
	                                </div>
									<br>
	                                <label class="control-label">Details</label>
									<div class="controls">
										<textarea name="description" class="input-xlarge"><?php if(isset($_GET["id"])) echo $description;?></textarea>
									</div>
									<div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" <?php if(isset($_GET["id"])){if($activeStatus==1) echo"checked";} else echo "checked";?> name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if(isset($_GET["id"])){if($activeStatus==0) echo"checked";}?> name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
									</div>
									<div class="controls">
									<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info updt-btn" name="<?php if(isset($_GET["id"])) echo "update"; else echo "submit";?>"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
									</div>
	                            </div>	                            
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
				
				<div class="table-overflow">
							<form action="" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Category</th>
                                    <th>Details</th>
                                    <th class="align-center width10">Status</th>
                                    <th class="actions-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_coupon_category order by category asc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><a href="manage-coupon.php?id=<?php echo $row['id'];?>" class="tip" title="View Coupons"><?php echo $row['category']; ?></a></td>
			                        <td><?php echo $row['description']; ?></td>
			                        <td class="align-center">
										<?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?>
									</td>
			                        <td  class="align-center width20">
		                                <ul class="navbar-icons">
											<li><a href="manage-coupon.php?id=<?php echo $row['id'];?>" class="tip" title="View Coupons"><i class="icon-eye-open idesign3"></i></a></li>
											<li><a href="manage-coupon-category.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil idesign"></i></a></li>
		                                    <li>
											<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete">
<i class="icon-remove idesign2"></i></button>
											</li> 
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                            </tbody>
                        </table>
                            </form>
                    </div>
				<!-- /form validation -->
		    </div>
		    <!-- /content wrapper -->
		</div>
		<!-- /content -->
	</div>
	<!-- /content container -->
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<?php if(isset($_SESSION["response"]))
                                                {
                                                    echo "<script>alert('".$_SESSION["response"]."');</script>";
                                                    unset($_SESSION["response"]);
                                                }
                                                ?>
	<!-- /footer -->
	<script>
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});

function clickMe()
{
var r=confirm("Are you sure, You want to delete?");
if(r==true)
  { return true;
  }
else
{
return false;
}
}
function editService(i)
	{
		if ( $('#categoryName'+i).is('[readonly]') )
		{
		$("#categoryName"+i).prop('readonly', false);
		}
		else{
		$("#categoryName"+i).prop('readonly', true);			
		}
	}
</script>
</body>
</html>
