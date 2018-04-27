<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
//get product image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Category'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];

$cId=$_GET["id"];
$rslt=mysqli_query($con,"select email from tbl_customers where customerId='".$cId."'");
$row=mysqli_fetch_assoc($rslt);
$customer=$row["email"];

// new user submit
if(isset($_POST["submit"]))
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
	$orderId=gen_random_string();
	if(isset($_POST["address"]))
	{
		$address=$_POST["address"];
	}
	else{
		$address=$_POST["newAddress"];
	}
	
	mysqli_query($con,"INSERT INTO tbl_orders (orderNo,fkCustomer,billingAddress,orderDate,orderAmount,paymentStatus,paymentMethod,shippingCharge,invoice) VALUES ('".$orderId."', '".$customer."', '".$address."', NOW(), '".$total."', '0','','','0')") or die(mysqli_error($con));

	
	mysqli_query($con,"insert into tbl_order_items (fkOrderNumber,productId,productOptions,unitPrice,quantity,total,couponCode,discountAmount) values('".$orderId."','".$prodId."','".$OptionValueId."','".$price."','".$quantity."','".$total."','".$coupon."','".$couponAmount."')");
	
	echo "<script>location.href = 'view-invoice.php?id=$orderId'</script>";
}
function gen_random_string()
{
	$chars ="1234567890";//length:36
    $final_rand='';
    for($i=0;$i<12; $i++)
    {
        $final_rand .= $chars[ rand(0,strlen($chars)-1)];
    }
	$rslt=mysqli_query($con,"select * from tbl_orders where orderNo='".$final_rand."'");
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
<script>
$(document).ready(function(){
    $("#validate").validationEngine('attach');
});
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>New Invoice</h6></div></div>
					
                           <div class="well row-fluid">                                
                                <div class="control-group">
	                                <label class="control-label">Product: <span class="text-error">*</span></label>
	                                <div class="controls">
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
	                                </div>
	                            </div> 
                                <div class="control-group options">
	                                
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Unit Price (<?php echo $currency;?>)</label>
	                                <div class="controls">
	                                    <input type="text" readonly value=""  maxlength="65" class="validate[] input-large" name="price" id="price"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Quantity</label>
	                                <div class="controls">
	                                    <input type="number" value="1" min="1"  maxlength="65" class="validate[] input-large" name="quantity" id="quantity"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Shipping Address</label>
	                                <div class="controls">
									<?php 
									$rslt=mysqli_query($con,"SELECT t1.* FROM tbl_shipping_addresses t1 where fkCustomer='$cId'");
									while($row=mysqli_fetch_assoc($rslt))
									{	
										$address=nl2br($row['fullName']."\n".$row['address']."\n".$row['location']."\n".$row['area']."\n".$row['state']."\n".$row['PIN']."\n".$row['phone1']."\n".$row['phone2']."\n".$row['email']."\n");
									?>
	                                    <label class="radio inline">
										<input type="radio" value="<?php echo $address;?>" class="validate[]" name="address" id="quantity"/><?php echo $address;?></label>
									<?php }?>
									<textarea style="margin-left:20px;" class="span3" placeholder="New Address" rows="6" name="newAddress"></textarea>
	                                </div>
	                            </div>								
                                <div class="form-actions align-right">
									<button type="submit" class="btn btn-info" value="" name="submit">Add</button>
								</div>
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
