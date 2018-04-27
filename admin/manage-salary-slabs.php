<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$catId="";
$minSalary="";
$countries="";
if(isset($_GET["id"]))
{
	$rslt=mysqli_query($con,"select * from tbl_salary_slabs where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$minSalary=$row["minSalary"];
	$maxSalary=$row["maxSalary"];
}

if(isset($_POST["submit"]))
{
	$minSalary=mysqli_real_escape_string($con,$_POST["minSalary"]);
	$maxSalary=mysqli_real_escape_string($con,$_POST["maxSalary"]);
	if(isset($_GET["id"]))
	{
		mysqli_query($con,"update tbl_salary_slabs set minSalary='".$minSalary."',maxSalary='".$maxSalary."' where id='".$_GET["id"]."'");
	}
	else
	{
		mysqli_query($con,"insert into tbl_salary_slabs(minSalary,maxSalary) values('".$minSalary."','".$maxSalary."')");		
	}
	echo "<script>location.href = 'manage-salary-slabs.php';</script>";exit();
}
if(isset($_POST["delete"]))
{
	$id	= mysqli_real_escape_string($con,$_POST["delete"]);
	mysqli_query($con,"delete from tbl_salary_slabs where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-salary-slabs.php'</script>";exit();
}

if(isset($_POST["change"]))
{
	$id	= $_POST["change"];
	$order	= $_POST["order".$id];
	mysqli_query($con,"update tbl_salary_slabs set sortOrder='$order' where id='$id'");
	echo "<script>location.href = 'manage-salary-slabs.php';</script>";exit();
}

if(isset($_POST["update-all-order"]))
{
	$rslt=mysqli_query($con,"select * from tbl_salary_slabs");
	while($row=mysqli_fetch_array($rslt))
	{
		$id=$row["id"];
		if(!isset($_POST["order".$id]))
			continue;
		$sortOrder=mysqli_real_escape_string($con,$_POST["order".$id]);		
		mysqli_query($con,"update tbl_salary_slabs set sortOrder='".$sortOrder."' where id='".$id."'");
	}
	echo "<script>location.href = 'manage-salary-slabs.php';</script>";exit();
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
      <br>
      <!-- /page header -->
      <h5 class="widget-name"><i class="icon-th"></i>Manage Salary Slabs</h5>
	  
	  <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
								<div class="control-group">
	                                <label class="control-label">Min salary: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $minSalary;?>" class="validate[required] input-xlarge" name="minSalary" id="minSalary"/>										
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Max Salary: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(isset($_GET["id"])) echo $maxSalary;?>" class="validate[required] input-xlarge" name="maxSalary" id="maxSalary"/>										
										<button type="submit" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>" class="btn btn-info updt-btn" name="submit"><?php if(isset($_GET["id"])) echo "Update"; else echo "Save";?></button>
	                                </div>
	                            </div>								
								
	                            
	                        </div>
	                    </div>
	                    <!-- /form validation -->
	                </fieldset>
				</form>
	  
      <div class="table-overflow">
        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>Min Salary</th>
                <th>Max Salary</th>
                <th>Order</th>
                <th class="actions-column">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All User Details -->
              <?php
                $rslt=mysqli_query($con,"SELECT * from tbl_salary_slabs order by sortOrder asc");
                $i=0;
                while($row=mysqli_fetch_array($rslt))
                {
                $i++;
                ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row["minSalary"];?></td>
                <td><?php echo $row["maxSalary"];?></td>
				<td class="align-center"><input type="text" value="<?php echo $row["sortOrder"];?>" class="validate[] input-mini align-center" name="order<?php echo $row["id"];?>" id="order<?php echo $row["id"];?>"/>
                                    <button type="submit" value="<?php echo $row["id"];?>" class="remove-button-icon tip" title="Update Order" name="change"><i class="fam-tick"></i></button>
                                    </td>
                <td><ul class="navbar-icons">
                    <li><a href="manage-salary-slabs.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
                    <li>
                      <button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["id"];?>" class="remove-button-icon" name="delete"> <i class="icon-remove"></i></button>
                    </li>
                  </ul></td>
              </tr>
              <?php } ?>
            </tbody>
			<tfoot>
							<td colspan="3"></td>
							<td class="align-center"><button type="submit" class="btn btn-info" name="update-all-order" value="">Update All</button></td>
							<td colspan=""></td>
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
