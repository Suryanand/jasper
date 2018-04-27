<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
if(isset($_SERVER['HTTP_REFERER']))
{
$previousPage = strtok(basename($_SERVER['HTTP_REFERER']),'?');
}
$orderId=$_GET["id"];

//get company profile
$rslt=mysqli_query($con,"select * from tbl_company");
$row=mysqli_fetch_array($rslt);
$companyDetails =	nl2br($row["companyName"]."\n".
					$row["companyAddress"]);

 
$rslt=mysqli_query($con,"SELECT t1.*,t2.customerId,t2.firstName FROM tbl_orders t1,tbl_customers t2 WHERE t1.orderNo='".$orderId."' and t1.fkCustomer=t2.email");
$row=mysqli_fetch_array($rslt);
$billingAddress=$row["billingAddress"];
$shippingCharge=$row["shippingCharge"];
$paymentStatus=$row["paymentStatus"];
$cId=$row["customerId"];
$invoiceGen=$row["invoice"];
$orderDiscount=$row["orderDiscount"];
$clientName=$row["firstName"];
$userEmail=$row["fkCustomer"];
$orderStatus=$row["orderStatus"];
// new item submit
if(isset($_POST["submit"]))
{
	$description = mysqli_real_escape_string($con,$_POST["description"]);
	$amount = mysqli_real_escape_string($con,$_POST["amount"]);
	mysqli_query($con,"insert into tbl_invoice_items (itemDescription,itemAmount,itemInvoiceId) values ('$description','$amount','$invoiceNo')") or die(mysqli_error($con));
		
}

// update invoice
if(isset($_POST["submit-invoice"]))
{
	$billingAmount=$_POST["subTotal"];
	$orderDiscount=$_POST["discount"];
	$shippingCharge=$_POST["shippingCharge"];
	//$invoiceNote=$_POST["invoiceNote"];
	$billingAddress=nl2br($_POST['invoiceTo']);
	$invoiceDate=date('Y-m-d');

	mysqli_query($con,"update tbl_orders set orderAmount='$billingAmount',orderDate='$invoiceDate',shippingCharge='".$shippingCharge."',invoice='3',billingAddress='$billingAddress',orderDiscount='".$orderDiscount."' where orderNo='$orderId'");
	$_SESSION["response"]="Invoice Generated";
	
	require "get-order-details.php";
	$rslt=mysqli_query($con,"select templateId,adminMail from tbl_mail_actions where mailAction='Generate Invoice'") or die(mysqli_error($con));
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
				mysqli_query($con,"insert into tbl_email_logs (mailType,sentDate,mailBody,mailTo) values('International Order Invoice Generated',NOW(),'$body','$userEmail')");
			}
	
	echo "<script>location.href = 'customer-details.php?id=$cId'</script>";		
}


