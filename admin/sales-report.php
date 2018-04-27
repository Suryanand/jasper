<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Report"] == 0)
{
	header('location: index.php');
}
// delete category
$orderStatus="";
if(isset($_POST["filter"]))
{
	$orderStatus=$_POST["orderStatus"];
	$status="";
	if($_POST["orderStatus"]!=0)
		$status=" and t2.fkTRackingId='".$_POST["orderStatus"]."'";
	$fromDate=date('Y-m-d',strtotime($_POST["fromDate"]));
	if(!empty($_POST["endDate"]))	
		$endDate=date('Y-m-d',strtotime($_POST["endDate"]));
	else
		$endDate=date('Y-m-d');
	$result=mysqli_query($con,"SELECT t1.*,t2.*,t3.*,t4.*
FROM tbl_orders t1
LEFT JOIN tbl_order_status t2
ON t1.orderNo=t2.fkOrderNo
LEFT JOIN tbl_tracking_status  t3
ON t2.fkTRackingId=t3.id
LEFT JOIN tbl_customers  t4
ON t1.fkCustomer=t4.email where orderDate between '$fromDate' AND '$endDate'".$status." ORDER BY orderDate DESC");
}
else{
	$result=mysqli_query($con,"SELECT t1.*,t2.*,t3.*,t4.*
FROM tbl_orders t1
LEFT JOIN tbl_order_status t2
ON t1.orderNo=t2.fkOrderNo
LEFT JOIN tbl_tracking_status  t3
ON t2.fkTRackingId=t3.id
LEFT JOIN tbl_customers  t4
ON t1.fkCustomer=t4.email
ORDER BY orderDate DESC");
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Sales Report</h5>
				<form action="" method="post">					
					<div class="row-fluid">
						<div class="control-group span3">	
						<label class="control-label">From Date:</label>
						<div class="controls">
							<input type="text" value="<?php if(isset($fromDate)){echo date('d-m-Y',strtotime($fromDate));}?>" class="datepicker validate[required] input-large" name="fromDate" id="fromDate"/>
						</div>
					</div>
					<div class="control-group span3">	
						<label class="control-label">To Date:</label>
						<div class="controls">
							<input type="text" value="<?php if(isset($endDate)){echo date('d-m-Y',strtotime($endDate));}?>" class="datepicker validate[required] input-large" name="endDate" id="endDate"/>
						</div>
					</div>
					<div class="control-group span3">	
						<label class="control-label">Status:</label>
						<div class="controls">
							<select name="orderStatus" class="validate[required] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="0">All</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT * FROM tbl_tracking_status order by displayOrder asc");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>" <?php if($orderStatus==$row["id"]) echo "selected";?> ><?php echo $row["trackingStatus"];?></option>
                                            <?php } ?>                                           
	                                    </select>
						</div>
					</div>
					<div class="control-group span3">	
						<div class="controls">
						<button type="submit" value="submit" class="btn btn-info" name="filter" style=" margin-top: 25px;padding: 7px;width: 50%;">Filter</button>
						</div>
					</div>
					</div>
					</form>
				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                        <table class="table table-striped table-bordered table-checks media-table2">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Order #</th>
                                    <th>Items</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th class="actions-column">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
							$i=0;							
							while($row=mysqli_fetch_assoc($result))
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
									<?php if($permission["Order"] > 2) {?>
									<a href="order-details.php?id=<?php echo $orderNumber;?>" class="tip" title="Edit"><?php echo $orderNumber;?></a>
									<?php } else {echo $orderNumber;}?>
									</td>
                                    <td>
                                    <?php $rslt2=mysqli_query($con,"SELECT * FROM tbl_products,tbl_order_items where deleteStatus='0' and tbl_order_items.productId=tbl_products.productId and tbl_order_items.fkOrderNumber='".$orderNumber."'") or die(mysqli_error($con));
                                    while($row2=mysqli_fetch_array($rslt2))
                                    {	
                                        $productId		= $row2["productId"];
                                        $productName	= $row2["productName"];
                                ?> 
								<?php echo $productName." ( ".$row2["quantity"]." )";?>
                                <br clear="all" />
                                    <?php }?>
                                    </td>
                                    <td class=""><?php echo $orderDate;?></td>
                                    <td class=""><?php echo $row["firstName"];?></td>
                                    <td class=""><?php echo $trackingStatus;?><br/><?php if(!empty($row["statusDate"])) echo "(".date('d M Y',strtotime($row["statusDate"])).")";?></td>
                                    <td class="align-center"><?php echo $row["orderAmount"];?></td>
                                    
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
