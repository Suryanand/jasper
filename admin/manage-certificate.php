<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

if(isset($_POST["order"]))
{
	$iValue			= mysqli_real_escape_string($con,$_POST["order"]);
	$id		 		= mysqli_real_escape_string($con,$_POST["id".$iValue]);
	$imageOrder 	= mysqli_real_escape_string($con,$_POST["imageOrder".$iValue]);

		mysqli_query($con,"update tbl_banners set bannerOrder='".$imageOrder."' where bannerId='".$id."'") or die(mysqli_error($con));
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}

if(isset($_POST["delete"]))
{
	$id			= mysqli_real_escape_string($con,$_POST["delete"]);
	$rslt=mysqli_query($con,"SELECT * FROM tbl_certificates where id='".$id."'");
	$row=mysqli_fetch_assoc($rslt);
	unlink("../images/certificate/".$row["certificate"]);
	mysqli_query($con,"delete from tbl_certificates where id='".$id."'") or die(mysqli_error($con));
	echo "<script>location.href = 'manage-certificate.php'</script>";
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
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});

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

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Qualification
                <a href="new-certificate.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
                </h5>
                
				<div class="table-overflow">
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.No.</th>
                                                            <th>Image</th>
                                                            <th>Title</th>
                                                            <th class="actions-column">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    <!-- Display All User Details -->
                                                    <?php
                                                        $rslt=mysqli_query($con,"SELECT * FROM tbl_certificates");
                                                        $i=0;
                                                        while($row=mysqli_fetch_array($rslt))
                                                        {
                                                            $i++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?></td>
                                                            <td><img src="../images/certificate/<?php echo $row["certificate"];?>"  width="150" /></td>
                                                            <td><?php echo $row["title"];?></td>
                                                            <td>
		                                <ul class="navbar-icons">
                                        	<li><a href="edit-certificate.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>		                                    
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row["id"];?>" class="remove-button-icon" name="delete">
<i class="icon-remove"></i></button></li>
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
