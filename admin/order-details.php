<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$order_id	= $_GET["id"];

$rslt=mysqli_query($con,"select * from tbl_orders t1,tbl_customers t2 where t1.user_id=t2.customer_id and t1.order_id='".$order_id."' order by id desc");
$row=mysqli_fetch_array($rslt);

$order_amount=$row["order_amount"];
$currency=$row["order_currency"];
$order_discount=$row["order_discount"];
$coupon=$row["coupon"];
$order_date	= date('d M Y', strtotime($row["order_date"]));
$delivery_date	= date('d M Y', strtotime($row["delivery_date"]));
$billing_address=json_decode($row["billing_address"], TRUE);
$shipping_address=json_decode($row["shipping_address"], TRUE);
$order_items=json_decode($row["order_items"], TRUE);
$customer = $row['first_name']." ".$row['last_name'];
$customer_contact	= $row["phone"];
$custId	= $row["customer_id"];
if(!empty($row["delivery_status"]))
	$delivery_status		= json_decode($row["delivery_status"],TRUE);
else
	$delivery_status		= array();

$payment_method=$row["payment_method"];
$payment_status=$row["payment_status"];
$order_status=$row["order_status"];
if($row["payment_status"]==1)
	$payment_status='<span style="color:green;">Paid</span><br>'.$payment_method;
else{ 
	//if($row["paymentMethod"]=="Cash on Delivery")
	if (strpos($row["payment_method"], 'Cash on Delivery') !== false)
		$payment_status='<span style="color:orange;">Cash on Delivery</span>'; 
	else 
		$payment_status='<span style="color:red;">Unpaid</span>';
	}



$orderNote = "";
$trackingId="";
$trackingStatus="";
$rslt=mysqli_query($con,"SELECT * FROM `tbl_order_status` t1,tbl_tracking_status t2 WHERE t1.fkOrderNo='".$order_id."' and t1.activeStatus=1 and t1.fkTrackingId=t2.id");
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_assoc($rslt);
$trackingId=$row["fkTrackingId"];
$orderNote=$row["orderNote"];
$trackingStatus=$row["trackingStatus"];
}

$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$order_id."' and gateway='Families Club Card'");
$fccAmount=0;
if(mysqli_num_rows($rslt)>0)
{
$row=mysqli_fetch_assoc($rslt);
$fccAmount=$row["transactionAmount"];
}

// new user submit
if(isset($_POST["submit"]))
{
	$tracking_status 	= mysqli_real_escape_string($con,$_POST["delivery_status"]);
	$orderNote	= mysqli_real_escape_string($con,$_POST["orderNote"]);
	$date= date('Y-m-d');
	
	if(!empty($delivery_status))
		$key=max(array_keys($delivery_status))+1;
	else
		$key=0;
	
	$delivery_status[$key]["status"]=$tracking_status;
	$delivery_status[$key]["note"]=$orderNote;
	$delivery_status[$key]["date"]=$date;
	$delivery_status_json=json_encode($delivery_status);
	mysqli_query($con,"update tbl_orders set delivery_status='".$delivery_status_json."' where order_id='".$order_id."'") or die(mysqli_error($con));
	
	if($tracking_status=="Delivered")
	{
		mysqli_query($con,"update tbl_orders set payment_status=1 where order_id='".$order_id."'");
		$orderId=$order_id;
		if($payment_status!=1)
		{
			$transactionId=gen_random_string();
			mysqli_query($con,"update tbl_transaction set gateway='Cash on Delivery',transactionId='".$transactionId."',transactionDate=NOW(),paymentStatus='Completed' where fkOrderId='".$order_id."' and gateway IS NULL") or die(mysqli_error($con));
		}		
	}
	echo "<script>location.href = 'order-list.php'</script>";exit();
}

//cancel order
if(isset($_POST["delete"]))
{
	//mysqli_query($con,"delete from tbl_order_items where fkOrderNumber='".$order_id."'");
	mysqli_query($con,"update tbl_orders set order_status=0,paymentStatus=0 where orderNo='".$order_id."'");
	if($payment_status==1)
	{
		$refund=$order_amount;
		$rslt=mysqli_query($con,"select * from tbl_customer_vouchers where fkCustomer='".$userEmail."'");
		if(mysqli_num_rows($rslt)>0)				
			mysqli_query($con,"update tbl_customer_vouchers set balanceAmount=(balanceAmount+".$refund.") where fkCustomer='".$userEmail."'");			
		else
			mysqli_query($con,"insert into tbl_customer_vouchers (fkCustomer,total,balanceAmount) values('".$userEmail."','".$refund."','".$refund."')");
		mysqli_query($con,"insert into tbl_customer_voucher_history (fkCustomer,date,amount,remarks,orderNo) values('".$userEmail."',NOW(),'".$refund."','Refund','".$order_id."')");		
	}
	else
	{
		
	}
	echo "<script>location.href = 'order-list.php'</script>";
}

