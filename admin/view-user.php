<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include("functions.php");
if($userType==3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$customer_id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_user_login where id='".$customer_id."'");
$row=mysqli_fetch_assoc($rslt);
$fullName=$row['fullName'];
$email=$row['email'];
$activeStatus=$row['activeStatus'];

if(isset($_POST["activate"]))
{
	mysqli_query($con,"update tbl_user_login set activeStatus='".$_POST["activeStatus"]."' where id='".$customer_id."'");
	echo "<script>location.href = 'view-user.php?id=$customer_id';</script>";exit();
}

//reset password
if(isset($_POST['change']))
{
	$password		= mysqli_real_escape_string($con,$_POST['password']);	
	$newPassword	= mysqli_real_escape_string($con,$_POST['password1']);
	
	if($password==$newPassword)
	{
			$password_hash=encryptIt($password);
		mysqli_query($con,"update tbl_user_login set password='$password_hash' where id='".$customer_id."'") or die(mysqli_error($con));
		$_SESSION["response"]="Password Resetted";
	}
	else
	{
		$_SESSION["err"]="Password Not Matching";
	}
	echo "<script>location.href = 'view-user.php?id=$customer_id';</script>";exit();
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

		    	<h5 class="widget-name"><i class="icon-th"></i>User Details
                </h5>
			    <!-- /page header -->
				<div class="tabbable">	
					<ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">General</a></li>
	                                <li><a href="#tab2" data-toggle="tab">registrations</a></li>
	                                <!--<li><a href="#tab4" data-toggle="tab">Arabic</a></li>-->

					</ul>
					<div class="tab-content">
                    <div class="tab-pane active" id="tab1"> 
				
						<div class="well row-fluid">                            
                            	<div class="well-smoke body">
									<div class="span12">										
										<form action="" method="post" class="pull-left">
											<button type="submit" class="btn <?php if($activeStatus==1) echo "btn-danger";else echo "btn-success";?>" name="activate" value="<?php if($activeStatus==1) echo "0";else echo "1";?>">
												<?php if($activeStatus==1) echo "Deactivate";else echo "Activate";?>
											</button>
										</form>
										<form action="" method="post" class="pull-right">
					<div class="control-group">
						<label class="control-label">Change Password:</label>
						<div class="controls">
							<input type="password" value="" placeholder="New Password" class="validate[required] input-xlarge" name="password" id="password"/>
							<input type="password" value="" placeholder="Confirm Password" class="validate[required] input-xlarge" name="password1" id="password1"/>
							<button type="submit" class="btn btn-info" name="change" value="">Change</button>
							<?php
							if(isset($_SESSION["err"]))
							{
								echo '<span style="color:red;">'.$_SESSION["err"].'</span><br>';
								unset($_SESSION["err"]);
							}
							if(isset($_SESSION["response"]))
							{
								echo '<span style="color:green;">'.$_SESSION["response"].'</span><br>';
								unset($_SESSION["response"]);
							}
						?>
						</div>
					</div>
					</form>
									</div><br clear="all"/>

								</div>
							</div>
				<div class="well-smoke body row-fluid">
					<div class="span6">
					
						<table class="table">
										<tbody>
											<tr>
												<th>Name</th>
												<th><?php echo $fullName;?></th>
											</tr>											
											<tr>
												<th>Email</th>
												<th><?php echo $email;?></th>
											</tr>
											<tr>
												<th>Account Status</th>
												<th><?php if($activeStatus==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>';?></th>
											</tr>
										</tbody>
									</table>
						
					</div>
					<div class="span6">
										
					</div>
					
                </div>				
				</div>
				<div class="tab-pane" id="tab2"> 
				<div class="table-overflow">
                        <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Contact No</th>
                                    <th>Status</th>
                                    <th class="actions-column">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT * from tbl_firm where userId='$customer_id' ORDER BY sortOrder asc");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["companyName"]; ?></td>
			                        <td><?php if($row["companyType"]==1) echo "Clinic";elseif($row["companyType"]==2) echo "Hospital";else echo "Pharmacy";?></td>
			                        <td><?php echo $row["contactNo"]; ?></td>
									<td><?php if($row['activeStatus']==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>'; ?></td>
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="<?php if($row["companyType"]==1) echo "edit-clinic";elseif($row["companyType"]==2) echo "edit-hospital";else echo "edit-pharmacy";?>.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
							
                        </table>
                    </form>
                    </div>
				</div>
				
				
				</div>
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
  <?php if(isset($_SESSION["response"]))
						{
							echo "<script>alert('".$_SESSION["response"]."');</script>";
							unset($_SESSION["response"]);
						}
                        ?>
</body>
</html>
