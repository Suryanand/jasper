<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType==2) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	/* delete category */
		$rslt=mysqli_query($con,"select image from tbl_library where id='$deleteId'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["image"]))
		{
			unlink("../images/speech/".$row["image"]);
		}
		$rslt=mysqli_query($con,"select imageName from tbl_images where fkId='$deleteId' and imageType='speech'");
		while($row  = mysqli_fetch_assoc($rslt))
		{
		if(!empty($row["imageName"]))
		{
			unlink("../images/speech/".$row["imageName"]);
		}
		}
		mysqli_query($con,"delete from tbl_library where id='$deleteId'");
		mysqli_query($con,"delete from tbl_images where fkId='$deleteId' and imageType='speech'");
		$_SESSION['response'] = 'Speech Deleted';
		echo "<script>location.href = 'manage-library.php'</script>";
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
<style>
.ui-datepicker-append {
	display:none;
}
</style>
</head>
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
      <div class="page-header">
        <div class="page-title">
          <h5>Dashboard</h5>
        </div>
      </div>
      <!-- /page header -->
      <h5 class="widget-name"><i class="icon-th"></i>Manage Speeches <a href="new-library.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a> </h5>
      <div class="table-overflow">
        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
          <table class="table table-striped table-bordered table-checks media-table">
            <thead>
              <tr>
                <th>SR.NO.</th>
                <th>TITLE</th>
                <th>DATE</th>
                <th class="actions-column">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display All News and Events -->
              <?php
							$rslt=mysqli_query($con,"select * from tbl_library");
							$i=0;
							while($row=mysqli_fetch_array($rslt))
							{
								$i++;									
?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $row['title'] ?></td>
                <td><?php echo date('d-m-Y',strtotime($row['publicationDate'])); ?></td>
                <td><ul class="navbar-icons">
                    <li><a href="edit-library.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
                    <li>
                      <button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button>
                    </li>
                  </ul></td>
              </tr>
              <?php 
							}
?>
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