<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include_once("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
if($permission["Product"] < 2) 
{
	header('location: manage-product.php');
}
$productId=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_products where productId='".$productId."'");
$row=mysqli_fetch_assoc($rslt);
$productName	= $row["productName"];
$price			= $row["price"];
$sku			= $row["sku"];
$displayFront	= $row["displayFront"];
$main_image		= $row["main_image"];
$shortDesc		= $row["shortDescription"];
// save product details
if(isset($_POST['submit']))
{
	$productName	= mysqli_real_escape_string($con,$_POST["productName"]);
	$price			= mysqli_real_escape_string($con,$_POST["price"]);
	$shortDesc		= mysqli_real_escape_string($con,$_POST["shortDesc"]);
	$sale_price		= $price;
	$displayFront	= 0;


	if(isset($_POST["displayFront"]))
	{
		$displayFront = 1;
	}
	
	$sku			= mysqli_real_escape_string($con,$_POST["sku"]);
	
	$path_to_image_directory = '../images/products/';
	if(isset($_FILES['main_image']) && !empty($_FILES['main_image']['name'])) 
	{     		
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['main_image']['name'])) 
		{ 
			$main_image=upload_image($path_to_image_directory,$_FILES['main_image']['name'],$_FILES['main_image']['tmp_name']);			
		}
	}
		
	//insert to tbl_products
	mysqli_query($con,"update tbl_products set productName='".$productName."',sku='".$sku."',price='".$price."',sale_price='".$sale_price."',updatedOn=NOW(),displayFront='".$displayFront."',main_image='".$main_image."',shortDescription='".$shortDesc."' where productId='".$productId."'") or die(mysqli_error($con));
	

	if($_POST["submit"]=="submit-close")
	{
		echo "<script>location.href = 'manage-addons.php'</script>";
	}
	else
	{
		echo "<script>location.href = 'edit-addon.php?id=$productId'</script>";
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
<!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css"/><![endif]-->
<link href='css/gfonts.css' rel='stylesheet' type='text/css'>

<?php include_once('js-scripts.php'); ?>

<style>
ul.options li:before{
	content: "\f00d";
	font-family:"FontAwesome";
	cursor:pointer;
}
.form-actions{
	padding:4px 16px 0px;
}
#tab1 .control-label{
	float:none !important;
}
#tab1 .controls{
	margin-left:0px !important;
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
				    	<a href="index.php"><h5>Dashboard</h5></a>				    	
			    	</div>
			    </div>
			    <!-- /page header -->
	                <form id="validate" class="form-horizontal" id="file-form" action="" enctype="multipart/form-data" method="post">
						<div class="widget">
	                        <div class="tabbable"><!-- default tabs -->
	                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1"  data-toggle="tab">General</a></li>	                                
                                    <div class="form-actions align-right">
										<button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
										<button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
									</div>
	                            </ul>
                                <div class="tab-content">                                
                                    <!-- Tab 1 starts here -->
	                                <div class="tab-pane <?php if(!isset($_SESSION["tab"]) || $_SESSION["tab"]=="Contact") echo "active";?>" id="tab1">                                    
									<fieldset>
									<!-- Form validation -->
									<div class="navbar"><div class="navbar-inner"><h6>Product Details</h6></div></div>                                
									<div class="row-fluid">
										<div class="span6">
										<div class="widget well">
											<div class="control-group">
												<label class="control-label">Product Name: <span class="text-error">*</span></label>
												<div class="controls">
													<input type="text" value="<?php echo $productName;?>" class="validate[required] input-xlarge" name="productName" id="productName"/>
												</div>
											</div>
											<!--<div class="control-group">
												<label class="control-label">Category: <span class="text-error">*</span></label>
												<div class="controls">
													<ul class="options">
													</ul>
													<select name="category" id="category" data-placeholder="Choose Category..." class="validate[required] select" data-prompt-position="topLeft:-1,-5">
													<option value=""></option>
												<?php 
												$rslt=mysqli_query($con,"SELECT t1.id AS catId,
	TRIM(LEADING '-> ' FROM CONCAT(IFNULL(t4.categoryName, ''), '-> ', IFNULL(t3.categoryName, ''), '-> ', IFNULL(t2.categoryName, ''), '-> ', IFNULL(t1.categoryName, ''))) AS parentCategory 
	FROM tbl_category t1 
	LEFT JOIN tbl_category t2 ON t1.parentId=t2.id 
	LEFT JOIN tbl_category t3 ON t2.parentId=t3.id 
	LEFT JOIN tbl_category t4 ON t3.parentId=t4.id
	WHERE t1.activeStatus=1
	ORDER BY parentCategory");
												while($row=mysqli_fetch_array($rslt))
												{
												?>			                                            
														<option value="<?php echo $row["catId"];?>"><?php echo $row["parentCategory"];?></option>
												<?php } ?>
													</select>
												</div>
											</div>-->
											
											<!--<div class="control-group">
												<label class="control-label">Occasion:</label>
												<div class="controls">
													<select name="occasion" data-placeholder="Choose Occasion..." class="validate[] select" data-prompt-position="topLeft:-1,-5">
														  <option value=""></option>
														<?php 
															$rslt=mysqli_query($con,"SELECT * from tbl_occasions where activeStatus=1");
															while($row=mysqli_fetch_array($rslt))
															{
														?>			                                            
														<option value="<?php echo $row["id"];?>"><?php echo $row["occasion"];?></option>
														<?php } ?>                                           
													</select>
												</div>
											</div>-->
											<div class="control-group">
												<label class="control-label">Sale Price:</label>
												<div class="controls">
													<input type="text" value="<?php echo $price;?>"  class="validate[custom[number]] input-medium" name="price" id="price"/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">SKU <i class="ico-question-sign popover-test left"  data-trigger="hover" title="SKU" data-content="Stock Keeping Unit"></i></label>
												<div class="controls">
													<input type="text" value="<?php echo $sku;?>" class="validate[] input-xlarge" name="sku" id="sku"/>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label"></label>
												<div class="controls">													
													<label class="radio inline">
														<input class="validate[] styled" <?php if($displayFront==1) echo"checked"; ?> type="checkbox" name="displayFront" id="displayFront" value="1" data-prompt-position="topLeft:-1,-5"/>
														Show on Front End
													</label>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Image:</label>
												<div class="controls">
													<?php if(!empty($main_image)){?>
														<img src="../images/products/<?php echo $main_image;?>" width="120px;" />
													<?php }?>
													<input type="file" class="validate[custom[images]]" name="main_image" id="main_image"/>
												</div>
											</div>
										</div>
										</div>
										<div class="span6 details">
										<div class="widget well">
											<div class="control-group">
												<label class="control-label">Short Description:</label>
												<div class="controls">
													<textarea rows="5" cols="5" name="shortDesc" class="validate[] span12"><?php echo $shortDesc;?></textarea></div>
											</div>	                                                                                            
										
										</div>
										</div>
									</div>
									<!-- /form validation -->
									</fieldset>
                                    </div>     
																
	                            </div>
	                        </div> <?php unset($_SESSION["tab"]);?>
	                    </div>
					</form>
            </div><!-- /content wrapper -->
        </div><!-- /content -->
	</div><!-- /content container -->

	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
<script type="text/javascript">	
	CKEDITOR.replace('shortDesc', {height: '130px'});
</script>
</body>
</html>
