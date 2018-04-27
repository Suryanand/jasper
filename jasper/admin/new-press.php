<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php");


if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	//header('location: index.php');
}

// Events & Events Form Submit
if(isset($_POST["submit"]))
{
	$title=mysqli_real_escape_string($con,$_POST["title"]);
	$details=mysqli_real_escape_string($con,$_POST["details"]);
	$publishDate=date("Y-m-d", strtotime($_POST["publishDate"]));
	$postType=mysqli_real_escape_string($con,$_POST["postType"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$category=mysqli_real_escape_string($con,$_POST["category"]);
	$seoName=$title;
	
	$link="";
	if($postType==2)
	{
		$link=$_POST["link"];
	}
	elseif($postType==3)
	{
		$link="";
		$path_to_image_directory="../uploads/pdf/";
		if(isset($_FILES['pdf']) && !empty($_FILES['pdf']['name'])) 
		{     		
			if(preg_match('/[.](pdf)|(PDF)|(doc)|(DOC)|(docx)|(DOCX)$/', $_FILES['pdf']['name'])) 
			{ 
				$link=upload_image($path_to_image_directory,$_FILES['pdf']['name'],$_FILES['pdf']['tmp_name']);	
			}
		}		
	}
	
	$arabicDoc="";
	$path_to_image_directory="../uploads/pdf/";
		if(isset($_FILES['arabicDoc']) && !empty($_FILES['arabicDoc']['name'])) 
		{     		
			if(preg_match('/[.](pdf)|(PDF)|(doc)|(DOC)|(docx)|(DOCX)$/', $_FILES['arabicDoc']['name'])) 
			{ 
				$arabicDoc=upload_image($path_to_image_directory,$_FILES['arabicDoc']['name'],$_FILES['arabicDoc']['tmp_name']);	
			}
		}
	
	$newsImage="";
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/news");
	if($image["newsImage"]){
		$upload = $image->upload(); 
		if($upload){
			$newsImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
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
	
	// insert into table
	mysqli_query($con,"INSERT INTO tbl_press (title,category,image, publishDate, postType, link, description, updatedOn, titleTag, urlName, metaDescription, metaKeywords,arabicDoc) VALUES ('$title', '$category','$newsImage','$publishDate', '$postType', '$link', '$details', NOW(), '$titleTag', '$urlName', '$metaDescription', '$metaKeywords','$arabicDoc')");
	
	$rslt=mysqli_query($con,"select id from tbl_press order by id desc limit 1");
	$row=mysqli_fetch_assoc($rslt);

	// set response alert
	$_SESSION["response"]="Press Release Saved";
	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-press.php';</script>";
	else
		echo "<script>location.href = 'edit-press.php?id=".$row["id"]."';</script>";
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

				<h5 class="widget-name"><i class="icon-tasks"></i> New Press Release<a href="manage-press.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
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
	                                    <input type="text" value="" class="validate[required] input-xxlarge" name="title" id="title"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Category: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="category" class="styled validate[]">
										<option value="">Choose Category</option>
											<?php /*
											$rslt=mysqli_query($con,"select * from tbl_press_category");
											while($row=mysqli_fetch_assoc($rslt))
											{
											?>
											<option value="<?php echo $row["id"];?>"><?php echo $row["category"];?></option>
											<?php }*/?>
										</select>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Details:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="details" class="validate[] span12"></textarea>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
		                            <label class="control-label">Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo date('d-m-Y');?>" class="datepicker validate[required] input-xlarge"  name="publishDate" id="publishDate"/>
		                            </div>
		                        </div>
								<div class="control-group">
	                                <label class="control-label">Post Type:</label>
									
	                                <div class="controls">
	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge" data-prompt-position="">
											<option value="1">Text</option>
											<option value="2">URL</option>
											<option value="3">PDF</option>
	                                    </select>
	                                </div>
	                            </div>
								 <div class="control-group ">
	                                <label class="control-label">Upload Image: <?php echo "w:200px X h:200px";?></label>
	                                <div class="controls">
	                                    <input type="file" name="newsImage" id="newsImage" class="">
	                                </div>                                    
	                            </div>
                                <div class="control-group newsImg hide">
	                                <label class="control-label">Upload PDF: <span class="text-error">*</span><br></label>
	                                <div class="controls">
	                                    <input type="file" name="pdf" id="pdf" class="validate[]">
	                                </div>                                    
	                            </div>
								<div class="control-group newsVdo" style="display:none;">
	                                <label class="control-label">URL: 
									</label>
									
									<div class="controls">
										<input type="text" value="" disabled class="validate[] input-xxlarge" name="link" id="link"/>
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">Arabic Document <br>(PDF or doc/docx)</label>
	                                <div class="controls">										
	                                    <input type="file" name="arabicDoc" id="arabicDoc" class="validate[]">
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
	                                    <input type="text" value="" maxlength="65" class="validate[] input-xlarge " name="urlName" id="urlName"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" value="" maxlength="65" class="validate[] input-xlarge " name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"></textarea>
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
