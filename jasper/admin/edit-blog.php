<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php");
if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
$id=$_GET["id"];
$rslt=mysqli_query($con,"select * from tbl_articles where id='".$id."'");
$row=mysqli_fetch_assoc($rslt);
$title=$row["title"];
$description=$row["description"];
$category=$row["category"];
$publishDate=$row["publishDate"];
$postType=$row["postType"];
$activeStatus=$row["activeStatus"];
$newsImage=$row["image"];
$link=$row["link"];
$urlName		= $row["urlName"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];
$author	= $row["author"];

// News & Events Form Submit
if(isset($_POST["submit"]))
{
	$title=mysqli_real_escape_string($con,$_POST["title"]);
	$details=mysqli_real_escape_string($con,$_POST["details"]);
	$publishDate=date("Y-m-d", strtotime($_POST["publishDate"]));
	$postType=mysqli_real_escape_string($con,$_POST["postType"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$category=mysqli_real_escape_string($con,$_POST["category"]);
	$author=mysqli_real_escape_string($con,$_POST["author"]);
	$seoName=$title;
	
	if($postType==2)
	{
		$link=$_POST["link"];
	}
	else
	{
		$path_to_image_directory="../uploads/pdf/";
		if(isset($_FILES['pdf']) && !empty($_FILES['pdf']['name'])) 
		{     		
			if(preg_match('/[.](pdf)|(PDF)|(doc)|(docx)$/', $_FILES['pdf']['name'])) 
			{ 
				$link=upload_image($path_to_image_directory,$_FILES['pdf']['name'],$_FILES['pdf']['tmp_name']);	
			}
		}
	}
	
	// top banner upload starts
	//require "new-top-banner-upload.php";
	// top banner upload ends
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$title;
	$urlName = set_url_name($urlName);
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/blog");
	if($image["newsImage"]){
		$upload = $image->upload(); 
		if($upload){
			$newsImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	// insert into table
	mysqli_query($con,"UPDATE tbl_articles set title='".$title."',image='".$newsImage."',category='$category', publishDate='$publishDate', postType='$postType', link='$link', description='$details', updatedOn=NOW(), titleTag='$titleTag', urlName='$urlName', metaDescription='$metaDescription', metaKeywords='$metaKeywords',author='$author' where id='".$id."'") or die(mysqli_error($con));
	

	// set response alert
	$_SESSION["response"]="Article Saved";
	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-blog.php';</script>";
	else
		echo "<script>location.href = 'edit-blog.php?id=".$id."';</script>";
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

				<h5 class="widget-name"><i class="icon-tasks"></i>Edit Blog<a href="manage-blog.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="tabbable"><!-- default tabs -->
	    	                <ul class="nav nav-tabs">
	                        	<li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
	                            <!--<li><a href="#tab2" data-toggle="tab">Gallery Images</a></li>-->
								<div class="form-actions align-right">
                                    <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
								</div>
							</ul>
                            <div class="tab-content">

                            <div class="tab-pane active" id="tab1">
							<div class="well row-fluid">								
								
								<div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $title;?>" class="validate[required] input-xxlarge" name="title" id="title"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Category: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="category" class="styled">
										<option value="">Choose Category</option>
											<?php 
											$rslt=mysqli_query($con,"select * from tbl_articles_category");
											while($row=mysqli_fetch_assoc($rslt))
											{
											?>
											<option value="<?php echo $row["id"];?>" <?php if($category==$row["id"]) echo "selected";?>><?php echo $row["category"];?></option>
											<?php }?>
										</select>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Details:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="details" class="validate[] span12"><?php echo $description;?></textarea>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
		                            <label class="control-label">Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo $publishDate;?>" class="datepicker validate[required] input-xlarge"  name="publishDate" id="publishDate"/>
		                            </div>
		                        </div>
								<div class="control-group hide">
	                                <label class="control-label">Post Type:</label>
									
	                                <div class="controls">
	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge" data-prompt-position="">
											<option value="1" <?php if($postType==1) echo "selected";?>>Text</option>
											<option value="2" <?php if($postType==2) echo "selected";?>>URL</option>
											<option value="3" <?php if($postType==3) echo "selected";?>>PDF</option>
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group ">
	                                <label class="control-label">Upload Image:</label>
	                                <div class="controls">
										<?php if(!empty($newsImage)){?><img src="../uploads/images/blog/<?php echo $newsImage;?>" width="70"><?php }?>
	                                    <input type="file" name="newsImage" id="newsImage" class="">
	                                </div>                                    
	                            </div>
								<div class="control-group newsImg" <?php if($postType!=3) echo "style='display:none;'";?>>
	                                <label class="control-label">Upload PDF: <span class="text-error">*</span><br></label>
	                                <div class="controls">
										<a href="../uploads/pdf/<?php echo $link;?>"><i class="icon-download" style="margin-top: 10px;"></i>&nbsp;&nbsp;&nbsp;<?php echo $link;?></a>
	                                    <input type="file" name="pdf" id="pdf" class="validate[]">
	                                </div>                                    
	                            </div>
								<div class="control-group newsVdo" <?php if($postType!=2) echo "style='display:none;'";?>>
	                                <label class="control-label">URL: 
									</label>
									
									<div class="controls">
										<input type="text" value="<?php echo $link;?>" class="validate[] input-xxlarge" name="link" id="link"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Author: 
									</label>
									
									<div class="controls">
										<input type="text" value="<?php echo $author;?>" class="validate[] input-xxlarge" name="author" id="author"/>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">
										<label class="radio inline">
											<input class="styled" type="radio" name="activeStatus" id="activeStatus" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" checked name="activeStatus" id="activeStatus" value="1" data-prompt-position="topLeft:-1,-5"/>
											Publish
										</label>
	                                </div>
	                            </div>
                                <!-- seo fields -->
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
                                <!-- /seo fields -->
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
	                            </div>

	                        </div>
							</div>
							<div class="tab-pane" id="tab2">
							You Need to save before add image
							</div>
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
	
	function getType(postType)
	{
		if(postType==3)
		{
			$(".newsImg").show();
			$("#pdf").prop("disabled",false);
			$(".newsVdo").hide();
			$("#link").prop("disabled",true);
		}
		else if(postType==2){
			$(".newsImg").hide();
			$("#pdf").prop("disabled",true);
			$(".newsVdo").show();
			$("#link").prop("disabled",false);
		}
		else{
			$(".newsImg").hide();
			$(".newsVdo").hide();
		}
	}
	</script>
</body>
</html>