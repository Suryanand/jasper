<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php");

if($userType==2 && !isset($m_newsEvents)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}
$editEventId=$_GET["id"];
$tableName="tbl_news_events";

$rslt=mysqli_query($con,"select * from tbl_news_events where eventId='$editEventId'");
while($row=mysqli_fetch_array($rslt))
{
	$eventTitle		= $row['eventTitle'];
	$eventDetails	= $row['eventDetails'];
	$eventDate		= $row['eventDate'];
	$eventImage		= $row['eventImage'];
	$type			= $row["eventType"];
	$postType		= $row["postType"];
	$eventVideo		= $row["video"];
	$activeStatus	= $row["activeStatus"];
	$altTag			= $row["altTag"];
	$topBanner		= $row["topBanner"];
	$bannerAlt		= $row["bannerAlt"];
	$bannerText1	= $row["bannerText1"];
	$bannerText2	= $row["bannerText2"];
$urlName		= $row["urlName"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];
	}

//submit news-events form for update
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
	$filename = $eventImage;
	if(isset($_POST["eventVideo"]))
	{
		$eventVideo=$_POST["eventVideo"];
	}
	else
	{
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
	//require "edit-top-banner-upload.php";
	// top banner upload ends

	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
		$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
		$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
		$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
		if(empty($urlName))
			$urlName=$title;
		$urlName = set_url_name($urlName);
	
	//update news-event
	mysqli_query($con,"update tbl_news_events set eventType='".$type."',eventTitle='$title',eventDetails='$details',eventDate='$eventDate',eventImage='$eventImage',video='$eventVideo',postType='$postType',activeStatus='$activeStatus',updatedOn=NOW(),altTag='$altTag',topBanner='".$topBanner."',bannerAlt='".$bannerAlt."',bannerText1='".$bannerText1."',bannerText2='".$bannerText2."',urlName='".$urlName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."' where eventId='$editEventId'") or die(mysql_error());
	

	
	$_SESSION["response"]="News / Event Saved";
	if($_POST["submit"]=="submit-close")
		echo "<script>location.href = 'manage-news-events.php';</script>";
	else
		echo "<script>location.href = 'edit-news-events.php?id=".$editEventId."';</script>";
}


if(isset($_POST["deleteImage"]))
{
	unlink("../uploads/".$eventImage);
	mysqli_query($con,"update tbl_news_events set eventImage='' where eventId='".$editEventId."'") or die(mysql_error());
	echo "<script>location.href = 'edit-news-events.php?id=".$editEventId."'</script>;";																			
}

// Gallery Image order change
if(isset($_POST["order"]))
{
	$_SESSION["tab"] = "Image";	
	$id			= mysqli_real_escape_string($con,$_POST["order"]);
	$imageOrder 	= mysqli_real_escape_string($con,$_POST["imageOrder".$id]);
	$imageTitle=mysqli_real_escape_string($con,$_POST["imageTitle".$id]);
	$altTag=mysqli_real_escape_string($con,$_POST["altTag".$id]);
	echo "update tbl_event_images set altTag='".$altTag."',imageTitle='".$imageTitle."',imageOrder='".$imageOrder."' where imageId='".$id."'";
	die();
	mysqli_query($con,"update tbl_event_images set altTag='".$altTag."',imageTitle='".$imageTitle."',imageOrder='".$imageOrder."' where imageId='".$id."'") or die(mysql_error());
	echo "<script>location.href = 'edit-news-events.php?id=".$editEventId."'</script>;";																			

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
				<h5 class="widget-name"><i class="icon-tasks"></i>News &amp; Events <a href="manage-news-events.php" style="float:right;color:#555 !important;"><i style="padding:4px;" class="icon-arrow-left"></i>Back</a></h5>
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
											<input class="styled" type="radio" <?php if($type == 1) {echo "checked";}?>  name="type" id="news" value="1" data-prompt-position="topLeft:-1,-5"/>
											News
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($type == 0) {echo "checked";}?> name="type" id="event" value="0" data-prompt-position="topLeft:-1,-5"/>
											Event
										</label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $eventTitle;?>" class="validate[required] input-xxlarge" name="title" id="title"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Details: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="details" class="validate[required] span12"><?php echo $eventDetails;?></textarea>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
		                            <label class="control-label">Event Date: <span class="text-error">*</span> </label>
		                            <div class="controls">
		                                <input type="text" class="datepicker validate[required] input-xlarge" value="<?php echo $eventDate;?>" name="eventDate" id="eventDate"/>
		                            </div>
		                        </div>
								<div class="control-group hide">
	                                <label class="control-label">Post Type:<i class="ico-question-sign popover-test" title="Post Type" data-trigger="hover" data-content="Image:- Text and image, Video:-Text and Youtube video"></i></label>
									
	                                <div class="controls">
	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge" data-prompt-position="">
											<option value="1" <?php if($postType==1){ echo "selected";}?>>Image</option>
											<option value="2" <?php if($postType==2){ echo "selected";}?>>Video</option>
	                                    </select>
	                                </div>
	                            </div>
                                <div class="control-group newsImg" style="<?php if($postType!=1){?>display:none;<?php }?>">
	                                <label class="control-label">Upload Image: <span class="text-error">*</span><br> <?php echo image_size('news_events');?></label>
	                                <div class="controls">
                                    	<?php if(!empty($eventImage)) {?>
	                                    <img src="../uploads/images/news/<?php echo $eventImage; ?>" width="70" />
										<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" <?php if($postType!=1){ echo "disabled";}?> name="eventImage" id="eventImage" class="validate[custom[images]]">
	                                	<input type="hidden" name="imageSet" id="imageSet" value="<?php echo $eventImage; ?>"/>
									<br><br><label>Alt Tag : <input type="text" value="<?php echo $altTag;?>" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
                                    </div><br />
	                            </div>
								<div class="control-group newsVdo" style="<?php if($postType!=2){?>display:none;<?php }?>">
	                                <label class="control-label">video Link: <i class="ico-question-sign pull-right popover-test" title="YouTube URL" data-content="Copy the URL of your Youtube Video and paste here"></i>
									</label>
									
									<div class="controls">
										<input type="text" value="<?php echo $eventVideo; ?>" <?php if($postType!=2){ echo "disabled";}?> class="validate[] input-xxlarge" name="eventVideo" id="eventVideo"/>
	                                </div>
	                            </div>
								
								<!-- top banner
                      			<?php include("edit-top-banner.php");?> -->
                                <!-- /top banner -->
								
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 0) {echo "checked";}?>  name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 1) {echo "checked";}?> name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
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