//to generate unique transaction id 
function gen_random_string()
{
	$chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";//length:36
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


	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Order Details</h6>
                            
                            </div></div>
                            <div class="well row-fluid">                            
                            	<div class="well-smoke body">
									<div class="span12">
										<?php if($order_status==0){?><br clear="all"/><h4 style="color:red;">This order is cancelled <?php if($payment_status==1) echo "and amount is refunded"?></h4><?php }?>
										<a href="view-invoice.php?id=<?php echo $order_id;?>" class="btn btn-info pull-right">View Invoice</a>
										<?php if($order_status==1 && $trackingId!=4){?>
										<form id="validate" class="form-horizontal pull-right" action="" method="post">
											<!--<button type="submit" style="float:left;" class="btn btn-info" value="markPaid" name="markPaid">Mark as Paid</button>-->
											<button type="submit" class="btn btn-danger" value="delete" name="delete">Cancel Order</button>
										</form>
										<?php }?>										
									</div>									<br clear="all"/>

								</div>
							</div>
							<div class="well row-fluid">                            
                            	<div class="well-smoke body">
									<div class="span6">
									<h5>Order Details</h5>
									<table class="table">
										<tbody>
											<tr>
												<th>Order Number</th>
												<th><?php echo $order_id;?></th>
											</tr>
											<tr>
												<th>Order Date</th>
												<th><?php echo $order_date;?></th>
											</tr>
											<tr>
												<th>Order Amount</th>
												<th><?php echo $order_amount;?></th>
											</tr>
											<tr>
												<th>Payment Status</th>
												<th><?php echo $payment_status?></th>
											</tr>
											<tr>
												<th>Delivery Date</th>
												<th><?php echo $delivery_date;?></th>
											</tr>
											<tr>
												<th>Delivery Status</th>
												<th><?php if(!empty($delivery_status)){
													$key=max(array_keys($delivery_status));
													echo $delivery_status[$key]["status"]." - ".date('d M Y',strtotime($delivery_status[$key]["date"]));
												} ;?></th>
											</tr>
											<tr>
												<th>Customer</th>
												<th><?php echo $customer;?></th>
											</tr>
											<tr>
												<th>Customer Contact #</th>
												<th><?php echo $customer_contact;?></th>
											</tr>
										</tbody>
									</table>
                                    </div>
									<div class="span3">
										<h5>Billing Address</h5>
										<?php foreach($billing_address as $key=>$value){
											echo ucwords(str_replace('_',' ',$key))." - <strong>".$value."</strong><br>";
										}?>
									</div>
									<div class="span3">
										<h5>Shipping Address</h5>
										<?php foreach($shipping_address as $key=>$value){
											echo ucwords(str_replace('_',' ',$key))." - <strong>".$value."</strong><br>";
										}?>
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
											<th>Subtotal</th>
											<!--<th class="align-center">Actions</th>-->
										</tr>
									</thead>
									<tbody>
									<?php 
									$i=0;
									foreach($order_items as $key=>$value)
                                    {	
										$i++;
										$product_name		= $value["product_name"];
										$sale_price		= $value["sale_price"];
										$quantity		= $value["quantity"];
										$total			= $sale_price*$quantity;
										
										$options="";
										if(!empty($value["option"])) 
											$options=$value["option"];
																
									?>
									<tr>
										<td><?php echo $i;?></td>
										<td><?php echo $product_name." ".$options;;?></td>
										<td><?php echo $currency." ".$sale_price;?></td>
										<td><?php echo $quantity;?></td>
										<td><?php echo $currency." ".$total;?></td>
										<!--<td>
										<?php if(0){?>
											<ul class="navbar-icons">
												
												<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row2['id'];?>" class="remove-button-icon" name="delete-item"><i class="icon-remove"></i></button></li>
											</ul>
										<?php }else{echo "--";}?>
										</td>-->
									</tr>
									<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="4" class="align-right">Total</th>
											<th colspan="2"><?php echo $currency." ".$order_amount;?></th>
										</tr>
										<tr>
											<th colspan="4" class="align-right">Discount<br><?php if(!empty($coupon)) echo '(Coupon : '.$coupon.')';?></th>
											<th colspan="2"><?php echo $currency." ".$order_discount;?><br><?php if(!empty($coupon)) echo '(Coupon : '.$coupon.')';?></th>
										</tr>										
										<tr>
											<th colspan="4" class="align-right">Amount Payable</th>
											<th colspan="2"><?php if($payment_status!=1) echo $currency." ".($order_amount-$order_discount); else echo $currency." 0";?></th>
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
	                                    <select name="delivery_status" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Status</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT * FROM tbl_tracking_status order by displayOrder asc");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["trackingStatus"];?>" <?php if($trackingId==$row["id"]) echo "selected"; ?>><?php echo $row["trackingStatus"];?></option>
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
