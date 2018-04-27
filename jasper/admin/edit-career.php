<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); /* Geting logged in user details*/


if($userType==2 && !isset($m_career)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
$editCareerId=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_career where careerId='$editCareerId'");
$row=mysqli_fetch_array($rslt);
$postTitle		= $row['postTitle'];
$postDetails	= $row['postDetails'];
$postDate		= $row['postDate'];
$postExpire		= $row["postExpire"];
$postCategory	= $row["postCategory"];
$postRequirements = $row["postRequirements"];
$experience 	= $row["experience"];
$location		 = $row["location"];
$package		 = $row["package"];
$qualification = $row["qualification"];
$urlName		= $row["urlName"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];

if(isset($_POST["submit"]))
{
	$postDate	= date("Y-m-d", strtotime($_POST["postDate"]));
	$postTitle		= mysqli_real_escape_string($con,$_POST["postTitle"]);
	$postCategory		= 0;
	$postDetails	= mysqli_real_escape_string($con,$_POST["details"]);
	$postRequirements	= mysqli_real_escape_string($con,$_POST["postRequirements"]);
	$location	= mysqli_real_escape_string($con,$_POST["location"]);
	$qualification	= mysqli_real_escape_string($con,$_POST["qualification"]);
	$package	= mysqli_real_escape_string($con,$_POST["package"]);
	$experience=mysqli_real_escape_string($con,$_POST["experience"]);
	$postExpire=0;
	if(isset($_POST["postExpire"]))
		$postExpire=1;
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$postTitle;
	$seoName = set_url_name($urlName);
	
	/* update table*/
	mysqli_query($con,"update tbl_career set postTitle='$postTitle',postDetails='$postDetails',postDate='$postDate',postRequirements='$postRequirements',postExpire='$postExpire',updatedOn=NOW(),package='$package',experience='$experience',qualification='$qualification',location='$location',urlName='".$seoName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."' where careerId='$editCareerId'") or die(mysql_error());
	$_SESSION["response"]='Job Updated Successfully';
	echo "<script>location.href = 'manage-career.php'</script>;";																		
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

			    <!-- Page header -->
			    <br>
			    <!-- /page header -->
				<h5 class="widget-name"><i class="icon-user-md"></i>Careers <a href="manage-career.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">
							<!-- Select and display News and Event details-->                            								
								<div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $postTitle;?>" class="validate[required] span12" name="postTitle" id="postTitle"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
                                	<label class="control-label">Post Category: <span class="text-error">*</span></label>
                                	<div class="controls">
										<select name="postCategory" id="postCategory" data-placeholder="Choose Category..." class="validate[] span4 select" data-prompt-position="topLeft:-1,-5">
										<?php
										$rslt=mysqli_query($con,"select * from tbl_career_categories");
										while($row=mysqli_fetch_array($rslt))
										{
										?>
	                                        <option value="<?php echo $row["id"];?>" <?php if($postCategory==$row["id"]) echo "selected";?>><?php echo $row["category"];?></option>
                                        <?php } ?>
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Details: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="details" class="validate[required] span12"><?php echo $postDetails;?></textarea>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Location:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $location;?>" class="validate[] input-xlarge" name="location" id="location"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Education:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $qualification;?>" class="validate[] input-xlarge" name="qualification" id="qualification"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Experience:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $experience;?>" class="validate[] input-xlarge" name="experience" id="experience"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Package:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $package;?>" class="validate[] input-xlarge" name="package" id="package"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Requirements: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="postRequirements" class="validate[required] span12"><?php echo $postRequirements;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
		                            <label class="control-label">Show Till: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $postDate;?>" name="postDate" id="postDate"/>
		                            </div>
		                        </div>
								<div class="control-group hide">
		                            <label class="control-label">Check Expiry</label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="checkbox" name="postExpire" <?php if($postExpire==1) echo "checked";?> value="1" data-prompt-position="topLeft:-1,-5"/>										
										</label>
	                                </div>
		                        </div>
								
								<div class="navbar"><div class="navbar-inner"><h6>SEO</h6></div></div>
								<div class="control-group">
	                                <label class="control-label">URL Name: <br>(only lowercase letters and hyphen)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $urlName;?>" maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $titleTag;?>" maxlength="65" class="validate[] input-xlarge " name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"><?php echo $metaDescription;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"><?php echo $metaKeywords;?></textarea>
	                                </div>
	                            </div>
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>

	                        </div>

	                    </div>
	                    <!-- /form validation -->

	                </fieldset>
				</form>
				<!-- /form validation -->
                
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
	CKEDITOR.replace('details');
	CKEDITOR.replace('postRequirements');
	</script>
</body>
</html>
