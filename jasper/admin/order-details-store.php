<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$editId	= $_GET["id"];

$products	= "";
$rslt			= mysqli_query($con,"SELECT t1.*,t2.*,t3.productName,t3.productId,t4.*
FROM tbl_orders t1
LEFT JOIN tbl_order_items t2
ON  t1.orderNo=t2.fkOrderNumber
LEFT JOIN tbl_products t3
ON t2.productId=t3.productId
lEFT JOIN tbl_customers t4 
ON t1.fkCustomer=t4.email
WHERE t1.orderNo='".$editId."'
");
while($row=mysqli_fetch_array($rslt))
{
	$orderAmount=$row["orderAmount"];
	$shipTo=$row["billingAddress"];
	$shipTo = str_replace("\n", "", $shipTo);
	$shipTo = str_replace("\r", "", $shipTo);
	$shipTo=preg_replace("/(<br\ ?\/?>)(<br\ ?\/?>)+/", "<br />", $shipTo);
	$orderDate	= date('d M Y', strtotime($row["orderDate"]));
	$options="";
	$rslt1=mysqli_query($con,"SELECT t3.fkOptionValue FROM tbl_product_options_value t3 WHERE t3.id='".$row["productOptions"]."'");
	if(mysqli_num_rows($rslt1)>0)
	{
		$row1=mysqli_fetch_assoc($rslt1);
		$fkOptionValue=$row1["fkOptionValue"];
		$rslt1=mysqli_query($con,"select * from tbl_option_values where id IN($fkOptionValue)");
		while($row1=mysqli_fetch_assoc($rslt1))
		{
			$options.=$row1["optionValue"]." ";
		}
	}
	
	$products	.= '<a href="edit-product.php?id='.$row["productId"].'">'.$row["productName"]." ".$options.'</a>'."\n";
	$customer = $row['firstName']." ".$row['lastName'];
	$custId	= $row["customerId"];
	$userEmail= $row["email"];
	$custContact= $row["contactNumber"];
	$invoice=$row["invoice"];
	$pStatus=$row["paymentStatus"];
	$orderStatus=$row["orderStatus"];
if($row["paymentStatus"]==1)
	$paymentStatus='<span style="color:green;">Paid</span>';
else{ 
	//if($row["paymentMethod"]=="Cash on Delivery")
	if (strpos($row["paymentMethod"], 'Cash on Delivery') !== false)
		$paymentStatus='<span style="color:orange;">Cash on Delivery</span>'; 
	else 
		$paymentStatus='<span style="color:red;">Unpaid</span>';
	}
}
$products=nl2br($products);

$orderNote = "";
$trackingId="";
$trackingStatus="";
$rslt=mysqli_query($con,"SELECT * FROM `tbl_order_status` t1,tbl_tracking_status t2 WHERE t1.fkOrderNo='".$editId."' and t1.activeStatus=1 and t1.fkTrackingId=t2.id");
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_assoc($rslt);
$trackingId=$row["fkTrackingId"];
$orderNote=$row["orderNote"];
$trackingStatus=$row["trackingStatus"];
}

$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$editId."' and gateway='Families Club Card'");
$fccAmount=0;
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_assoc($rslt);
$fccAmount=$row["transactionAmount"];
}

