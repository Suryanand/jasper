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
	$pageName 	= mysqli_real_escape_string($con,$_POST["pageName"]);
	$height		= mysqli_real_escape_string($con,$_POST["height"]);
	$width		= mysqli_real_escape_string($con,$_POST["width"]);

		mysqli_query($con,"insert into image_size (pageName,height,width)values('".$pageName."','".$height."','".$width."')") or die(mysqli_error($con));
		$_SESSION["response"]="Category Created";
/*		echo "<script>location.href = 'manage-brand.php'</script>";
*/}
if(isset($_POST["update"]))
{
	$iValue		= mysqli_real_escape_string($con,$_POST["update"]);
	$id		 	= mysqli_real_escape_string($con,$_POST["id".$iValue]);
	$pageName 	= mysqli_real_escape_string($con,$_POST["pageName".$iValue]);
	$height		= mysqli_real_escape_string($con,$_POST["height".$iValue]);
	$width		= mysqli_real_escape_string($con,$_POST["width".$iValue]);
	//die($iValue." ".$pageName." ".$height." ".$width." ".$id);

		mysqli_query($con,"update image_size set pageName='".$pageName."',height='".$height."',width='".$width."' where id='".$id."'") or die(mysqli_error($con));
/*		echo "<script>location.href = 'manage-brand.php'</script>";
*/}
if(isset($_POST["delete"]))
{
	$iValue		= mysqli_real_escape_string($con,$_POST["delete"]);
	$id		 	= mysqli_real_escape_string($con,$_POST["id".$iValue]);
	
	mysqli_query($con,"delete from image_size where id='".$id."'") or die(mysqli_error($con));
/*		echo "<script>location.href = 'manage-brand.php'</script>";
*/}

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
	                        <div class="navbar"><div class="navbar-inner"><h6>Image Size</h6></div></div>
	                    	<div class="well row-fluid">  
                            
                            	<div class="control-group">
                                <?php $rslt=mysqli_query($con,"select * from image_size"); 
										$i=0;
										while($row=mysqli_fetch_assoc($rslt))
										{
											$i++;
								?>
	                                <div class="controls" style="margin-left:0px;">
	                                    <input type="text" readonly value="<?php echo $row["pageName"];?>" placeholder="Page Name" class="validate[required] input-xlarge" name="pageName<?php echo $i;?>" />					
	                                    <input type="text" value="<?php echo $row["height"];?>" placeholder="Height" class="validate[required] input-medium" name="height<?php echo $i;?>" />					
	                                    <input type="text" value="<?php echo $row["width"];?>" placeholder="Width" class="validate[required] input-medium" name="width<?php echo $i;?>" />
	                                    <input type="hidden" value="<?php echo $row["id"];?>" placeholder="" class="validate[required] input-medium" name="id<?php echo $i;?>" />
	                                <button type="submit" value="<?php echo $i;?>" class="btn btn-info" name="update">Update</button>
	                                <button type="submit" value="<?php echo $i;?>" class="btn btn-info" name="delete">Delete</button>
	                                </div>
                                <?php }?>
	                                    <input type="hidden" value="<?php echo $row["width"];?>" placeholder="Width" class="validate[required] input-medium" name="iValue" id="iValue"/>
	                            </div>
                                                          	                                
                                <div class="control-group">
	                                <div class="controls" style="margin-left:0px;">
	                                    <input type="text" value="" placeholder="Page Name" class="validate[] input-xlarge" name="pageName" id="pageName"/>					
	                                    <input type="text" value="" placeholder="Height" class="validate[] input-medium" name="height" id="height"/>					
	                                    <input type="text" value="" placeholder="Width" class="validate[] input-medium" name="width" id="width"/>					
		                                <button type="submit" class="btn btn-info" name="submit">Add</button>
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

</body>
</html>
