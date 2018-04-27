<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('functions.php');
include('get-user.php'); /* Geting logged in user details*/
if($userType != 1) 
{
	header('location: manage-category.php');
}

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
	$categoryImage="";
	$banner="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/category");
	if($image["categoryImage"]){
		$upload = $image->upload(); 
		if($upload){
			$categoryImage=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}

	$image2 = new UploadImage\Image($_FILES);
	$image2->setLocation("../uploads/images/category");
	if($image2["banner"]){
		$upload = $image2->upload(); 
		if($upload){
			$banner=$image2->getName().".".$image2->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	
	//seo details
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName		= mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
	{
		$urlName=$categoryName;
	}
	$urlName = set_url_name($urlName);
	
	mysqli_query($con,"insert into tbl_category (`categoryName`,`parentId`,`description`,`banner`,menuImage,`activeStatus`,showTopMenu,`createdOn`,`lastUpdate`,urlName,titleTag,metaDescription,metaKeywords)values('".$categoryName."','".$parentCategory."','".$description."','".$categoryImage."','".$banner."','".$activeStatus."','".$showTopMenu."',NOW(),NOW(),'".$urlName."','".$titleTag."','".$metaDescription."','".$metaKeywords."')") or die(mysqli_error($con));
		
	//fetch current product id
	$rslt			= mysqli_query($con,"select id from tbl_category order by id desc limit 1");
	$row			= mysqli_fetch_assoc($rslt);
	$categoryId		= $row["id"];

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
				<h5 class="widget-name"><i class="icon-barcode"></i>New Category <a href="manage-category.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
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
	                                <label class="control-label">Category Name: <span class="text-error">*</span></label>
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
	                                <label class="control-label">Image:<br> <?php echo "w:1350px  h:455px";?></label>
	                                <div class="controls">
										<input type="file" name="categoryImage" id="categoryImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Top Banner:<br> <?php echo "w:2560px  h:900px";?>
									</label>
	                                <div class="controls">
										<input type="file" name="banner" id="menuImage" class="validate[custom[images]]">									
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
								<div class="control-group hide">
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
<script type="text/javascript">	
	CKEDITOR.replace('description', {height: '130px'});
</script>
</body>
</html>