// new user submit
if(isset($_POST["submit"]))
{
	$trackingId 	= mysqli_real_escape_string($con,$_POST["orderStatus"]);
	$orderNote	= mysqli_real_escape_string($con,$_POST["orderNote"]);
	$date= date('Y-m-d');
	// Check whether the status is already there
	$rslt=mysqli_query($con,"select * from tbl_order_status where fkTrackingId='".$trackingId."' and fkOrderNO='".$editId."'");
	if(mysqli_num_rows($rslt)>0) 
	{
		$id=$row["id"];
		mysqli_query($con,"update tbl_order_status set activeStatus='0' where fkOrderNO='".$editId."'");
		mysqli_query($con,"update tbl_order_status set orderNote='".$orderNote."',statusDate=NOW(),activeStatus='1' where id='".$id."'");
	}
	else
	{	
		mysqli_query($con,"update tbl_order_status set activeStatus='0' where fkOrderNO='".$editId."'");		
		mysqli_query($con,"insert into tbl_order_status (fkOrderNO,fkTrackingId,orderNote,activeStatus,statusDate) values('".$editId."','".$trackingId."','".$orderNote."','1',NOW())") or die(mysqli_error($con));				
	}
	if($trackingId==4)
	{
		mysqli_query($con,"update tbl_orders set paymentStatus=1,deliveryDate=NOW() where orderNo='".$editId."'");
		$orderId=$editId;
		if($pStatus!=1)
		{
			$transactionId=gen_random_string();
		mysqli_query($con,"update tbl_transaction set gateway='Cash on Delivery',transactionId='".$transactionId."',transactionDate=NOW(),paymentStatus='Completed' where fkOrderId='".$editId."' and gateway IS NULL") or die(mysqli_error($con));
		}
		/*require "get-order-details.php";
			
			$clientName	= $customer;
			
			$rslt=mysqli_query($con,"select templateId,adminMail from tbl_mail_actions where mailAction='Shipping Confirmation'") or die(mysqli_error($con));
			$row=mysqli_fetch_assoc($rslt);
			$templateId=$row["templateId"];
			$cc=$row["adminMail"];
		
			$rslt=mysqli_query($con,"select * from tbl_mails where id='".$templateId."'");
			if(mysqli_num_rows($rslt)>0)
			{
				$row=mysqli_fetch_assoc($rslt);
				$emailFrom=$row["emailFrom"];
				$body=$row["body"];
				$subject=$row["subject"];
				$signature=$row["signature"];
				$subject=str_replace( 
					array('{{$i.order_id}}', '{{$c.full_name}}','{{$i.order_details}}','{{$i.order_address}}','{{$i.order_total}}','{{$i.order_payment_method}}'),  
					array($orderId, $clientName,$productDetails,$orderAddress,$orderTotal,$orderPaymentMethod),
					$subject );
				$body = str_replace( 
					array('{{$i.order_id}}', '{{$c.full_name}}','{{$i.order_details}}','{{$i.order_address}}','{{$i.order_total}}','{{$i.order_payment_method}}'),  
					array($orderId, $clientName,$productDetails,$orderAddress,$orderTotal,$orderPaymentMethod),
					$body );
				require 'mail.php';
				mysqli_query($con,"insert into tbl_email_logs (mailType,sentDate,mailBody,mailTo) values('Order Confirmation',NOW(),'$body','$userEmail')");
			}*/
	}
	echo "<script>location.href = 'index-store.php'</script>";
}


//cancel order
if(isset($_POST["delete"]))
{
	//mysqli_query($con,"delete from tbl_order_items where fkOrderNumber='".$editId."'");
	mysqli_query($con,"update tbl_orders set orderStatus=0,paymentStatus=0 where orderNo='".$editId."'");
	if($pStatus==1)
	{
		$refund=$orderAmount;
		$rslt=mysqli_query($con,"select * from tbl_customer_vouchers where fkCustomer='".$userEmail."'");
		if(mysqli_num_rows($rslt)>0)				
			mysqli_query($con,"update tbl_customer_vouchers set balanceAmount=(balanceAmount+".$refund.") where fkCustomer='".$userEmail."'");			
		else
			mysqli_query($con,"insert into tbl_customer_vouchers (fkCustomer,total,balanceAmount) values('".$userEmail."','".$refund."','".$refund."')");
		mysqli_query($con,"insert into tbl_customer_voucher_history (fkCustomer,date,amount,remarks,orderNo) values('".$userEmail."',NOW(),'".$refund."','Refund','".$editId."')");		
	}
	else
	{
		if($fccAmount>0)
		{
			$refund=$fccAmount;
			mysqli_query($con,"update tbl_customer_vouchers set balanceAmount=(balanceAmount+".$refund.") where fkCustomer='".$userEmail."'");
			mysqli_query($con,"insert into tbl_customer_voucher_history (fkCustomer,date,amount,remarks,orderNo) values('".$userEmail."',NOW(),'".$refund."','Refund','".$editId."')");		
		}
	}
	echo "<script>location.href = 'index-store.php'</script>";
}

