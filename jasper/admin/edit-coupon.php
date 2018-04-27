<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

$id		= $_GET["id"];

//select coupon details
$rslt	= mysqli_query($con,"select * from tbl_coupons where id='".$id."'");
$row	= mysqli_fetch_assoc($rslt);
$couponCode 	= $row["couponCode"];
$discount		= $row["discount"];
$discountType 	= $row["discountType"];
$description	= $row["description"];
$validFrom		= $row["validFrom"];
$validTill		= $row["validTill"];
$activeStatus	= $row["activeStatus"];
$applyMode	= $row["applyMode"];
$forceDays	= $row["forceDays"];
$numDays	= $row["numDays"];
$allSubscription	= $row["allSubscription"];
$allClient	= $row["allClient"];
$couponList	= $row["categoryId"];
$instructor	= $row["instructor"];

$subArray=array();

$clientArray=array();



// new user submit
if(isset($_POST["submit"]))
{
	$couponCode 	= mysqli_real_escape_string($con,$_POST["couponCode"]);
	$discount		= mysqli_real_escape_string($con,$_POST["discount"]);
	$discountType	= mysqli_real_escape_string($con,$_POST["discountType"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$validFrom		= date("Y-m-d", strtotime($_POST["validFrom"]));
	$validTill		= date("Y-m-d", strtotime($_POST["validTill"]));	
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	$applyMode		= mysqli_real_escape_string($con,$_POST["applyMode"]);
	$couponList		= mysqli_real_escape_string($con,$_POST["couponList"]);
	$instructor		= mysqli_real_escape_string($con,$_POST["instructor"]);
	$allSubscription=0;
	if(isset($_POST["allSubscription"]))
		$allSubscription=1;
	
	$allClient=0;
	if(isset($_POST["allClient2"]))
		$allClient=2;
	
	if(isset($_POST["allClient"]))
		$allClient=1;
	
	
	$forceDays=0;
	$numDays=0;
	if(isset($_POST["forceDays"]))
	{
		$forceDays=1;
		$numDays=$_POST["numDays"];
	}	
	
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_coupons where couponCode='".$couponCode."' and id!='".$id."'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="Coupon code already Generated";
	}
	else
	{		
		mysqli_query($con,"update tbl_coupons set couponCode='".$couponCode."',discount='".$discount."',discountType='".$discountType."',validFrom='".$validFrom."',validTill='".$validTill."',activeStatus='".$activeStatus."',updatedOn=NOW(),updatedBy='".$CurrentUserId."',description='".$description."',applyMode='".$applyMode."',allSubscription='".$allSubscription."',allClient='".$allClient."',forceDays='".$forceDays."',numDays='".$numDays."',categoryId='".$couponList."',instructor='".$instructor."' where id='".$id."'") or die(mysqli_error($con));
		if($allSubscription==0)
		{
				mysqli_query($con,"update tbl_coupon_subscriptions set activeStatus=0 where couponId='".$id."'");
			if(isset($_POST["subscriptions"]))
			{
				foreach($_POST["subscriptions"] as $sub)
				{
					$rslt=mysqli_query($con,"select * from tbl_coupon_subscriptions where couponId='".$id."' and subscriptionId='".$sub."'");
					if(mysqli_num_rows($rslt)>0)
					{
						mysqli_query($con,"update tbl_coupon_subscriptions set activeStatus=1 where couponId='".$id."' and subscriptionId='".$sub."'");
					}
					else
					{
						mysqli_query($con,"insert into tbl_coupon_subscriptions(couponId,subscriptionId,activeStatus) values('".$id."','".$sub."','1')");
					}
				}
			}
		}
		
		
		if($allClient!=1)
		{
				mysqli_query($con,"update tbl_coupon_customers set activeStatus=0 where couponId='".$id."'");
			if(isset($_POST["clients"]))
			{
				foreach($_POST["clients"] as $cli)
				{
					$rslt=mysqli_query($con,"select * from tbl_coupon_customers where couponId='".$id."' and customer='".$cli."'");
					if(mysqli_num_rows($rslt)>0)
					{
						mysqli_query($con,"update tbl_coupon_customers set activeStatus=1 where couponId='".$id."' and customer='".$cli."'");
					}
					else
					{
						mysqli_query($con,"insert into tbl_coupon_customers(couponId,customer,activeStatus) values('".$id."','".$cli."','1')");
					}
				}
			}
		}
		
		$_SESSION["response"]="Coupon Updated";
		if($_POST["submit"]=="submit-close")
			echo "<script>location.href = 'manage-coupon.php?id=".$couponList."'</script>";
		else
			echo "<script>location.href = 'edit-coupon.php?id=$id'</script>";
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
				<br clear="all"/>
			    <h5 class="widget-name"><i class="icon-gift"></i>Edit Coupon
			  <a href="manage-coupon-category.php" style="float:right;color:#555 !important;margin-right:10px;"><i style="padding:2px;" class="icon-arrow-left"></i>Coupon Category</a>
				</h5>


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="tabbable"><!-- default tabs -->
							<ul class="nav nav-tabs">
	                        	<li><a href="#tab1" data-toggle="tab">General</a></li>	                            
	                        	<li><a href="#tab2" data-toggle="tab">Products</a></li>	                            
	                        	<li><a href="#tab3" data-toggle="tab">Categories</a></li>	                            
                                <div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info updt-btn bbq" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info updt-btn" value="submit-close" name="submit">Save</button>
								</div>
							</ul>
							<div class="tab-content">
							<div class="tab-pane active" id="tab1">
							<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Coupon Code: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $couponCode; ?>" class="validate[required] input-xlarge" name="couponCode" id="couponCode"/>					
										<?php if(isset($_SESSION["response"])) /* if coupon already registered */
										{
										?>
											<span class="help-block" style="color:#F00;"><?php echo $_SESSION["response"]; ?></span>
										<?php
										unset($_SESSION["response"]);
										}
										?>
	                                </div>
	                            </div>
								
								<div class="control-group">
									<label class="control-label">Coupon List: <span class="text-error">*</span> </label>
									
									<div class="controls">
									
									<select name="couponList" id="couponList" onChange="filterCategory(this.value)" data-placeholder="Choose Category..." class="input-xlarge " data-prompt-position="topLeft:-1,-5">
           	                            	<option value="">Choose Coupon List</option>
										<?php
										$qry="SELECT * from tbl_coupon_category where activeStatus=1";
										$rslt=mysqli_query($con,$qry);
										while($row=mysqli_fetch_array($rslt))
										{
										?>
	                                        <option value="<?php echo $row["id"];?>" <?php if($couponList==$row["id"]) echo "selected";?>><?php echo $row["category"];?></option>
                                        <?php } ?>
	                                    </select>
									
									</div>
								</div>
								
								<div class="control-group hide">
									<label class="control-label">Instructor:</label>
									<div class="controls">									
										<select name="instructor" id="instructor" data-placeholder="Choose Instructor..." class="input-xlarge validate[]" data-prompt-position="topLeft:-1,-5">
												<option value="0">Choose Instructor</option>
											<?php
											$rslt=mysqli_query($con,"SELECT * from tbl_team_members where activeStatus=1 and memberType=2");
											while($row=mysqli_fetch_array($rslt))
											{
											?>
												<option value="<?php echo $row["id"];?>" <?php if($instructor==$row["id"]) echo "selected";?>><?php echo $row["fullName"];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
                                <div class="control-group">
	                                <label class="control-label">Discount: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $discount; ?>"  class="validate[required,custom[number]] input-medium" name="discount" id="discount"/>					
                                        <label class="radio inline">
											<input class="validate[] styled" type="radio" name="discountType" <?php if($discountType=="percentage") echo "checked"; ?> id="discountType" value="percentage" data-prompt-position="topLeft:-1,-5"/>
											%
										</label>
                                        <label class="radio inline">
											<input class="validate[] styled" type="radio" <?php if($discountType=="amount") echo "checked"; ?> name="discountType" id="discountType2" value="amount" data-prompt-position="topLeft:-1,-5"/>
											Amount
										</label>
	                                </div>
	                            </div>
                                <div class="control-group">
		                            <label class="control-label">Valid From: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $validFrom; ?>" name="validFrom" id="validFrom"/>
		                            </div>
		                        </div>
                                <div class="control-group">
		                            <label class="control-label">Valid Till: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $validTill; ?>" name="validTill" id="validTill"/>
		                            </div>
		                        </div>
                                <div class="control-group">
	                                <label class="control-label">Description</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="description" class="validate[] span12"><?php echo $description; ?></textarea>
	                                </div>
	                            </div>
								
								<div class="control-group hide">
	                                <label class="control-label">Extend Days:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="checkbox" <?php if($forceDays==1) echo "checked"; ?> name="forceDays" id="forceDays"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Enable
										</label>
	                                </div>
	                                <div class="controls numDays <?php if($forceDays==0) echo 'hide';?>">
									<label class="control-label">Number of Days:</label>
										<input type="text" class="validate[] input-small" value="<?php echo $numDays; ?>" name="numDays" id="numDays"/>
	                                </div>
	                            </div>
								
								<div class="control-group hide">
	                                <label class="control-label">Mode: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($applyMode==1) echo "checked"; ?> name="applyMode"  value="1" data-prompt-position="topLeft:-1,-5"/>
											One Time Redeem
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="applyMode" <?php if($applyMode==0) echo "checked"; ?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Multiple Redeem
										</label>
	                                </div>
	                            </div>
								
                                <div class="control-group">
	                                <label class="control-label">Status: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus==1) echo "checked"; ?> name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" <?php if($activeStatus==0) echo "checked"; ?> value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>	                                                        
	                            

	                        </div>
							</div>
							<div class="tab-pane" id="tab2">
								<?php /*<div class="control-group">
	                                <label class="control-label">Subscriptions: <span class="text-error">*</span></label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="" type="checkbox" <?php if($allSubscription==1) echo "checked";?> name="allSubscription" id="checkAll1"  value="" data-prompt-position="topLeft:-1,-5"/>
											Apply to All
										</label>
	                                </div>
									<div class="controls">
									<?php 
									$j=0;
									$rslt=mysqli_query($con,"select * from tbl_pkg_subscriptions where activeStatus=1");
									while($row=mysqli_fetch_assoc($rslt))
									{
										$j++;
										
									?>
										<label class="radio inline">
											<input class="allSubscription" <?php if($allSubscription==1) echo "checked";else if(in_array($row["id"],$subArray)) echo "checked";?> type="checkbox" name="subscriptions[]"  value="<?php echo $row["id"];?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["subscriptionName"];?>
										</label>
									<?php if($j%4==0) echo '<br clear="all">';
									}?>
	                                </div>
	                            </div>*/?>
							</div>
							<div class="tab-pane" id="tab3">
								<?php /*<div class="control-group">
	                                <label class="control-label">Clients: <span class="text-error">*</span></label>
									<div class="controls">
										<label class="radio inline">
											<input class="" type="checkbox" <?php if($allClient==1) echo "checked";?> name="allClient" id=""  value="" data-prompt-position="topLeft:-1,-5"/>
											Apply to All
										</label>
	                                </div>
									<div class="controls">
										<label class="radio inline">
											<input class="" type="checkbox" <?php if($allClient==2) echo "checked";?> name="allClient2" id="checkAll2"  value="" data-prompt-position="topLeft:-1,-5"/>
											Apply to All Subscribers
										</label>
	                                </div>
									<div class="controls">
									<?php 
									$j=0;
									$rslt=mysqli_query($con,"select * from tbl_lil_customers,tbl_login where loginActive=1 and loginUsername=email");
									while($row=mysqli_fetch_assoc($rslt))
									{
										$j++;
									?>
										<label class="radio inline">
											<input class="allClient" <?php if($allClient==1) echo "checked";else if(in_array($row["email"],$clientArray)) echo "checked";?> type="checkbox" name="clients[]"  value="<?php echo $row["email"];?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["firstName"]." ".$row["lastName"];?>
										</label>
									<?php if($j%4==0) echo '<br clear="all">';}?>
	                                </div>
								</div>*/?>
							</div>

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
$("#checkAll1").click(function(){
    $('.allSubscription').prop('checked', this.checked);
});
$("#checkAll2").click(function(){
    $('.allClient').prop('checked', this.checked);
});

$("#forceDays").click(function(){
    $('.numDays').toggle();
});

$(".allSubscription").click(function(){
	if($(this).is(":checked"))
	{
		if ($('.allSubscription:checked').length == $('.allSubscription').length) {
			$('#checkAll1').prop('checked', this.checked);
		}
	}
	else
	{
		$('#checkAll1').prop('checked', this.checked);
	}
});

$(".allClient").click(function(){
	if($(this).is(":checked"))
	{
		if ($('.allClient:checked').length == $('.allClient').length) {
			$('#checkAll2').prop('checked', this.checked);
		}
	}
	else
	{
		$('#checkAll2').prop('checked', this.checked);
	}
});

</script>
</body>
</html>
