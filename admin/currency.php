<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
if($userType == 3 || $permission["Settings"] == 0) 
{
	header('location: index.php');
}

// new user submit
if(isset($_POST["submit"]))
{
	$currency=$_POST["currency"];	
	$rslt=mysqli_query($con,"select * from tbl_currency where currency='".$currency."'");
	if(mysqli_num_rows($rslt))
	{
		$_SESSION["err"]="1";
	}
	else
	{
		mysqli_query($con,"insert into tbl_currency (currency) values('".$currency."')") or die(mysqli_error($con));
	}
}

if(isset($_POST["update"]))
{
	$status		= 0;
	if(isset($_POST["active"]))
		$status	= 1;
	$id			= $_POST["update"];
	$currency	= $_POST["currency".$id];	
	$rslt		= mysqli_query($con,"select * from tbl_currency where currency='".$currency."' and id!='".$id."'");
	if(mysqli_num_rows($rslt))
	{
		$_SESSION["err"]="1";
	}
	else
	{
		mysqli_query($con,"update tbl_currency set status=0");
		mysqli_query($con,"update tbl_currency set currency='".$currency."',status='".$status."' where id='".$id."'") or die(mysqli_error($con));
	}
}
if(isset($_POST["delete"]))
{
	$id			= $_POST["delete"];
	mysqli_query($con,"delete from tbl_currency where id='".$id."'");
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
function clickMe()
{
var r=confirm("Are you sure to Update? It may affect values of products");
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
			    <div class="page-header">
			    	<div class="page-title">
				    	<a href="index.php"><h5>Settings</h5></a>
				    	
			    	</div>
			    </div>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Currency</h6></div></div>
	                    	<div class="well row-fluid" id="storeCurrency">                                
                                <div class="control-group">
	                                <label class="control-label">Currency: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-large" name="currency" id="currency"/>					
										<button type="submit" class="btn btn-info" name="submit">Add</button>
										<?php if(isset($_SESSION["err"])) /* if email already registered */
										{
										?>
											<span class="help-block" style="color:#F00;">Currency already added</span>
										<?php
										unset($_SESSION["err"]);
										}
										?>
	                                </div>
                                    <?php $rslt=mysqli_query($con,"select * from tbl_currency order by id desc");
								while($row=mysqli_fetch_assoc($rslt))
								{
								 ?>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $row["currency"]; ?>" class="validate[required] input-large" name="currency<?php echo $row["id"]; ?>" id="currency<?php echo $row["id"]; ?>"/>
                                        <label class="radio inline">Active <input type="radio" <?php if($row["status"]==1) echo "checked"; ?> value="<?php echo $row["currency"]; ?>" class="validate[] input-mini" name="active" id="currency<?php echo $row["id"]; ?>"/></label>
										<button type="submit" value="<?php echo $row["id"]; ?>" onClick="return clickMe()" class="btn btn-info" name="update">Update</button>
										<button type="submit" value="<?php echo $row["id"]; ?>" class="btn btn-danger" name="delete">Remove</button>
	                                </div>
                                <?php }?>
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
