<?php 
include("session.php"); /*Check for session is set or not if not redirect to login  */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index  */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 
// new user submit
if(isset($_POST["submit"]))
{
	$curriculum 	= mysqli_real_escape_string($con,$_POST["curriculum"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);

	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_curriculum where curriculum='$curriculum'");
	if(mysqli_num_rows($rslt)>0) 
	{/* email already registered */
		$_SESSION["response"]="curriculum already created";
	}
	else
	{	
	
	$imageName="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/curriculum");
	if($image["image"]){
		$upload = $image->upload(); 
		if($upload){
			$imageName=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	$titleTag		= mysqli_real_escape_string($con,$_POST["titleTag"]);						
	$metaDescription= mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords	= mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName		= mysqli_real_escape_string($con,$_POST["urlName"]);	
	if(empty($urlName))
	{
		$urlName=$curriculum;
	}
	$urlName = set_url_name($urlName);
	
	mysqli_query($con,"insert into tbl_curriculum (curriculum,description,image,titleTag,metaDescription,metaKeywords,urlName)values('".$curriculum."','".$description."','".$imageName."','$titleTag','$metaDescription','$metaKeywords','$urlName')") or die(mysqli_error($con));
	$rslt=mysqli_query($con,"select id from tbl_curriculum order by id desc limit 1");
	$row=mysqli_fetch_assoc($rslt);
	$id=$row['id'];
					

	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-curriculum.php'</script>";
	else
		echo "<script>location.href = 'edit-curriculum.php?id=".$id."'</script>";
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
				<h5 class="widget-name"><i class="icon-th"></i>New Curriculum
                <a href="manage-curriculum.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a>
                </h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="tabbable"><!-- default tabs -->
	    	                <ul class="nav nav-tabs">
	                        	<li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
								<div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
								</div>
							</ul>
                            <div class="tab-content">
							<div class="tab-pane active" id="tab1">
							<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Curriculum: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xlarge" name="curriculum" id="curriculum"/>					
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
	                                <label class="control-label">Description:</label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="description" class="validate[required] span12"></textarea>
	                                </div>
	                            </div>                                
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br> w:360px &nbsp;&nbsp; h:190px</label>
	                                <div class="controls">
										<input type="file" name="image" id="image" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								
                                <div class="control-group">
                                        <label class="control-label">SEO Name:<i class="ico-question-sign popover-test left"  data-trigger="hover" title="SEO Name" data-content="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique."></i></label>
                                        <div class="controls">
                                            <input type="text" value=""  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
                                        </div>
                                    </div>
								<div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text"  maxlength="65" class="validate[] input-xlarge" name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[] span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"></textarea>
	                                </div>
	                            </div>
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
	                            </div>
	                        </div>
                        </div> 
						<div class="tab-pane" id="tab2">You Need to save before add image
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
	<script type="text/javascript">	
	CKEDITOR.replace('description');
	</script>
</body>
</html>
