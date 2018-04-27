<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('functions.php');
include('get-user.php'); /* Geting logged in user details*/
if($userType != 1) 
{
	header('location: manage-occasion.php');
}
$editId	= $_GET["id"];

include('get-user.php'); /* Geting logged in user details*/
//get product image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Occasion'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];

//select category to be editted
$rslt=mysqli_query($con,"select * from tbl_occasions where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-occasion.php');
}
$row=mysqli_fetch_assoc($rslt);
$occasion	= $row["occasion"];
$description	= $row["description"];
$activeStatus	= $row["activeStatus"];
$categoryImage	= $row["banner"];
$menuImage		= $row["menuImage"];
$showTopMenu	= $row["showTopMenu"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];
$urlName		= $row["urlName"];


// new user submit
if(isset($_POST["submit"]))
{
	$occasion 	= mysqli_real_escape_string($con,$_POST["category"]);
	$parentCategory	= 0;
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	$showTopMenu=0;
	if(isset($_POST["showTopMenu"]))
		$showTopMenu=1;
	
	{	
	
	$path_to_image_directory = '../images/category/';
	if(isset($_FILES['categoryImage']) && !empty($_FILES['categoryImage']['name'])) 
	{     		
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['categoryImage']['name'])) 
		{ 
			$categoryImage=upload_image($path_to_image_directory,$_FILES['categoryImage']['name'],$_FILES['categoryImage']['tmp_name']);			
		}
	}
	
	if(isset($_FILES['menuImage']) && !empty($_FILES['menuImage']['name'])) 
	{     
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['menuImage']['name'])) 
		{ 
			$menuImage=upload_image($path_to_image_directory,$_FILES['menuImage']['name'],$_FILES['menuImage']['tmp_name']);			
		}
	}
	
	
	//seo details
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName		= mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
	{
		$urlName=$occasion;
	}
	$urlName = set_url_name($urlName);
	
	
		mysqli_query($con,"update tbl_occasions set occasion='".$occasion."',description='".$description."',banner='".$categoryImage."',menuImage='".$menuImage."',showTopMenu='".$showTopMenu."',activeStatus='".$activeStatus."',lastUpdate=NOW(),urlName='".$urlName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."' where id='".$editId."'") or die(mysqli_error($con));
				
		if($_POST["submit"]=="submit-close")
		{
		$_SESSION["response"]="Occasion Created";
		echo "<script>location.href = 'manage-occasion.php'</script>";exit();
		}
		else
		{
			echo "<script>location.href = 'edit-occasion.php?id=$editId'</script>";exit();
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
<style>
.form-actions{
	padding:4px 16px 0px;
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
			    <br>
			    <!-- /page header -->


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Edit Occasion</h6></div></div>
                            <div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li><a href="#tab1" data-toggle="tab">General</a></li>
	                                <li><a href="#tab2" data-toggle="tab">SEO</a></li>
                                    <div class="form-actions align-right">
                            <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                            <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
                        </div>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane active" id="tab1">     
	                    	<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Occasion Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $occasion; ?>" class="validate[required] input-xlarge" name="category" id="category"/>					
										<?php if(isset($_SESSION["response"])) /* if category already registered */
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
	                                <label class="control-label">Description</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="description" class="validate[] span12"><?php echo $description; ?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Occasion page banner:<br> w:<?php echo "700";?>px &nbsp;&nbsp; h:<?php echo "250";?>px</label>
	                                <div class="controls">
                                    <?php if(!empty($categoryImage))
									{?>
                                    	<img src="../images/category/<?php echo $categoryImage; ?>" width="75" height="100" />
                                    <?php } 
									else
									{
									?>
                                    	<img src="category/default-category.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="categoryImage" id="categoryImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Menu Image:<br> w:<?php echo "270";?>px &nbsp;&nbsp; h:<?php echo "270";?>px</label>
	                                <div class="controls">
                                    <?php if(!empty($menuImage))
									{?>
                                    	<img src="../images/category/<?php echo $menuImage; ?>" width="75" height="100" />
                                    <?php } 
									else
									{
									?>
                                    	<img src="category/default-category.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="menuImage" id="menuImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								<!--<div class="control-group">
	                                <label class="control-label">Occasion Page Banner:<br> w:<?php echo "1170";?>px &nbsp;&nbsp; h:<?php echo "420";?>px</label>
	                                <div class="controls">
                                    <?php if(!empty($categoryBanner))
									{?>
                                    	<img src="../images/category/<?php echo $categoryBanner; ?>" width="75" height="100" />
                                    <?php } 
									?>
                                    
										<input type="file" name="categoryBanner" id="categoryBanner" class="validate[custom[images]]">									
	                                </div>
	                            </div>-->
                                <div class="control-group">
	                                <label class="control-label">Status:
									<i class="ico-question-sign popover-test left"  data-trigger="hover" title="Status" data-content="Show in store front or not"></i></label>									
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 1) echo "checked"; ?> name="active"  value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 0) echo "checked"; ?> name="active" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Show on Top Menu:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="checkbox" <?php if($showTopMenu==1) echo "checked";?> name="showTopMenu"  value="1" data-prompt-position="topLeft:-1,-5"/>										
										</label>
	                                </div>
	                            </div>								
	                        </div>
                            </div>
                            <!--Tab 2-->
                            <div class="tab-pane" id="tab2">
                                <div class="row-fluid well">
                                	<div class="control-group">
                                        <label class="control-label">SEO Name:<i class="ico-question-sign popover-test left"  data-trigger="hover" title="SEO Name" data-content="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique."></i></label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $urlName; ?>"  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $titleTag; ?>"  maxlength="65" class="validate[] input-xxlarge" name="titleTag" id="titleTag"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Description:<br>(Max 170 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaDescription" maxlength="250"  name="metaDescription" class="validate[] span12"><?php echo $metaDescription; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Keywords:<br>(Max 250 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"><?php echo $metaKeywords; ?></textarea>
                                        </div>
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
