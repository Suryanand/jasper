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
	mysqli_query($con,"delete from tbl_student_registration where id='".$_POST["delete"]."'");
	echo "<script>location.href = 'view-registrations.php';</script>";exit();
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Course Registrations
				<a href="export-list.php" class="pull-right"><i class="icon-download" style="margin-top:3px;"></i> &nbsp; Export</a>
				</h5>
				<div class="row-fluid">
				<form action="" method="post">
					<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Student Name</th>
                                    <th>DOB</th>
                                    <th>Father's' Name</th>
                                    <th>Home Contact</th>
                                    <th>Father Mobile</th>
                                    <th style="width:9%;">Reg. Date</th>
                                    <th style="width:9%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$i=0;
							$rslt=mysqli_query($con,"select * from tbl_student_registration order by id desc");
							while($row=mysqli_fetch_assoc($rslt))
							{ 
								$i++;
								?>
								<tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $row["studentName"];?></td>
                                    <td><?php echo $row["dob"];?></td>
                                    <td><?php echo $row["fname"];?></td>
                                    <td><?php echo $row["homePhone"];?></td>
                                    <td><?php echo $row["fMobile"];?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row["registeredOn"]));?></td>
									<td>
		                                <ul class="navbar-icons">
		                                    <li><a href="view-details.php?id=<?php echo $row['id'];?>" class="tip" title="View"><i class="icon-eye-open"></i></a></li>

		                                    <li><button type="submit" title="Delete" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button></li> 
		                                </ul>
			                        </td>
                                </tr>
							<?php 
							?>
							
							<div id="myModal<?php echo $row["id"];?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
								  
								  <div class="modal-body">
									<p><?php echo $row["details"];?></p>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  </div>
								</div>

							  </div>
							</div>
							
							<?php }
							?>
                           
                                
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
