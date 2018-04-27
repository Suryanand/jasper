<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('functions.php');
include('get-user.php'); /* Geting logged in user details*/
if($userType != 1) 
{
	header('location: manage-occasion.php');
}
//get product image size
$rslt			= mysqli_query($con,"select width,height from image_size where imageName='Occasion'");
$row			= mysqli_fetch_assoc($rslt);
$imageHeight	= $row["height"];
$imageWidth		= $row["width"];

// new user submit
if(isset($_POST["submit"]))
{
	$occasion 	= mysqli_real_escape_string($con,$_POST["category"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$activeStatus	= mysqli_real_escape_string($con,$_POST["active"]);
	$showTopMenu=0;
	if(isset($_POST["showTopMenu"]))
		$showTopMenu=1;
	
	// Check whether the category already registered 
	$rslt=mysqli_query($con,"select * from tbl_occasions where occasion='$occasion'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="Occasion already created";
	}
	else
	{	
	$path_to_image_directory = '../images/category/';
	if(isset($_FILES['categoryImage']) && !empty($_FILES['categoryImage']['name'])) 
	{     		
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['categoryImage']['name'])) 
		{ 
			$categoryImage=upload_image($path_to_image_directory,$_FILES['categoryImage']['name'],$_FILES['categoryImage']['tmp_name']);			
		}
	}
	else
	{
		$categoryImage="";
	}
	
	if(isset($_FILES['menuImage']) && !empty($_FILES['menuImage']['name'])) 
	{     
		if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['menuImage']['name'])) 
		{ 
			$menuImage=upload_image($path_to_image_directory,$_FILES['menuImage']['name'],$_FILES['menuImage']['tmp_name']);			
		}
	}
	else
	{
		$menuImage="";
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
	
	mysqli_query($con,"insert into tbl_occasions (`occasion`,`description`,`banner`,menuImage,`activeStatus`,showTopMenu,`createdOn`,`lastUpdate`,urlName,titleTag,metaDescription,metaKeywords)values('".$occasion."','".$description."','".$categoryImage."','".$menuImage."','".$activeStatus."','".$showTopMenu."',NOW(),NOW(),'".$urlName."','".$titleTag."','".$metaDescription."','".$metaKeywords."')") or die(mysqli_error($con));
		
	//fetch current product id
	$rslt			= mysqli_query($con,"select id from tbl_occasions order by id desc limit 1");
	$row			= mysqli_fetch_assoc($rslt);
	$categoryId		= $row["id"];

	if($_POST["submit"]=="submit-close")
	{
		$_SESSION["response"]="Occasion Created";
		echo "<script>location.href = 'manage-occasion.php'</script>";
	}
	else
	{
		echo "<script>location.href = 'edit-occasion.php?id=$categoryId'</script>";
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
	                        <div class="navbar"><div class="navbar-inner"><h6>New Occasion</h6></div></div>
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
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="category" id="category"/>					
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
	                                    <textarea rows="5" cols="5" name="description" class="validate[] span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Occasion page banner:<br> w:<?php echo "700";?>px &nbsp;&nbsp; h:<?php echo "250";?>px</label>
	                                <div class="controls">
										<input type="file" name="categoryImage" id="categoryImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Menu Image:<br> w:<?php echo "270";?>px &nbsp;&nbsp; h:<?php echo "270";?>px
									</label>
	                                <div class="controls">
										<input type="file" name="menuImage" id="menuImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								
                                <div class="control-group">
	                                <label class="control-label">Status:
									<i class="ico-question-sign popover-test left"  data-trigger="hover" title="Status" data-content="Show in store front or not"></i></label>
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
								<div class="control-group">
	                                <label class="control-label">Show on Top Menu:</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="checkbox" name="showTopMenu"  value="1" data-prompt-position="topLeft:-1,-5"/>										
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
                                            <input type="text" value=""  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Title Tag:<br>(Max 65 Characters)</label>
                                        <div class="controls">
                                            <input type="text" value=""  maxlength="65" class="validate[] input-xxlarge" name="titleTag" id="titleTag"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Description:<br>(Max 170 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaDescription" maxlength="250"  name="metaDescription" class="validate[] span12"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Meta Keywords:<br>(Max 250 Characters)</label>
                                        <div class="controls">
                                            <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Tab 3-->
                            							
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
