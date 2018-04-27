<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Customer"] == 0) 
{
	header('location: index.php');
}
if(isset($_POST["delete"]))
{
	$deleteId=$_POST["delete"];
	$rslt=mysqli_query($con,"select  * from tbl_customers t1,tbl_orders t2 where t1.customer_id=t2.user_id and t1.customer_id='".$deleteId."'");
	if(mysqli_num_rows($rslt)>0)
	{
		$_SESSION['response'] = 'Cannot delete! Order history not empty';
	}
	else
	{
		/*mysqli_query($con,"DELETE t1,t3
      FROM tbl_customers t1
      JOIN tbl_shipping_addresses t3 ON t1.customer_id = t3.fkCustomer
     WHERE t1.customer_id='".$deleteId."'");*/
		
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
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>
<script>
/* confirm to delete */
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Manage Customer</h5>

				<div class="table-overflow">
					<form action="" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>E-Mail</th>
                                    <th>Contact Number</th>
                                    <th>Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"select * from tbl_customers");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td>
									<a href="customer-details.php?id=<?php echo $row['customer_id'];?>" class="tip" title="View"><?php echo $row['first_name']." ".$row['last_name']; ?></a>
									</td>
			                        <td><?php echo $row['email']; ?></td>
			                        <td><?php echo $row['phone']; ?></td>
			                        <td><?php if($row['login_active']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">										
		                                    <li><a href="customer-details.php?id=<?php echo $row['customer_id'];?>" class="tip" title="View"><i class="icon-search"></i></a></li>
											<li>
											<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['customer_id'];?>" class="remove-button-icon" name="delete"><i class="icon-remove"></i></button>
											</li>											
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
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