// delete item from order list
if(isset($_POST["delete-item"]))
{	
	$rslt=mysqli_query($con,"select total from tbl_order_items where id='".$_POST["delete-item"]."' and fkOrderNumber='".$editId."'");
	$row=mysqli_fetch_assoc($rslt);
	$total=$row["total"];
	mysqli_query($con,"delete from tbl_order_items where id='".$_POST["delete-item"]."' and fkOrderNumber='".$editId."'");
	mysqli_query($con,"update tbl_orders set orderAmount=(orderAmount-$total) where orderNo='".$editId."'");
	if($fccAmount>($orderAmount-$total))
	{
		$refund=$fccAmount-($orderAmount-$total);
		if($pStatus==1)
			$refund=$total;
		//mysqli_query($con,"update tbl_transaction set transactionAmount='".($fccAmount-$refund)."' where fkOrderId='".$editId."' and gateway='Families Club Card'");
		mysqli_query($con,"update tbl_customer_vouchers set balanceAmount=(balanceAmount+".$refund.") where fkCustomer='".$userEmail."'");
		if($pStatus!=1){
		mysqli_query($con,"delete from tbl_transaction where fkOrderId='".$editId."' and gateway is null");
		mysqli_query($con,"update tbl_orders set paymentStatus=1 where orderNo='".$editId."'");
		}
		mysqli_query($con,"update tbl_transaction set transactionAmount=(transactionAmount-".$refund.") where gateway='Families Club Card' and fkOrderId='".$editId."'") or die(mysqli_error($con));
		mysqli_query($con,"insert into tbl_customer_voucher_history (fkCustomer,date,amount,remarks,orderNo) values('".$userEmail."',NOW(),'".$refund."','Refund','".$editId."')");		
	}
	else{
		if($pStatus==1)
		{
			$refund=$total;
			$rslt=mysqli_query($con,"select * from tbl_customer_vouchers where fkCustomer='".$userEmail."'");
			if(mysqli_num_rows($rslt)>0)				
				mysqli_query($con,"update tbl_customer_vouchers set balanceAmount=(balanceAmount+".$refund.") where fkCustomer='".$userEmail."'");			
			else
				mysqli_query($con,"insert into tbl_customer_vouchers (fkCustomer,total,balanceAmount) values('".$userEmail."','".$refund."','".$refund."')");
			mysqli_query($con,"insert into tbl_customer_voucher_history (fkCustomer,date,amount,remarks,orderNo) values('".$userEmail."',NOW(),'".$refund."','Refund','".$editId."')");		
		mysqli_query($con,"update tbl_transaction set transactionAmount=(transactionAmount-".$refund.") where gateway='Families Club Card' and fkOrderId='".$editId."'") or die(mysqli_error($con));
		}
	}
	echo "<script>location.href = 'order-details.php?id=".$editId."'</script>";
}

if(isset($_POST["send"]))
{
	$message=mysqli_real_escape_string($con,$_POST["message"]);
	mysqli_query($con,"insert into tbl_customer_notifications (customer,notification) values('".$userEmail."','".$message."')")or die(mysqli_error($con));
}


