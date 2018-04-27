<?php
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if(isset($_POST["save"]))
{
	$trackingId 	= mysqli_real_escape_string($con,$_POST["orderStatus"]);
	$orderNote	= mysqli_real_escape_string($con,$_POST["orderNote"]);
	$orderNo	= mysqli_real_escape_string($con,$_POST["save"]);
	$date= date('Y-m-d');
	// Check whether the status is already there
	$rslt=mysqli_query($con,"select * from tbl_order_status where fkTrackingId='".$trackingId."' and fkOrderNO='".$orderNo."'");
	if(mysqli_num_rows($rslt)>0) 
	{
		$row=mysqli_fetch_assoc($rslt);
		$id=$row["id"];
		mysqli_query($con,"update tbl_order_status set activeStatus='0' where fkOrderNO='".$orderNo."'");
		mysqli_query($con,"update tbl_order_status set orderNote='".$orderNote."',statusDate=NOW(),activeStatus='1' where id='".$id."'") or die(mysqli_error($con));
	}
	else
	{	
		mysqli_query($con,"update tbl_order_status set activeStatus='0' where fkOrderNO='".$orderNo."'");		
		mysqli_query($con,"insert into tbl_order_status (fkOrderNO,fkTrackingId,orderNote,activeStatus,statusDate) values('".$orderNo."','".$trackingId."','".$orderNote."','1',NOW())") or die(mysqli_error($con));				
	}
	if($trackingId==4)
	{
		mysqli_query($con,"update tbl_orders set paymentStatus=1,deliveryDate=NOW() where orderNo='".$orderNo."'");
		$orderId=$orderNo;
		if($pStatus!=1)
		{
			$transactionId=gen_random_string();
		mysqli_query($con,"update tbl_transaction set gateway='Cash on Delivery',transactionId='".$transactionId."',transactionDate=NOW(),paymentStatus='Completed' where fkOrderId='".$orderNo."' and gateway IS NULL") or die(mysqli_error($con));
		}
	}
	echo "<script>location.href = 'index-store.php'</script>";
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
.datatable-footer{
	display:none;
}
body{
	background:none;
}
</style>
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
		    	<h5 class="widget-name"><i class="icon-th"></i><?php echo "Latest Orders";?></h5>

		    	<div class="table-overflow">
                <form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
					<div id="order-table">
                        <table class="table table-striped table-bordered table-checks media-table-full">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Order #</th>
                                    <th>Items</th>
                                    <th>Order Date</th>
                                    <th>Customer</th>
                                    <th>Billing Address</th>
                                    <th class="align-center">Payment Status</th>
                                    <th>Order Status</th>
                                    <th class="actions-column" style="width:6%;">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i=0;

							$rslt=mysqli_query($con,"SELECT t1.*,t2.fkTRackingId,t2.*,t3.*,t4.*
FROM tbl_orders t1
LEFT JOIN tbl_order_status t2
ON t1.orderNo=t2.fkOrderNo AND t2.activeStatus=1
LEFT JOIN tbl_tracking_status  t3
ON t2.fkTRackingId=t3.id
LEFT JOIN tbl_customers  t4
ON t1.fkCustomer=t4.email where orderType=1 and orderStatus=1
ORDER BY orderDate DESC");
$numrows=mysqli_num_rows($rslt);
							while($row=mysqli_fetch_assoc($rslt))
							{								
								$orderStatus=$row["orderStatus"];
								$trackingStatus=$row["trackingStatus"];
								$orderNumber=$row["orderNo"];
								$orderAmount=$row["orderAmount"];
								$shipTo=$row["billingAddress"];
								$shipTo = str_replace("\n", "", $shipTo);
								$shipTo = str_replace("\r", "", $shipTo);
								$shipTo=preg_replace("/(<br\ ?\/?>)(<br\ ?\/?>)+/", "<br />", $shipTo);
								$today=date('d-m-Y');
								$statusDate=date('d-m-Y',strtotime($row["statusDate"]));
								if($row["fkTrackingId"]==4 && $statusDate!=$today)
									continue;

								$orderDate=date('d M Y', strtotime($row["orderDate"]));
								if($row["activeStatus"]!=0 or is_null($row["activeStatus"]))
								{
									$i++;
							?>
                                <tr style="border-bottom:solid thin #ddd;">
                                    <td><?php echo $i;?></td>
                                    <td><a href="order-details-store.php?id=<?php echo $orderNumber;?>" class="tip" title="Edit"><?php echo $orderNumber;?></a></td>
                                    <td>
                                    <?php $rslt2=mysqli_query($con,"SELECT * FROM tbl_products,tbl_order_items where deleteStatus='0' and tbl_order_items.productId=tbl_products.productId and tbl_order_items.fkOrderNumber='".$orderNumber."'") or die(mysqli_error($con));
                                    while($row2=mysqli_fetch_array($rslt2))
                                    {	
                                        $productId		= $row2["productId"];
                                        $productName	= $row2["productName"];
										$quantity		= $row2["quantity"];
                                ?> 
								<?php echo $productName." -(".$quantity." Nos.)";?>
                                <br clear="all" />
                                    <?php }?>
                                    </td>
                                    <td class=""><?php echo $orderDate;?></td>
                                    <td class=""><?php echo $row["firstName"];?></td>
                                    <td class=""><?php echo $shipTo;?></td>
                                    <td class="align-center"><?php if($row["paymentStatus"]==1) echo '<span style="color:green;">Paid</span>'; else{ if (strpos($row["paymentMethod"], 'Cash on Delivery') !== false) echo '<span style="color:orange;">Cash on Delivery</span>'; else {if($orderStatus==0) echo '<span style="color:red;">Cancelled</span>'; else echo '<span style="color:red;">Unpaid </span>';}}?></td>
                                    <td class="">
										<?php if(!empty($trackingStatus)) echo $trackingStatus; else echo "--";?> 
										<button type="button" data-toggle="modal" value="test" data-target="#exampleModal" data-order="<?php echo $orderNumber;?>" data-status="<?php echo $row['fkTRackingId'];?>" data-note="<?php echo $row['orderNote'];?>" class="order-status remove-button-icon"><i class="icon-pencil"></i></button></td>
                                    <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="invoice-pdf.php?id=<?php echo $orderNumber;?>" target="_blank" class="tip" title="View Invoice"><i class="icon-download-alt"></i></a></li>
		                                    <!--<li><a href="order-details.php?id=<?php echo $orderNumber;?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>-->
		                                </ul>
			                        </td>
                                </tr>
                                <?php } }?>                                
                            </tbody>
                        </table>
						</div>
						<input type="hidden" name="numRows" id="numRows" value="<?php echo $numrows;?>">
						<input type="hidden" name="newOrder" id="newOrder" value="0">
						<div class="row-fluid">
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">Order Status</h4>
                              </div>
							<form action="" method="post">
                              <div class="modal-body">
                                  <div class="form-group">                                    
                                    <label for="message-text" class="control-label">Status:</label>
										<select name="orderStatus" id="orderStatus" class="validate[]" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Status</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT * FROM tbl_tracking_status order by displayOrder asc");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>"><?php echo $row["trackingStatus"];?></option>
                                            <?php } ?>                                           
	                                    </select>
                                  </div>
								  <div class="form-group">                                    
                                    <label for="message-text" class="control-label">Note:</label>
                                    <textarea rows="5" cols="5" name="orderNote" id="orderNote" class="validate[] span12"></textarea>
                                  </div>
                                  <div class="form-group">
                                  </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="save" id="save" value="" class="btn btn-info">Update</button>
                              </div>    
                              </div>
                            </form>  
                            </div>
                          </div>
                        </div>
						</div>
						<br clear="all"/>
                        </form>
                        <?php if(isset($_SESSION["response"]))
						{
							echo "<script>alert('".$_SESSION["response"]."');</script>";
							unset($_SESSION["response"]);
						}
                        ?>
                    </div>
								
				<br clear="all"/>
                </div></div>



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
// load popup
$(".order-status").click(function(){
	var status = $(this).data('status'); // Extract info from data-* attributes
	var note = $(this).data('note');
	var orderNo = $(this).data('order');
	
	$('#save').val(orderNo);
	$('#orderNote').val(note);
	$('#orderStatus').val(status);
});
/*$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  alert(button.data('status'))
  var status = button.data('status') // Extract info from data-* attributes
  var note = button.data('note')
  var orderNo = button.data('order')
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('#save').val(orderNo)
  modal.find('#orderNote').val(note)
  modal.find('#orderStatus').val(status)
});*/
</script>

<script type="text/javascript">
//functions here
//check for browser support
if(typeof(EventSource)!=="undefined") {
	//create an object, passing it the name and location of the server side script
	var eSource = new EventSource("send_sse.php");
	//detect message receipt
	eSource.onmessage = function(event) {
		//write the received data to the page
		dataJS=JSON.parse(event.data);
		var oldRows=$("#numRows").val();
		var newRows=dataJS["numrows"];
		var newOrder=$("#newOrder").val();
		var diff=parseInt(newOrder)+parseInt(newRows-oldRows);
		//alert(dataJS["numrows"]);
		if(oldRows!=newRows)
		{
			$.jGrowl('<a href="index-store.php" style="color:#F5F9FB">New Order in List<a>', { sticky: true, header: 'Notification'});
			$("#order-table").html(dataJS['table']);
			$("#numRows").val(newRows);
			$("#newOrder").val(diff);
		}
		for(i=1;i<=newOrder;i++)
		{
			$('table > tbody > tr:nth-child('+i+')').children().css("background-color","rgb(251, 234, 214)");
		}
//			$.jGrowl('<a href="test">New Order in List<a>', { sticky: true, header: 'Notification'});
	};
}
else {
	document.getElementById("serverData").innerHTML="Whoops! Your browser doesn't receive server-sent events.";
}
</script>
</body>
</html>
