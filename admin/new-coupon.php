<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/

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
	
		$forceDays=0;
	$numDays=0;
	if(isset($_POST["forceDays"]))
	{
		$forceDays=1;
		$numDays=$_POST["numDays"];
	}
	
	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_coupons where couponCode='".$couponCode."'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="Coupon code already Generated";
	}
	else
	{		
		mysqli_query($con,"insert into tbl_coupons (couponCode,discount,discountType,validFrom,validTill,description,activeStatus,validClients,validSubscriptions,applyMode,createdOn,createdBy,updatedOn,updatedBy,forceDays,numDays,categoryId,instructor) values('".$couponCode."','".$discount."','".$discountType."','".$validFrom."','".$validTill."','".$description."','".$activeStatus."','','','".$applyMode."',NOW(),'".$CurrentUserId."',NOW(),'".$CurrentUserId."','".$forceDays."','".$numDays."','".$couponList."','".$instructor."')") or die(mysqli_error($con));
				
		$_SESSION["response"]="Coupon Created";
		
		$rslt=mysqli_query($con,"select id from tbl_coupons order by id desc limit 1");
		$row=mysqli_fetch_assoc($rslt);
		$id=$row["id"];
		
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
			   <h5 class="widget-name"><i class="icon-gift"></i>New Coupon
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
	                        	<li><a href="#tab3" data-toggle="tab">Category</a></li>	                            
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
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="couponCode" id="couponCode"/>					
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
										<select name="couponList" id="couponList" data-placeholder="Choose Category..." class="input-xlarge validate[required]" data-prompt-position="topLeft:-1,-5">
												<option value="">Choose Coupon List</option>
											<?php
											$qry="SELECT * from tbl_coupon_category where activeStatus=1";
											$rslt=mysqli_query($con,$qry);
											while($row=mysqli_fetch_array($rslt))
											{
											?>
												<option value="<?php echo $row["id"];?>"><?php echo $row["category"];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="control-group hide">
									<label class="control-label">Instructor: </label>
									<div class="controls">									
										<select name="instructor" id="instructor" data-placeholder="Choose Instructor..." class="input-xlarge validate[]" data-prompt-position="topLeft:-1,-5">
												<option value="0">Choose Instructor</option>
											<?php
											$rslt=mysqli_query($con,"SELECT * from tbl_team_members where activeStatus=1 and memberType=2");
											while($row=mysqli_fetch_array($rslt))
											{
											?>
												<option value="<?php echo $row["id"];?>"><?php echo $row["fullName"];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
                                <div class="control-group">
	                                <label class="control-label">Discount: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value=""  class="validate[required,custom[number]] input-medium" name="discount" id="discount"/>					
                                        <label class="radio inline">
											<input class="validate[] styled" type="radio" name="discountType" checked id="discountType" value="percentage" data-prompt-position="topLeft:-1,-5"/>
											%
										</label>
                                        <label class="radio inline">
											<input class="validate[] styled" type="radio" name="discountType" id="discountType2" value="amount" data-prompt-position="topLeft:-1,-5"/>
											Amount
										</label>
	                                </div>
	                            </div>
                                <div class="control-group">
		                            <label class="control-label">Valid From: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="" name="validFrom" id="validFrom"/>
		                            </div>
		                        </div>
                                <div class="control-group">
		                            <label class="control-label">Valid Till: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="" name="validTill" id="validTill"/>
		                            </div>
		                        </div>
                                <div class="control-group">
	                                <label class="control-label">Description</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="description" class="validate[] span12"></textarea>
	                                </div>
	                            </div>
								
								<div class="control-group hide">
	                                <label class="control-label">Extend Days: </label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="checkbox" name="forceDays" id="forceDays"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Enable
										</label>
	                                </div>
	                                <div class="controls numDays hide">
									<label class="control-label">Number of Days:</label>
										<input type="text" class="validate[] input-small" min="0" value="0" name="numDays" id="numDays"/>
	                                </div>
	                            </div>

								<div class="control-group hide">
	                                <label class="control-label">Mode: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" checked type="radio" name="applyMode"  value="1" data-prompt-position="topLeft:-1,-5"/>
											One Time Redeem
										</label>
										<label class="radio inline">
											<input class="styled"  type="radio" name="applyMode" value="0" data-prompt-position="topLeft:-1,-5"/>
											Multiple Redeem
										</label>
	                                </div>
	                            </div>
								
                                <div class="control-group">
	                                <label class="control-label">Status: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>	                                                        
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info updt-btn" name="submit">Submit</button>
	                                <button type="reset" class="btn updt-btn bbq3">Reset</button>
	                            </div>

	                        </div>
	                        </div>
							<div class="tab-pane" id="tab2">
								You need to save to add product
							</div>
							<div class="tab-pane" id="tab3">
								You need to save to add category
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
$("#forceDays").click(function(){
    $('.numDays').toggle();
});
</script>
</body>
</html>