//to generate unique transaction id 
function gen_random_string()
{
	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
    $final_rand='';
    for($i=0;$i<15; $i++)
    {
        $final_rand .= $chars[ rand(0,strlen($chars)-1)];
    }
	$rslt=mysqli_query($con,"select * from tbl_transaction where transactionId='".$final_rand."'");
	if(mysqli_num_rows($rslt)>0)
	{
		gen_random_string();
	}
	else
	{
	return $final_rand;
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
<style>
.form-actions{
	padding:4px 16px 0px;
}
body{
	background:none;
}
</style>
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
		<?php //include_once('side-bar.php'); ?>
		<!-- /sidebar -->


		<!-- Content -->
		<div id="content">

		    <!-- Content wrapper -->
		    <div class="wrapper">

			    <!-- Breadcrumbs line -->
			    <?php //include_once('bread-crumbs.php'); ?>
			    <!-- /breadcrumbs line -->

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->


	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Order Details</h6>
                            
                            </div></div>
                            <div class="well row-fluid">
                            
                            		<div class="well-smoke body">
									<div class="span5">
                                        <dl class="dl-horizontal" style="margin-left:33px;">
                                            <dt>Order Number :</dt>
                                            <dd><?php echo $editId;?></dd>
                                           
                                            <dt>Order Date  :</dt>
                                            <dd><?php echo $orderDate;?></dd>
                                            <dt>Payment Status :</dt>
                                            <dd><?php echo $paymentStatus;?></dd>
											<dt>Order Status :</dt>
                                            <dd><?php echo $trackingStatus;?>&nbsp;</dd>
                                            <dt>Customer :</dt>
                                            <dd><a href="customer-details.php?id=<?php echo $custId;?>"><?php echo $customer;?></a></dd>
											<dt>Customer Contact # :</dt>
                                            <dd><?php echo $custContact;?></dd>
                                        </dl>
										<div class="control-group">
										<div class="controls" style="margin-left:25%;">
										<a href="invoice-pdf.php?id=<?php echo $editId;?>" style="float:left;" class="btn btn-info">View Invoice</a>
										<?php if($orderStatus==1 && $trackingId!=4 && $pStatus!=1){?>
										<form id="validate" class="form-horizontal" action="" method="post">
											<!--<button type="submit" style="float:left;" class="btn btn-info" value="markPaid" name="markPaid">Mark as Paid</button>-->
											<button type="submit" class="btn btn-danger" value="delete" name="delete">Cancel Order</button>
										</form>
										<?php }?>
										</div>
										<?php if($orderStatus==0){?><br clear="all"/><h4 style="color:red;">This order is cancelled <?php if($pStatus==1 || $fccAmount>0) echo "and amount is refunded"?></h4><?php }?>
										</div>
									</div>
									<div class="span4">
                                        <dl class="dl-horizontal" style="margin-left:33px;">
                                            <dt>Shipping Address :</dt>
                                            <dd><?php echo $shipTo;?></dd>                                            
                                        </dl>
									</div>
									<br clear="all"/>
                                    </div>                                
						<form id="validate" class="form-horizontal" action="" method="post">
								<table class="table table-striped table-bordered table-checks">
									<thead>
										<tr>
											<th>Sr.No.</th>
											<th>Product(s)</th>
											<th>Unit Price</th>
											<th>Qty</th>
											<th>Total (<?php echo $currency;?>)</th>
											<?php if($pStatus!=1){?><th class="align-center">Actions</th><?php }?>
										</tr>
									</thead>
									<tbody>
									<?php 
									$i=0;
									$rslt2=mysqli_query($con,"SELECT * FROM tbl_products,tbl_order_items where deleteStatus='0' and tbl_order_items.productId=tbl_products.productId and tbl_order_items.fkOrderNumber='".$editId."'") or die(mysqli_error($con));
									while($row2=mysqli_fetch_array($rslt2))
									{	
										$i++;
										$productId		= $row2["productId"];
										$productName	= $row2["productName"];
										$unitPrice		= $row2["unitPrice"];
										$quantity		= $row2["quantity"];
										$total			= $row2["total"];
										$discount		= $row2["discountAmount"];
										
										$options="";
										$rslt5=mysqli_query($con,"SELECT t3.fkOptionValue FROM tbl_product_options_value t3 WHERE t3.id='".$row2["productOptions"]."'");
										if(mysqli_num_rows($rslt5)>0)
										{
											$row5=mysqli_fetch_assoc($rslt5);
											$fkOptionValue=$row5["fkOptionValue"];
											$rslt5=mysqli_query($con,"select * from tbl_option_values where id IN($fkOptionValue)");
											while($row5=mysqli_fetch_assoc($rslt5))
											{
												$options.=$row5["optionValue"]." ";
											}
										}
																	
										$rslt4=mysqli_query($con,"select imageName from tbl_product_images where productId='".$productId."' and imageType='1'");
										$row4=mysqli_fetch_assoc($rslt4);
										$imageName=$row4["imageName"];
																
									?>
									<tr>
										<td><?php echo $i;?></td>
										<td><?php echo $productName." ".$options;;?></td>
										<td><?php echo $unitPrice;?></td>
										<td><?php echo $quantity;?></td>
										<td><?php echo $total;?></td>
										<?php if($pStatus!=1){?><td>
										<?php if(1){?>
											<ul class="navbar-icons">
												<!--<li><button type="button" data-toggle="modal" data-target="#exampleModal" title="Send Notification" value="<?php echo $row2['id'];?>" class="remove-button-icon" name="delete-item"><i class="icon-envelope-alt"></i></button></li>-->
												<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row2['id'];?>" class="remove-button-icon" name="delete-item"><i class="icon-remove"></i></button></li>
											</ul>
										<?php }else{echo "--";}?>
										</td><?php }?>
									</tr>
									<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="4" class="align-right">Total</th>
											<th colspan="2"><?php echo $currency." ".$orderAmount;?></th>
										</tr>
										<?php 
										if($fccAmount>0 && $pStatus!=1)
										{?>
										<tr>
											<th colspan="4" class="align-right">Amount Deducted From Families Club Card</th>
											<th colspan="2"><?php echo $currency." ".$fccAmount;?></th>
										</tr>
										
										<?php }
										?>
										<tr>
											<th colspan="4" class="align-right">Amount Payable</th>
											<th colspan="2"><?php if($pStatus!=1) echo $currency." ".($orderAmount-$fccAmount); else echo $currency." 0";?></th>
										</tr>
									</tfoot>
								</table>
								
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">                                    
                                    <label for="message-text" class="control-label">Message:</label>
                                    <textarea class="form-control span10" rows="5" name="message" id="message"></textarea>                                    
                                  </div>
                                  <div class="form-group">
                                  </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="send" id="save" class="btn btn-info">Send</button>
                              </div>    
                              </div>
                              
                            </div>
                          </div>
                        </div>
						
                               <div class="control-group">
	                                <label class="control-label">Status: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="orderStatus" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Status</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT * FROM tbl_tracking_status order by displayOrder asc");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>" <?php if($trackingId==$row["id"]) echo "selected"; ?>><?php echo $row["trackingStatus"];?></option>
                                            <?php } ?>                                           
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Note</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="orderNote" class="validate[] span12"><?php echo $orderNote; ?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <div class="controls">
										<button type="submit" class="btn btn-info" value="submit" name="submit">Save</button>
									</div>								
								</div>
								
								
							</form>								
	                        </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->

				<!-- form submition - add new user-->                
				<?php
				?>  
				<!-- /form submition -->                              
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
})
</script>
</body>
</html>
