<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/



// submit form
if(isset($_POST["submit"]))
{
$title=mysqli_real_escape_string($con,$_POST["title"]);
$details=mysqli_real_escape_string($con,$_POST["details"]);
$link=mysqli_real_escape_string($con,$_POST["link"]);

$gTitle=$_POST["gTitle"];
	if(!empty($gTitle))
	{
		mysqli_query($con,"insert into tbl_gallery_titles (galleryTitle)values('$gTitle')") or die(mysql_error());
		$rslt=mysqli_query($con,"select galleryTitleId from tbl_gallery_titles order by galleryTitleId desc limit 1");
		$row=mysqli_fetch_array($rslt);
		$gTitleId=$row['galleryTitleId'];
	}
	else
	{
		$gTitleId=$_POST["albumTitle"];	
	}

mysqli_query($con,"insert into tbl_video_gallery (videoTitle,videoLink,videoDescription,album)values('$title','$link','$details','$gTitleId')") or die(mysql_error());
$_SESSION["response"]='Video Uploaded';
echo "<script>location.href = 'manage-video-gallery.php'</script>;";																		
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
				<h5 class="widget-name"><i class="icon-th"></i>Add Video
				</h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">
								<div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] input-xxlarge" name="title" id="title"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Video Link: <span class="text-error">*</span>
									<i class="ico-question-sign popover-test left" title="YouTube URL" data-toggle="hover" data-content="Copy the URL of your Youtube Video and paste here"></i>
									</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[required] input-xxlarge" name="link" id="link"/>
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">Select Album: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <select name="albumTitle" id="albumTitle" class="validate[] styled" data-prompt-position="topLeft:-1,-5">
	                                        <option value="">select Album</option>
											<?php 
											$rslt=mysqli_query($con,"select * from tbl_gallery_titles order by galleryTitle asc");
											if(mysqli_num_rows($rslt)>0)
											{
											while($row=mysqli_fetch_array($rslt))
											{ ?>											
												<option value="<?php echo $row['galleryTitleId'];?>"><?php echo $row['galleryTitle'] ?></option>
											<?php
											}
											} ?>
	                                    </select>
	                                </div><br />
                                    <div class="controls"><span>OR</span></div><br />
	                                <label class="control-label">New Album Title:</label>
	                                <div class="controls">
	                                    <input type="text" value="" class="validate[] span12" name="gTitle" id="gTitle"/>
	                                </div>
	                            </div>
								
                                <div class="control-group hide">
	                                <label class="control-label">Video Description:</label>
	                                <div class="controls">
	                                    <textarea type="text" rows="5" value="" class="validate[] span12" name="details" id="details"></textarea>
	                                </div>
	                            </div>	                            								
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" onClick="return validate()" name="submit">Submit</button>
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
	<script>
	function validate()
{
	var e = document.getElementById("albumTitle").value;
	if(e)
	{
		document.getElementById("gTitle").value="";
	}
	else
	{
		if(document.getElementById("gTitle").value =="")
		{
			alert("Select An Album Or Add New");
			return false;
		}
	}
}
</script>
</body>
</html>
