<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

// new user submit
if(isset($_POST["submit"]))
{
	$voucherPlan = $_POST["voucherPlan"];
	$voucherCode = $_POST["voucherCode"];
	$date		 = date('Y-m-d');
	$rslt = mysqli_query($con,"select voucherAmount from tbl_vouchers where id='".$voucherPlan."'");
	$row = mysqli_fetch_assoc($rslt);
	$voucherAmount = $row["voucherAmount"];
	mysqli_query($con,"insert into tbl_customer_vouchers (fkVoucherId,voucherCode,purchaseDate,balanceAmount) values('".$voucherPlan."','".$voucherCode."','".$date."','".$voucherAmount."')");
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
function generateCode()
{
		 $.ajax({
			 type: "POST",
			 url: "ajx-voucher.php",
			 data: {},
			 success: function(data) {
				 $("#voucherCode").val(data);	 
				 //alert(data);
			}
		});
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Gift Voucher</h6></div></div>
	                    	<div class="well row-fluid" id="specification">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Voucher Plan: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="voucherPlan" id="voucherPlan" class="validate[required] options" data-prompt-position="topLeft:-1,-5">
                                              <option value="">Select Plan</option>
											<?php 
												$rslt=mysqli_query($con,"SELECT voucherPlan,id from tbl_vouchers");
												while($row=mysqli_fetch_array($rslt))
												{
											?>			                                            
                                            <option value="<?php echo $row["id"];?>"><?php echo $row["voucherPlan"];?></option>
                                            <?php } ?>
	                                    </select>
	                                </div>
	                            </div>
                                
                                <div class="control-group">
	                                <label class="control-label">Voucher Code: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-large" name="voucherCode" id="voucherCode"/>					
										<button type="button" onClick="generateCode()" class="btn btn-info" name="generate">Generate</button>
	                                </div>
	                            </div>
                                <div class="form-actions align-right">
                                        <button type="submit" class="btn btn-info" value="paypal" name="submit">Save</button>
                                        <button type="reset" class="btn btn-danger" value="" name="">Clear</button>
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

</body>
</html>
