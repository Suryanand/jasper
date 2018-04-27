<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($permission["Report"] == 0) 
{
	header('location: index.php');
}
// delete category
if(isset($_POST["delete"]))
{
	$deleteId	= mysqli_real_escape_string($con,$_POST["delete"]);
	/* delete category */
	mysqli_query($con,"update tbl_products set deleteStatus=1 where productId='$deleteId'");
	$_SESSION['response'] = 'Product Deleted';
/*		echo "<script>location.href = 'manage-banner.php'</script>";
*/}
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

		    	<h5 class="widget-name"><i class="icon-th"></i>Product Stocks Reserved
				</h5>

				<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
						<br/>
                        <table class="table table-striped table-bordered table-checks media-table2">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Total Stock</th>
                                    <th>Reserve</th>
                                    <th>Sold</th>
                                    <!--<th>Availability</th>-->
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
							$rslt=mysqli_query($con,"SELECT t1.`productId`,t1.holdStock,t1.qoh,t1.withoutQuantity,t1.productName,t1.availability,t2.categoryName,t3.BrandName
FROM tbl_products t1 LEFT JOIN `tbl_category` t2  ON t1.fkCategoryId = t2.categoryId LEFT JOIN `tbl_brands` t3 ON t1.`fkBrandId` = t3.`brandId` WHERE deleteStatus='0'");
								$i=0;
								while($row=mysqli_fetch_array($rslt))
								{
									$i++;
									$rslt2=mysqli_query($con,"SELECT SUM(quantity) AS sold FROM tbl_order_items,tbl_orders WHERE orderNo=fkOrderNumber and paymentStatus=1 and productId='".$row["productId"]."'");
									$row2=mysqli_fetch_assoc($rslt2);
									if(!empty($row2["sold"]))
										$sold=$row2["sold"];
									else
										$sold=0;
									$rslt3=mysqli_query($con,"select * from tbl_product_options_value where fkProductId='".$row["productId"]."'");
									if(mysqli_num_rows($rslt3)>0)
									{
										while($row3=mysqli_fetch_assoc($rslt3))
										{
											$fkOptionValue=explode(',',$row3["fkOptionValue"]);
											$fkOptionValue2=implode("','",$fkOptionValue);
											$options="";
											$rslt2=mysqli_query($con,"select * from tbl_option_values where id IN('$fkOptionValue2')");
											while($row2=mysqli_fetch_array($rslt2))
											{
												$options.=$row2["optionValue"]." ";
											}
											$rslt2=mysqli_query($con,"SELECT SUM(quantity) AS sold FROM tbl_order_items,tbl_orders WHERE orderNo=fkOrderNumber and paymentStatus=1 and productId='".$row["productId"]."' and productOptions='".$row3["id"]."'");
											$row2=mysqli_fetch_assoc($rslt2);
											if(!empty($row2["sold"]))
												$sold=$row2["sold"];
											else
												$sold=0;
											?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php echo strtolower($row['productName']." ".$options);?></td>
													<td><?php echo strtolower($row['categoryName']); ?></td>
													<td><?php echo strtolower($row['BrandName']); ?></td>
													<td><?php if($row["withoutQuantity"]==1) echo "-"; else echo $row3['quantity']; ?></td>
													<td><?php if($row["withoutQuantity"]==1) echo "-"; else echo $row['holdStock']; ?></td>
													<td><?php echo $sold; ?></td>
													<!--<td><?php if($row['availability']==1) echo '<span style="color:green;">Available</span>'; else echo '<span style="color:red;">Unavailable</span>'; ?></td>-->
												</tr>
												<?php
										}
										continue;
										//tr in loop then continue 
										//
									}
									
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo strtolower($row['productName']);?></td>
			                        <td><?php echo strtolower($row['categoryName']); ?></td>
			                        <td><?php echo strtolower($row['BrandName']); ?></td>
			                        <td><?php if($row["withoutQuantity"]==1) echo "-"; else echo $row['qoh']; ?></td>
			                        <td><?php if($row["withoutQuantity"]==1) echo "-"; else echo $row['holdStock']; ?></td>
			                        <td><?php echo $sold; ?></td>
			                        <!--<td><?php if($row['availability']==1) echo '<span style="color:green;">Available</span>'; else echo '<span style="color:red;">Unavailable</span>'; ?></td>-->
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                        </form>
						<br clear="all"/>
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
