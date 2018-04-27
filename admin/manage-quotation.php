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

		    	<h5 class="widget-name"><i class="icon-th"></i>All Quotations
                <a href="new-quotation.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-plus"></i>Add New</a>
				</h5>

				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Order #</th>
                                    <th>Items</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th class="actions-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
							$i=0;
							$rslt=mysqli_query($con,"SELECT t1.*,t2.*,t3.*,t4.*
FROM tbl_quotation t1
LEFT JOIN tbl_order_status t2
ON t1.orderNo=t2.fkOrderNo
LEFT JOIN tbl_tracking_status  t3
ON t2.fkTRackingId=t3.id
LEFT JOIN tbl_customers  t4
ON t1.fkCustomer=t4.email where orderType=1
ORDER BY orderDate DESC");
							while($row=mysqli_fetch_assoc($rslt))
							{
								$i++;
								$trackingStatus=$row["trackingStatus"];
								$orderNumber=$row["orderNo"];
								$orderAmount=$row["orderAmount"];
								$shipTo=$row["billingAddress"];
								$orderDate=date('d M Y', strtotime($row["orderDate"]));
								if($row["activeStatus"]!=0 or is_null($row["activeStatus"]))
								{
							?>
                                <tr style="border-bottom:solid thin #ddd;">
                                    <td><?php echo $i;?></td>
                                    <td>
									<?php if($permission["Order"]>2){?>
										<a href="view-quotation.php?id=<?php echo $orderNumber;?>" class="tip" title="Edit"><?php echo $orderNumber;?></a>
									<?php }else {echo $orderNumber;}?>
									</td>
                                    <td>
                                    <?php $rslt2=mysqli_query($con,"SELECT * FROM tbl_products,tbl_quotation_items where deleteStatus='0' and tbl_quotation_items.productId=tbl_products.productId and tbl_quotation_items.fkOrderNumber='".$orderNumber."'") or die(mysqli_error($con));
                                    while($row2=mysqli_fetch_array($rslt2))
                                    {	
                                        $productId		= $row2["productId"];
                                        $productName	= $row2["productName"];
                                ?> 
								<?php echo $productName;?>
                                <br clear="all" />
                                    <?php }?>
                                    </td>
                                    <td class=""><?php echo $orderDate;?></td>
                                    <td class=""><?php echo $row["fkCustomer"];?></td>
                                    <td>
		                                <ul class="navbar-icons">
										<?php 
											if($permission["Order"]>2)
											{?>
		                                    <li><a href="view-quotation.php?id=<?php echo $orderNumber;?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
											<?php }?>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } }?>
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
