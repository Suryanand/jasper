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
$rslt=mysqli_query($con,"select * from tbl_customers where customer_id='".$customer_id."'");
$row=mysqli_fetch_assoc($rslt);
$customerEmail=$row['email'];
$first_name=$row['first_name'];
$last_name=$row['last_name'];
$contactNumber=$row['phone'];
$email=$row['email'];
$active=$row['login_active'];
if(isset($_POST["activate"]))
{
	mysqli_query($con,"update tbl_customers set login_active='".$_POST["activate"]."' where customer_id='".$customer_id."'");
	echo "<script>location.href = 'customer-details.php?id=$customer_id';</script>";exit();
}

//reset password
if(isset($_POST['change']))
{
	$password		= mysqli_real_escape_string($con,$_POST['password']);	
	$newPassword	= mysqli_real_escape_string($con,$_POST['password1']);
	$options = [
    'cost' => 12,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	];
	if($password==$newPassword)
	{
		$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
		mysqli_query($con,"update tbl_customers set password_hash='$password_hash' where customer_id='".$customer_id."'") or die(mysqli_error($con));
		$_SESSION["response"]="Password Resetted";
	}
	else
	{
		$_SESSION["err"]="Password Not Matching";
	}
	echo "<script>location.href = 'customer-details.php?id=$customer_id';</script>";exit();
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
			    <div class="page-header">
			    	<div style="float:none;"class="page-title">
				    	<a style="float:left;" href="index.php"><h5>Dashboard &nbsp;</h5></a>
				    	<a  href="manage-customer.php"><h5> >> Manage Customers</h5></a>
			    	</div>
			    </div>
			    <!-- /page header -->
				<div class="tabbable">	
					<ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">General</a></li>
	                                <li><a href="#tab2" data-toggle="tab">Order History</a></li>
	                                <!--<li><a href="#tab4" data-toggle="tab">Arabic</a></li>-->

					</ul>
					<div class="tab-content">
                    <div class="tab-pane active" id="tab1"> 
				
						<div class="well row-fluid">                            
                            	<div class="well-smoke body">
									<div class="span12">										
										<a href="new-invoice.php?id=<?php echo $customer_id;?>" class="btn btn-info pull-right" value="">New Invoice</a>
										<form action="" method="post" class="pull-right">
											<button type="submit" class="btn <?php if($active==1) echo "btn-danger";else echo "btn-success";?>" name="activate" value="<?php if($active==1) echo "0";else echo "1";?>">
												<?php if($active==1) echo "Deactivate";else echo "Activate";?>
											</button>
										</form>
									</div><br clear="all"/>

								</div>
							</div>
				<div class="well-smoke body row-fluid">
					<div class="span6">
					
						<table class="table">
										<tbody>
											<tr>
												<th>First Name</th>
												<th><?php echo $first_name;?></th>
											</tr>
											<tr>
												<th>Last Name</th>
												<th><?php echo $last_name;?></th>
											</tr>
											<tr>
												<th>Email</th>
												<th><?php echo $email;?></th>
											</tr>
											<tr>
												<th>Contact #</th>
												<th><?php echo $contactNumber?></th>
											</tr>											
											<tr>
												<th>Account Status</th>
												<th><?php if($active==1) echo '<span style="color:green;">Active</span>'; else echo '<span style="color:red;">Inactive</span>';?></th>
											</tr>
										</tbody>
									</table>
						
					</div>
					<div class="span6">
					<dl class="dl-horizontal">
						<dt>Shipping Addressess :</dt>
						<?php
						$rslt=mysqli_query($con,"select * from tbl_shipping_addresses where fkCustomer='$customer_id'");
						while($row=mysqli_fetch_assoc($rslt))
						{
						?>
                        <dd style="float:left;margin-left:20px;"><?php echo nl2br($row['fullName']."\n".$row['address']."\n".$row['location']."\n".$row['area']."\n".$row['state']."\n".$row['country']."\n".$row['PIN']."\n".$row['phone1']."\n".$row['phone2']."\n".$row['email']."\n");?></dd>
						<?php }?>
					</dl>					
					</div>
					<form action="" method="post">
					<br clear="all"><br>					
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
                </div>				
				</div>
				<div class="tab-pane" id="tab2"> 
				<div class="table-overflow">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Order #</th>
                                    <th>Items</th>
                                    <th>Order Date</th>
                                    <th>Amount</th>
                                    <th>Customer</th>
                                    <th class="align-center">Payment Status</th>
                                    <!--<th>Order Status</th>-->
                                    <th class="actions-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
							$i=0;
							$rslt=mysqli_query($con,"select * from tbl_orders t1,tbl_customers t2 where t1.user_id=t2.customer_id and t1.user_id='".$customer_id."' order by id desc");
							while($row=mysqli_fetch_assoc($rslt))
							{
								$i++;
								//$trackingStatus=$row["trackingStatus"];
								$order_id=$row["order_id"];
								$order_items=json_decode($row["order_items"],TRUE);
								$order_amount=$row["order_amount"];
								$order_date=date('d M Y', strtotime($row["order_date"]));								
							?>
                                <tr style="border-bottom:solid thin #ddd;">
                                    <td><?php echo $i;?></td>
                                    <td><a href="order-details.php?id=<?php echo $order_id;?>" class="tip" title="View"><?php echo $order_id;?></a></td>
                                    <td>
                                    <?php
                                    foreach($order_items as $key=>$value)
                                    {	
                                        echo $value["product_name"];if(!empty($value["option"])) echo "-".$value["option"];echo '<br>';
                                	}?>
                                    </td>
                                    <td class=""><?php echo $order_date;?></td>
                                    <td class=""><?php echo $order_amount;?></td>
                                    <td class=""><?php echo $row["first_name"]." ".$row["last_name"];?></td>
                                    <td class="align-center"><?php if($row["payment_status"]==1) echo '<span style="color:green;">Paid</span>'; else{ if($row["payment_method"]=="Cash on Delivery") echo '<span style="color:orange;">Cash on Delivery</span>'; else echo '<span style="color:red;">Unpaid</span>';}?></td>
                                    <!--<td class=""><?php echo $trackingStatus;?></td>-->
                                    <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="order-details.php?id=<?php echo $order_id;?>" class="tip" title="View"><i class="icon-eye-open"></i></a></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php  }?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                      
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
