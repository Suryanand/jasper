<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php");


if($userType==2 && !isset($m_newsEvents)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

// News & Events Form Submit
if(isset($_POST["submit"]))
{
	$type=mysqli_real_escape_string($con,$_POST["type"]);
	$title=mysqli_real_escape_string($con,$_POST["title"]);
	$details=mysqli_real_escape_string($con,$_POST["details"]);
	$eventDate=date("Y-m-d", strtotime($_POST["eventDate"]));
	$postType=mysqli_real_escape_string($con,$_POST["postType"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);
	$seoName=$title;
	$eventVideo="";
	$filename="";
	if(isset($_POST["eventVideo"]))
	{
		$eventVideo=$_POST["eventVideo"];
	}
	else
	{
		$eventImage="";
		$image = new UploadImage\Image($_FILES);
		$image->setLocation("../uploads/images/news");
		if($image["eventImage"]){
			$upload = $image->upload(); 
			if($upload){
				$eventImage=$image->getName().".".$image->getMime();			
			}else{
				echo $image["error"]; 
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
	
	// insert into table
	mysqli_query($con,"insert into tbl_news_events (eventType,eventTitle,eventDetails,eventDate,eventImage,video,postType,activeStatus,createdOn,altTag,urlName,titleTag,metaDescription,metaKeywords)values('".$type."','$title','$details','$eventDate','$eventImage','$eventVideo','$postType','$activeStatus',NOW(),'$altTag','".$urlName."','".$titleTag."','".$metaDescription."','".$metaKeywords."')") or die(mysql_error());
	
	$rslt=mysqli_query($con,"select eventId from tbl_news_events order by eventId desc limit 1");
	$row=mysqli_fetch_assoc($rslt);
	// set response alert
	$_SESSION["response"]="News / Event Saved";
	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-news-events.php';</script>";
	else
		echo "<script>location.href = 'edit-news-events.php?id=".$row["eventId"]."';</script>";
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

				<h5 class="widget-name"><i class="icon-tasks"></i>In the Press<a href="manage-news-events.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
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
	                                <label class="control-label">Type: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" checked name="type" id="news" value="1" data-prompt-position="topLeft:-1,-5"/>
											News
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" name="type" id="event" value="0" data-prompt-position="topLeft:-1,-5"/>
											Event
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xxlarge" name="title" id="title"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Details: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="details" class="validate[required] span12"></textarea>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
		                            <label class="control-label">Event Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" value="<?php echo date('d-m-Y');?>" class="datepicker validate[required] input-xlarge"  name="eventDate" id="eventDate"/>
		                            </div>
		                        </div>
								<div class="control-group hide">
	                                <label class="control-label">Post Type:<i class="ico-question-sign popover-test" title="Post Type" data-trigger="hover" data-content="Image:- Text and image, Video:-Text and Youtube video"></i></label>
									
	                                <div class="controls">
	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge" data-prompt-position="">
											<option value="1">Image</option>
											<option value="2">Video</option>
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group newsImg">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br> <?php echo image_size('news_events');?></label>
	                                <div class="controls">
	                                    <input type="file" name="eventImage" id="eventImage" class="validate[custom[images]]">
										<br><br><label>Alt Tag : <input type="text" value="" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
	                                </div>                                    
	                            </div>
								<div class="control-group newsVdo" style="display:none;">
	                                <label class="control-label">video Link: <i class="ico-question-sign pull-right popover-test" title="YouTube URL" data-content="Copy the URL of your Youtube Video and paste here"></i>
									</label>
									
									<div class="controls">
										<input type="text" value="" disabled class="validate[] input-xxlarge" name="eventVideo" id="eventVideo"/>
	                                </div>
	                            </div>
								<!-- top banner 
                      			<?php include("new-top-banner.php");?>-->
                                <!-- /top banner -->
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
		if(postType==1)
		{
			$(".newsImg").show();
			$("#eventImage").prop("disabled",false);
			$(".newsVdo").hide();
			$("#eventVideo").prop("disabled",true);
		}
		else if(postType==2){
			$(".newsImg").hide();
			$("#eventImage").prop("disabled",true);
			$(".newsVdo").show();
			$("#eventVideo").prop("disabled",false);
		}
	}
	</script>
</body>
</html>
