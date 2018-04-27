<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Order"] == 0) 
{
	header('location: index.php');
}
// delete category
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Orders</h5>
				
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
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
							$rslt=mysqli_query($con,"select * from tbl_orders t1,tbl_customers t2 where t1.user_id=t2.customer_id order by id desc limit 10");
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
