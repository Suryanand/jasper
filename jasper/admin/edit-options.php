<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
if($userType == 3) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_options where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);
$optionName=$row["optionName"];
$optionNameAr=$row["optionNameAr"];
// new user submit
if(isset($_POST["submit"]))
{
	$optionName = mysqli_real_escape_string($con,$_POST["optionName"]);
	$optionNameAr = mysqli_real_escape_string($con,$_POST["optionNameAr"]);
											
		mysqli_query($con,"update tbl_options set optionName='$optionName',optionNameAr='$optionNameAr' where id='".$id."'") or die(mysqli_error($con));
		$optionId=$id;
		if(!empty($_POST['option']))
		{
			mysqli_query($con,"insert into tbl_option_values (fkOptionId,optionValue,optionValueAr)values('$optionId','".$_POST['option']."','".$_POST['optionAr']."')") or die(mysqli_error($con));			
		}
		$_SESSION["response"]="Option Added";
		echo "<script>location.href = 'edit-options.php?id=$id'</script>";	
}
if(isset($_POST['update']))
{
	$opId=$_POST['update'];
	$opVal=$_POST['option'.$opId];
	$opValAr=$_POST['optionAr'.$opId];
	mysqli_query($con,"update tbl_option_values set optionValue='".$opVal."',optionValueAr='".$opValAr."' where id='".$opId."'");
}
if(isset($_POST['remove']))
{
	$opId=$_POST['remove'];
	$opVal=$_POST['option'.$opId];
	mysqli_query($con,"delete from tbl_option_values where id='".$opId."'");
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
	<div id="overlay">
            <img alt="" id="loading" src="img/elements/loaders/1.gif">
	</div>

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
	                        <div class="navbar"><div class="navbar-inner"><h6>Options</h6></div></div>
	                    	<div class="well row-fluid" id="specification">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Option Name: <span class="text-error">*</span></label>
	                                <div class="controls">
                                         <input type="text" value="<?php echo $optionName;?>" class="validate[required] input-large" name="optionName" id="optionName"/>     
	                                </div>
	                            </div>
                                <div style="display:none;" class="control-group">
	                                <label class="control-label">Option Name Arabic: <span class="text-error">*</span></label>
	                                <div class="controls">
                                         <input type="text" style="direction:rtl;" value="<?php echo $optionNameAr;?>" class="validate[] input-large" name="optionNameAr" id="optionNameAr"/>     
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Option Value Name:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-large" name="option"/>
	                                </div>
								</div>
								<div style="display:none;" class="control-group">
	                                <label class="control-label">Option Value Name Arabic:</label>
	                                <div class="controls">
										<input type="text" value="" style="direction:rtl;" class="validate[] input-large" name="optionAr"/>
	                                </div>
	                                <div class="controls">
										<button type="submit" name="submit" class="btn btn-info"  style="margin-top:4px;">Add</button>										
	                                </div>
								</div>
								<div class="control-group">
	                                <label class="control-label"></label>
	                                <div class="controls">
										<button type="submit" name="submit" class="btn btn-info"  style="margin-top:4px;">Add</button>										
	                                </div>
								</div>
							</div>
								<br clear="all"/>
							<div class="row-fluid">
							<div class="span8">
								<table class="table">
									<thead>
									<tr>
										<th>Sr. No.</th>
										<th>Option Value:</th>
										<!--<th>Option Value Arabic:</th>-->
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php 
									$i=0;
										$rslt=mysqli_query($con,"select * from tbl_option_values where fkOptionId='".$id."'");
										while($row=mysqli_fetch_assoc($rslt))
										{
											$i++;
											?>
									
										<tr>
											<td><?php echo $i;?></td>
											<td><input type="text" value="<?php echo $row["optionValue"];?>" class="validate[required] input-large" name="option<?php echo $row["id"];?>"/></td>
											<!--<td><input type="text" style="direction:rtl;" value="<?php echo $row["optionValueAr"];?>" class="validate[] input-large" name="optionAr<?php echo $row["id"];?>"/></td>-->
											<td>
											<button type="submit" name="update" value="<?php echo $row["id"];?>" class="btn btn-info"><i style="margin-top:4px;" class="icon-ok"></i></button>
											<button type="submit" name="remove" value="<?php echo $row["id"];?>" class="btn btn-danger"><i style="margin-top:4px;" class="icon-minus"></i></button></td>
										</tr>	                                
										<?php }?>
									</tbody>
								</table>
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

<?php if(isset($_SESSION["response"]))
{
	echo "<script>alert('".$_SESSION["response"]."');</script>";
	unset($_SESSION["response"]);
}
?>
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