// archive/restore invoice
if(isset($_POST["new-product"]))
{
	$prodId=$_POST["productId"];
	$options="";
	$quantity=$_POST["quantity"];
	$price=$_POST["price"];
	$OptionValueId="";
	if(isset($_POST["options"]))
	{
		$qry="";
		$options=implode(',',$_POST["options"]);
		foreach($_POST["options"] as $opVal)
		{
			$qry.=" and FIND_IN_SET('".$opVal."',fkOptionValue)";
		}
		$rslt=mysqli_query($con,"SELECT * FROM tbl_product_options_value WHERE fkProductId='".$prodId."'".$qry);
		$rows=mysqli_fetch_array($rslt);
		$OptionValueId=$rows["id"];
	}
	
	$total=$quantity*$price;
	$couponAmount=0;
	$coupon="";
		
	mysqli_query($con,"insert into tbl_order_items (fkOrderNumber,productId,productOptions,unitPrice,quantity,total,couponCode,discountAmount) values('".$orderId."','".$prodId."','".$OptionValueId."','".$price."','".$quantity."','".$total."','".$coupon."','".$couponAmount."')");
	//mysqli_query($con,"update tbl_orders set orderAmount=(orderAmount+$total) where orderNo='".$orderId."'");
	echo "<script>location.href = 'view-invoice.php?id=$orderId'</script>";			
}
if(isset($_POST["delete"]))
{
	mysqli_query($con,"delete from tbl_order_items where id='".$_POST["delete"]."'");
}
$fccAmount=0;
$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$orderId."' and gateway='Families Club Card'");
if(mysqli_num_rows($rslt)>0 && $paymentStatus!=1)
{
	$row=mysqli_fetch_assoc($rslt);
	$fccAmount=$row["transactionAmount"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo $title; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css"/><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>
<style>
thead{
	border-bottom:1.5px dashed;
}
tr{
	height:35px;
	border-bottom:1px dashed;
}
.ui-datepicker-append
{
	display:none;
}
</style>
<script>
function getTotal()
{
	var flag=0;
	var total=0;
		fields="shippingCharge";
		if(isNaN(parseFloat(document.getElementById(fields).value)))
		{
			document.getElementById(fields).value=0;
			flag=1;
		}
		else
		{
		total=total+parseFloat(document.getElementById(fields).value)+parseFloat(document.getElementById("subTotal").value);
		}

		var grandTotal=total;
		if(isNaN(parseFloat(document.getElementById("discount").value)))
		{
			document.getElementById("discount").value=0;
			flag=1;
		}
		else
		{
			grandTotal=total-parseFloat(document.getElementById("discount").value);		
		}

	if(flag==1)
	{
		alert("Only Numeric Allowed");
	}
	document.getElementById("total").value=grandTotal;
}

function clickMe(id)
{
var r=confirm("Are you sure, You want to delete?");
if(r==true)
  { 
  var x=id;
   $.ajax({
 type: "POST",
 url: "ajx-remove-item.php",
 data: {itemId:x},
 success: function(data) {
    }
 });
	 return true;
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
                <h5><?php if($paymentStatus==0) echo '<span style="color:red;">UNPAID</span>'; else echo '<span style="color:green;">PAID</span>'; ?></h5>
				<?php if($orderStatus==0){?><br clear="all"/><h4 style="color:red;">This order is cancelled <?php if($paymentStatus==1 || $fccAmount>0) echo "and amount is refunded"?></h4><?php }?>
				<div class="widget">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
                <div class="row-fluid">
                	<div class="span4"><h4>Invoice To</h4>
                    	<textarea readonly class="span6" rows="5" name="invoiceTo" id="invoiceTo"><?php echo strip_tags($billingAddress); ?></textarea>
						&nbsp;<i class="ico-pencil edit" style="cursor:pointer;" onClick="editAddress()"></i>
                    </div>
                	<div class="span4"><h4>Invoice Details</h4>
                    	<?php echo nl2br("Invoice # ".$orderId."\n"."Invoice Date : ".date('d-M-y')."\n");?>
                    </div>
                    
                    
                	<div class="span4"><h4>Pay To</h4>
                    	<?php echo $companyDetails; ?>
                    </div>
                </div>

                <div class="row-fluid"> 
                <br clear="all"/>
                <h6>Invoice Items</h6>
	            <table style="width:100%">
                    <thead>
                    <tr>
                    	<th align="left" width="5%">#</th>
                        <th align="left" width="50%">Description</th>
                        <th align="left" width="15%">Quantity</th>
                        <th align="left" width="15%">Unit Price</th>
                        <th align="right" width="15%">Amount (<?php echo $currency; ?>)</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					$i=0;
					$rslt=mysqli_query($con,"SELECT t2.id as itemId,t1.*,t2.*,t3.productName
															FROM tbl_orders t1
															LEFT JOIN tbl_order_items t2
															ON  t1.orderNo=t2.fkOrderNumber
															LEFT JOIN tbl_products t3
															ON t2.productId=t3.productId
															WHERE t1.orderNo='".$orderId."'");
					$options="";
					$subTotal=0;
					while($row=mysqli_fetch_assoc($rslt))
					{
						$i++;
						$rslt1=mysqli_query($con,"SELECT t3.fkOptionValue FROM tbl_product_options_value t3 WHERE t3.id='".$row["productOptions"]."'");
						if(mysqli_num_rows($rslt1)>0)
						{
							$row1=mysqli_fetch_assoc($rslt1);
							$fkOptionValue=$row1["fkOptionValue"];							if(!empty($fkOptionValue))
							{
							$rslt1=mysqli_query($con,"select * from tbl_option_values where id IN($fkOptionValue)");
							while($row1=mysqli_fetch_assoc($rslt1))
							{
								$options.=$row1["optionValue"]." ";
							}
							}
						}
						$subTotal+=($row["quantity"]*$row["unitPrice"]);
						$grandTotal=$row["orderAmount"];
					?>
                    <tr>
                    	<td><?php echo $i;?></td>
                        <td><?php echo $row["productName"]." ".$options;?></td>
                        <td><?php echo $row["quantity"];?></td>
                        <td><?php echo $row["unitPrice"];?></td>
                        <td align="right"><?php echo $row["total"];?></td>
						<td>
						<ul class="navbar-icons">
						<li>
							<button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['itemId'];?>" class="remove-button-icon" name="delete">
							<i class="icon-remove"></i></button>
						</li>
						</ul>
						</td>
                    </tr>
					<?php }?>

                    <tr style="border-bottom:none;">
						<td></td>
                    	<td>
							<?php if($paymentStatus==0 && $invoiceGen!=1)
							{?>
							<button type="button" onClick="addProduct()" class="btn btn-info add-product">Add Product</button>
							<?php }?>
						</td>
                    </tr><br clear=""/>
                    
					<tr style="border-bottom:none;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Sub Total</td>
                        <td align="right">  <input type="text" readonly value="<?php echo $subTotal;?>" class="validate[custom[number]] input-medium align-right" name="subTotal" id="subTotal" /></td>
                    </tr>
					
					<tr style="border-bottom:none;">
                    	<td></td>
						<td></td>
					    <td></td>
						<td>Shipping Charge</td>
                        <td align="right"><input type="text" value="<?php if(!empty($shippingCharge)) echo $shippingCharge; else echo "0";?>" class="validate[] input-medium align-right" onKeyUp="getTotal()" placeholder="" name="shippingCharge" id="shippingCharge"/></td>
                    </tr><br clear=""/>

                    
                    <tr style="border-bottom:none;">
                    	<td></td>
                    	<td></td>
                    	<td></td>
                        <td>Discount</td>
                        <td align="right"><input type="text" value="<?php echo $orderDiscount;?>" onKeyUp="getTotal()" class="validate[custom[number]] input-medium align-right" name="discount" id="discount" /></td>
                    </tr>
					<?php 
					if($fccAmount>0)
					{?>
					<tr style="border-bottom:none;">
                    	<td></td>
                    	<td></td>
                    	<td></td>
                        <td>Amount Deducted From Families Club Card</td>
                        <td align="right"><input type="text" readonly value="<?php echo $fccAmount;?>" class="input-medium align-right" name="fcc" id="fcc" /></td>
                    </tr>	
					<?php }
					?>
					
                    <tr style="border-bottom:none;">
                    	<td></td>
                    	<td><!--<textarea class="span8" rows="5" name="invoiceNote" placeholder="Notes"></textarea>--></td>
                    	<td></td>
                    	<td>Total</td>
                        <td align="right"><input type="text" readonly  value="<?php echo ($subTotal+$shippingCharge-$orderDiscount-$fccAmount);?>" class="validate[custom[number]] input-medium align-right" name="total" id="total" /></td>
                    </tr>			  
                    </tbody>
                </table>
                <br clear="all" />
				<?php if($paymentStatus==0 && $invoiceGen!=1)
				{?>
				   	<button type="submit" class="btn btn-info" style="margin-right:50px;float:right;" name="submit-invoice"><?php if($invoiceGen==3) echo "Update Invoice"; else echo "Generate Invoice";?></button>
				<?php }?>
				
				<?php 
				if($paymentStatus!=1)
					$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$orderId."' and gateway='Families Club Card'");
				else
					$rslt=mysqli_query($con,"select * from tbl_transaction where fkOrderId='".$orderId."'");
				$i=0;
				if(mysqli_num_rows($rslt)>0)
				{				
				?>
				<h5>Transactions</h5>
                <table style="width:100%">
                	<thead>
                    <tr>
                    	<th>#</th>
                    	<th>Transaction Date</th>
                    	<th>Gateway</th>
                    	<th>Transaction ID</th>
                    	<th>Amount (<?php echo $currency; ?>)</th>
                    </tr>
                    </thead>
                	<tbody>
					<?php 
					while($row=mysqli_fetch_assoc($rslt))
					{
						$i++;
					?>
                    <tr>
                    	<td><?php echo $i;?></td>
                    	<td align="center"><?php echo $row["transactionDate"];?></td>
                    	<td align="center"><?php echo $row["gateway"];?></td>
                    	<td align="center"><?php echo $row["transactionId"];?></td>
                    	<td align="center"><?php echo $row["transactionAmount"];?></td>
                    </tr>
					<?php }?>
                    </tbody>
                </table>
				<?php }?>
                <br clear="all" />
				<?php if($orderStatus==1){?><a href="invoice-pdf.php?id=<?php echo $orderId;?>" class="btn btn-info" style="margin-right:50px;float:right;" name="submit-invoice">Download</a><?php }?>
                </div>
                </form>
				
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">New Product</h4>
                              </div>
                              <div class="modal-body">
                                <form action="" method="post">
                                  <div class="form-group">
                                    <label for="recipient-name" class="control-label">Product:</label>
                                    <select name="productId" id="productId" onChange="getOption(this.value)" class="validate[] input-large" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Product</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT t1.productId,t1.productName FROM tbl_products t1 where deleteStatus='0'");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
													<option value="<?php echo $row["productId"];?>"><?php echo $row["productName"];?></option>
                                            <?php }?>                                           
	                                    </select>
									<div class="options"></div>
									<label for="recipient-name" class="control-label">Unit Price:</label>
                                    <input type="text" readonly value=""  maxlength="65" class="validate[] input-large" name="price" id="price"/>									
									<label for="recipient-name"  class="control-label">Quantity:</label>
									<input type="number" value="1" min="1"  maxlength="65" class="validate[] input-large" name="quantity" id="quantity"/>
                                  </div>
                                  <div class="form-group">
                                    
                                  </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" name="new-product" id="save" class="btn btn-info">Save</button>
                              </div>    
                                </form>
                              </div>
                              
                            </div>
                          </div>
                        </div>
				
					<?php if(isset($_SESSION["paidDate-err"]))
						{
							echo "<script>alert('".$_SESSION["paidDate-err"]."');</script>";
							unset($_SESSION["paidDate-err"]);
						}
                        ?>                
	                    </div>

                	</div>

                	
                </div>



		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
<?php 
if(isset($_SESSION["response"]))
{
	echo "<script>alert('".$_SESSION["response"]."');</script>";
	unset($_SESSION["response"]);
}
?>

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
	<script type="text/javascript">	
	CKEDITOR.replace('specification');
		function editAddress()
	{
		if ( $('#invoiceTo').is('[readonly]') )
		{
		$("#invoiceTo").prop('readonly', false);
		}
		else{
		$("#invoiceTo").prop('readonly', true);			
		}
	}
		function editDate()
	{
		if ( $('#dueDate').is('[readonly]') )
		{
		$("#dueDate").prop('readonly', false);
		}
		else{
		$("#dueDate").prop('readonly', true);			
		}
	}
	
	function addProduct() {
    $('#exampleModal').modal('show');	
}


function getOption(pId)
{
	$.ajax({
				 type: "POST",
				 url: "ajx-options.php",
				 data: {pId:pId},
				 success: function(data) {
					 //alert(data);
				 $(".options").html(data);
				},
				error: function(x,a,y){ //add this error function
				alert(JSON.stringify(x)+" "+a);
				}
			});
}

function changeOption(optionValue)
{
	$("#overlay").show();
	var id="";
	var productOptions="";
	var productId=$("#productId").val();
	$('select[name="options[]"]').each(function(){
        id += $(this).val()+",";
    });
	$('input:hidden[name="productOptions[]"]').each(function(){
        productOptions += $(this).val()+",";
    });
	$.ajax({
			 type: "POST",
			 url: "ajx-options.php",
			 data: {productId:productId,optionValues:id,productOptions:productOptions,optionValue:optionValue},
			 dataType: 'json',
			 success: function(data) {
				//alert(data);				
				//alert(data["qr"]);				
				 if(data['error']==0)
				 {
				 $("#price").val(data['price']);
				 $("#options"+data['id']).html(data['dropdown'][0]);
				//if(data['price']!=data['oldPrice'])
					//$(".old-price").html(data['oldPrice']);
				 }
				 else
				 {
					 alert("Not Available");
					 $('select[name="options[]"]').each(function(i){
						 if(i>0)
						 {
							 $(this)
						.find('option:first-child').prop('selected', true)
						.end().trigger('chosen:updated');
						 }						 
					});
				 }
			}
		});
	setTimeout(function() {
	 $('#overlay').hide();				
	}, 500);
}

</script>
	
</body>
</html>
