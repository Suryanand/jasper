<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/


//die($m_newsEvents);
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	/* delete category */
		$rslt=mysqli_query($con,"select link from tbl_schedule where id='$deleteId'");
		$row  = mysqli_fetch_assoc($rslt);
		if(!empty($row["link"]))
		{
			unlink("../uploads/pdf/".$row["link"]);
		}
		mysqli_query($con,"delete from tbl_schedule where id='$deleteId'");
		$_SESSION['response'] = 'Deleted';
		echo "<script>location.href = 'manage-conference.php'</script>";
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

		    	<h5 class="widget-name"><i class="icon-tasks"></i>Manage Schedule
				<a href="new-schedule.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
				</h5>

				<div class="table-overflow">
					<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Course / Workshop</th>
                                    <th class="align-center width10">Date From</th>
                                    <th class="align-center width10">Date To</th>
                                    <th class="align-center width15">Last Date</th>
                                    <th class="actions-column width10">Status</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All News and Events -->
<?php
							$rslt=mysqli_query($con,"select * from tbl_schedule order by id desc");
							$i=0;
							while($row=mysqli_fetch_array($rslt))
							{
								if($row["courseType"]==1)
								{
									$rslt2=mysqli_query($con,"select * from tbl_course where id='".$row["course"]."'");
									$row2=mysqli_fetch_assoc($rslt2);
									$courseName=$row2["courseName"];
								}
								else
								{
									$rslt2=mysqli_query($con,"select * from tbl_workshops where id='".$row["course"]."'");
									$row2=mysqli_fetch_assoc($rslt2);
									$courseName=$row2["workshop"];
								}
								
								$i++;									
?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $courseName; ?></td>
			                        <td class="align-center"><?php echo date('d-m-Y',strtotime($row['dateFrom'])); ?></td>
			                        <td class="align-center"><?php echo date('d-m-Y',strtotime($row['dateTo'])); ?></td>
			                        <td class="align-center"><?php echo date('d-m-Y',strtotime($row['lastDate'])); ?></td>
			                        <td class="align-center"><?php if($row["activeStatus"]==1) echo '<span style="color:green">Published</span>'; else echo '<span style="color:red">Draft</span>'?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="edit-schedule.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>

		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li> 
		                                </ul>
			                        </td>
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
