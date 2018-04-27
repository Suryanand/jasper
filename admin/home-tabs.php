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

// new user submit
if(isset($_POST["submit"]))
{
	$categoryName 	= mysqli_real_escape_string($con,$_POST["category"]);
	$parentCategory	= 0;
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	$showTopMenu=0;
	if(isset($_POST["showTopMenu"]))
		$showTopMenu=1;
	
	// Check whether the category already registered 
	$rslt=mysqli_query($con,"select * from tbl_category where categoryName='$categoryName'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="Category already created";
	}
	else
	{	
	
	if(isset($_FILES['categoryImage']) && !empty($_FILES['categoryImage']['name'])) 
	{     
		$path_to_image_directory = '../images/category/';
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['categoryImage']['name'])) 
		{ 
			$path = $_FILES['categoryImage']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$source = $_FILES['categoryImage']['tmp_name'];
			$categoryImage = "categoryImage-"; //Image name
			// Make sure the fileName is unique
			$count = 1;
			while (file_exists($path_to_image_directory.$categoryImage.$count.".".$ext))
			{
				$count++;	
			}
			$categoryImage = $categoryImage . $count.".".$ext;
			$target = $path_to_image_directory . $categoryImage;
			if(!file_exists($path_to_image_directory)) 
			{
				if(!mkdir($path_to_image_directory, 0777, true)) 
				{
					die("There was a problem. Please try again!");
				}
			}        
			move_uploaded_file($source, $target);
		}
	}
	else
	{
		$categoryImage="";
	}
	
	if(isset($_FILES['menuImage']) && !empty($_FILES['menuImage']['name'])) 
	{     
		$path_to_image_directory = '../images/category/';
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['menuImage']['name'])) 
		{ 
			$path = $_FILES['menuImage']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$source = $_FILES['menuImage']['tmp_name'];
			$menuImage = "categoryMenu-"; //Image name
			// Make sure the fileName is unique
			$count = 1;
			while (file_exists($path_to_image_directory.$menuImage.$count.".".$ext))
			{
				$count++;	
			}
			$menuImage = $menuImage . $count.".".$ext;
			$target = $path_to_image_directory . $menuImage;
			if(!file_exists($path_to_image_directory)) 
			{
				if(!mkdir($path_to_image_directory, 0777, true)) 
				{
					die("There was a problem. Please try again!");
				}
			}        
			move_uploaded_file($source, $target);
		}
	}
	else
	{
		$menuImage="";
	}
		mysqli_query($con,"insert into tbl_category (`categoryName`,`parentId`,`description`,`image`,menuImage,`activeStatus`,showTopMenu,`createdOn`,`createdBy`,`lastUpdate`,`lastUpdateBy`)values('".$categoryName."','".$parentCategory."','".$description."','".$categoryImage."','".$menuImage."','".$activeStatus."','".$showTopMenu."',NOW(),'".$CurrentUserId."',NOW(),'".$CurrentUserId."')") or die(mysqli_error($con));
		
	//fetch current product id
	$rslt			= mysqli_query($con,"select categoryId from tbl_category order by categoryId desc limit 1");
	$row			= mysqli_fetch_assoc($rslt);
	$categoryId		= $row["categoryId"];
	
	//seo details
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$seoName		= mysqli_real_escape_string($con,$_POST["seoName"]);
	$seoFor			= "category-".$categoryId;
	//seo details  - insert to table
	mysqli_query($con,"insert into tbl_seo (seoName,titleTag,metaDescription,metaKeywords,seoFor)values('".$seoName."','".$titleTag."','".$metaDescription."','".$metaKeywords."','".$seoFor."')") or die(mysqli_error($con));	

		if($_POST["submit"]=="submit-close")
		{
		$_SESSION["response"]="Category Created";
		echo "<script>location.href = 'manage-category.php'</script>";
		}
		else
		{
			echo "<script>location.href = 'edit-category.php?id=$categoryId'</script>";
		}
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
	                        <div class="navbar"><div class="navbar-inner"><h6>Home Tabs</h6></div></div>
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">New Arrivals</a></li>
	                                <li><a href="#tab2" data-toggle="tab">Best Sellers</a></li>
	                                <li><a href="#tab3" data-toggle="tab">On Sale</a></li>
                                    <div class="form-actions align-right">
                            <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                            <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
                        </div>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane active" id="tab1">
                           <div class="well row-fluid">                            	                                                                
								<div class="control-group span4">
								<?php 
								$i=0;
								$rslt=mysqli_query($con,"select * from tbl_products where deleteStatus=0 and featured=1");
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
								?>
	                                <label class="control-label" style="width:200px;"><?php echo $row["productName"];?></label>
	                                <div class="controls">
										<label class="radio inline"  style="margin-left:20px;">
											<input class="styled" type="checkbox" checked name="product<?php echo $row["productId"];?>"  value="1" data-prompt-position="topLeft:-1,-5"/>										
										</label>
	                                </div><br>
								<?php 
								if($i%10==0)
									echo '</div><div class="control-group span4">';
								}								
								?>
	                            </div>

	                        </div>
                            
                            </div>
                            <!--Tab 2-->
                            <div class="tab-pane" id="tab2">
                                <div class="well row-fluid">                            	                                                                
								<div class="control-group span4">
								<?php 
								$i=0;
								$rslt=mysqli_query($con,"select * from tbl_products where deleteStatus=0 and featured=1");
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
								?>
	                                <label class="control-label" style="width:200px;"><?php echo $row["productName"];?></label>
	                                <div class="controls">
										<label class="radio inline"  style="margin-left:20px;">
											<input class="styled" type="checkbox" checked name="product<?php echo $row["productId"];?>"  value="1" data-prompt-position="topLeft:-1,-5"/>										
										</label>
	                                </div><br>
								<?php 
								if($i%10==0)
									echo '</div><div class="control-group span4">';
								}								
								?>
	                            </div>

	                        </div>
                            </div>
                            <!--Tab 3-->
                            <div class="tab-pane" id="tab3">
                            <div class="well row-fluid">                            	                                                                
								<div class="control-group span4">
								<?php 
								$i=0;
								$rslt=mysqli_query($con,"select * from tbl_products where deleteStatus=0 and hot=1");
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
								?>
	                                <label class="control-label" style="width:200px;"><?php echo $row["productName"];?></label>
	                                <div class="controls">
										<label class="radio inline"  style="margin-left:20px;">
											<input class="styled" type="checkbox" checked name="product<?php echo $row["productId"];?>"  value="1" data-prompt-position="topLeft:-1,-5"/>										
										</label>
	                                </div><br>
								<?php 
								if($i%10==0)
									echo '</div><div class="control-group span4">';
								}								
								?>
	                            </div>

	                        </div>
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
