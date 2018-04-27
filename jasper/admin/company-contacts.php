<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

if($userType != 1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

if(isset($_POST["submit"]))
{
	$companyAddress = mysqli_real_escape_string($con,$_POST["address"]);
	$companyName	=mysqli_real_escape_string($con,$_POST["name"]);
	$companyEmail	=mysqli_real_escape_string($con,$_POST["companyEmail"]);
	$companyContact	=mysqli_real_escape_string($con,$_POST["companyContact"]);
	$companyMobile	=mysqli_real_escape_string($con,$_POST["companyMobile"]);
	$companyFax	=mysqli_real_escape_string($con,$_POST["companyFax"]);
	$companyWebsite	=mysqli_real_escape_string($con,$_POST["companyWebsite"]);
	$googleMap	=mysqli_real_escape_string($con,$_POST["googleMap"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);

	if($_POST["submit"]=="save")
	{ /* inser into table first time*/
	mysqli_query($con,"insert into tbl_company_address (companyName,companyAddress,companyContact,companyMobile,companyEmail,companyFax,companyWebsite,googleMap,activeStatus)values('$companyName','$companyAddress','$companyContact','$companyMobile','$companyEmail','$companyFax','$companyWebsite','$googleMap','$activeStatus')") or die(mysqli_error($con));
	$_SESSION["response"]='Company Contact Saved';
	}
	else
	{ /* update links in table*/
	mysqli_query($con,"update tbl_company_address set companyName='$companyName',companyAddress='$companyAddress',companyFax='$companyFax',companyMobile='$companyMobile',companyContact='$companyContact',companyEmail='$companyEmail',companyWebsite='$companyWebsite',googleMap='$googleMap',activeStatus='$activeStatus' where companyId='".$_POST["submit"]."'");	
	$_SESSION["response"]='Company Contact Updated';
	}
	echo "<script>location.href = 'company-contacts.php'</script>";
}
if(isset($_POST["delete"]))
{
	$delId=$_POST["delete"];
	mysqli_query($con,"delete from tbl_company_address where companyId='".$delId."'");
	echo "<script>location.href = 'company-contacts.php'</script>";
}

?>
<!doctype html>
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

			    <br>
				<h5 class="widget-name"><i class="icon-barcode"></i>Company Contacts</h5>



	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
							<div class="tabbable"><!-- default tabs -->
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
	                    	<div class="well row-fluid">							
								<?php $rslt=mysqli_query($con,"select * from tbl_company_address");
								$i=0;
								$numRows=mysqli_num_rows($rslt);
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
									?>
									<div class="span6 well" <?php if($i%2 ==0) echo 'style="margin-left:0px"';?>	>
									<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
									<div class="control-group">
										 <label class="control-label">Name: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyName"]; ?>" class="validate[required] input-xlarge"  name="name" id="name"/>
										 </div>
									 </div>                                
									<div class="control-group">
										<label class="control-label">Address: <span class="text-error">*</span></label>
										<div class="controls">
											<textarea rows="5" cols="5" name="address" class="validate[required] input-xlarge"><?php echo $row["companyAddress"]; ?></textarea>
										</div>
									</div>
									<div class="control-group">
										 <label class="control-label">Contact Number: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyContact"]; ?>" class="validate[required] input-xlarge"  name="companyContact" id="companyContact"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Mobile: </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyMobile"]; ?>" class="validate[] input-xlarge"  name="companyMobile" id="companyMobile"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Fax: </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyFax"]; ?>" class="validate[] input-xlarge"  name="companyFax" id="companyFax"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Company Email: <span class="text-error">*</span> </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyEmail"]; ?>" class="validate[required,custom[email]] input-xlarge"  name="companyEmail" id="companyEmail"/>
										 </div>
									 </div>
									 <div class="control-group">
										 <label class="control-label">Website: </label>
										 <div class="controls">
											 <input type="text" value="<?php echo $row["companyWebsite"]; ?>" class="validate[] input-xlarge"  name="companyWebsite" id="companyWebsite"/>
										 </div>
									 </div>
									 <div class="control-group">
										<label class="control-label">Google Map Iframe: </label>
										<div class="controls">
											<textarea rows="7" cols="5" name="googleMap" class="validate[] span12"><?php echo $row["googleMap"]; ?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
										<div class="controls">

											<label class="radio inline">
												<input class="styled" type="radio" <?php if($row["activeStatus"] == 0) {echo "checked";}?>  name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
												Draft
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($row["activeStatus"] == 1) {echo "checked";}?> name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
												Publish
											</label>
										</div>
									</div>
									<div class="form-actions align-right">
										<button type="submit" class="btn btn-info" name="submit" value="<?php echo $row["companyId"];?>">Update</button>
										<?php if($numRows>1){?><button type="submit" name="delete" value="<?php echo $row["companyId"];?>" class="btn btn-danger">Delete</button><?php }?>
									</div>
									</form>
									</div>
								<?php if(!$i%2 ==0) echo '<br clear="all"/><br clear="all"/>';}?>								
	                        </div>
							
							</div>
							
							</div>
							</div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				<!-- /form validation -->
                
                <!-- form submition -->  
                    <?php if(isset($_SESSION["response"]))
                     {
                     	echo "<script>alert('".$_SESSION["response"]."');</script>";
                        unset($_SESSION["response"]);
                      }
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
