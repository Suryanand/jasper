<?php 

include("session.php"); /*Check for session is set or not if not redirect to login page */

include("config.php"); /* Connection String*/

include('get-user.php'); /* Getting logged in user details*/



$rslt=mysqli_query($con,"select * from image_size where pageName='article'");

$row=mysqli_fetch_assoc($rslt);

$imageWidth=$row["width"];

$imageHeight=$row["height"];



// News & Events Form Submit

if(isset($_POST["submit"]))

{

	$title=mysqli_real_escape_string($con,$_POST["title"]);

	$postType=mysqli_real_escape_string($con,$_POST["postType"]);

	$details=mysqli_real_escape_string($con,$_POST["details"]);

	if(!empty($_POST["publishDate"]))

	{

		$publishDate=date("Y-m-d", strtotime($_POST["publishDate"]));

	}

	else

	{

		//getting current date for news

		$publishDate=date('Y-m-d');

	}

	$video="";

	$filename="";

	if(isset($_POST["video"]))

	{

		$video=$_POST["video"];

	}

	else

	{

		//Image Upload Start here

		$path_to_image_directory = '../images/library/';

		$filename = "library-";

		if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) 

		{     

			if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['image']['name'])) 

			{     

				$path = $_FILES['image']['name'];

				$ext = pathinfo($path, PATHINFO_EXTENSION);

				$source = $_FILES['image']['tmp_name'];  

				// Make sure the fileName is unique 

				$count = 1;

				while (file_exists($path_to_image_directory.$filename.$count.".".$ext))

				{

					$count++;	

				}

				$filename = $filename . $count.".".$ext;

				$target = $path_to_image_directory . $filename;

				if(!file_exists($path_to_image_directory)) 

				{

				if(!mkdir($path_to_image_directory, 0777, true)) 

					{

						die("There was a problem. Please try again!");

					}

				}        

				move_uploaded_file($source, $target);

			}

		}

		else

		{

			$filename="";

		}

	}

	// insert into table

	mysqli_query($con,"insert into tbl_library (title,description,publicationDate,image,video,postType)values('$title','$details','$publishDate','$filename','$video','$postType')") or die(mysqli_error($con));						

	

	// set response alert

	$_SESSION["response"]="Article Saved";

	echo "<script>location.href = 'manage-library.php'</script>;";																		

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

.ui-datepicker-append{display:none;}

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

			    <div class="page-header">

			    	<div class="page-title">

				    	<h5>Dashboard</h5>				    	

			    	</div>

			    </div>

			    <!-- /page header -->

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">

	                <fieldset>

	                    <!-- Form validation -->

	                    <div class="widget">

	                        <div class="navbar"><div class="navbar-inner"><h4>Library</h4></div></div>

	                    	<div class="well row-fluid">

								<div class="control-group">

	                                <label class="control-label">Post Type: <span class="text-error">*</span></label>

									<i class="ico-question-sign popover-test" title="Post Type" data-trigger="hover" data-content="Text:- Text and one image, Image:- Text and multiple image, Video:-Text and one Youtube video"></i>

	                                <div class="controls">

	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge  " data-prompt-position="">

                                            <option value="1">Text / Image</option>

											<option value="3">Text / Video</option>

	                                    </select>

	                                </div>

	                            </div>

								<div class="control-group">

	                                <label class="control-label">Title <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <input type="text" value="" class="validate[required] input-xxlarge " name="title" id="title"/>

	                                </div>

	                            </div>

                                <div class="control-group">

	                                <label class="control-label">Details: <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <textarea rows="5" cols="5" name="details" class="validate[required]  span12"></textarea>

	                                </div>

	                            </div>	                            

                                <div class="control-group">

		                            <label class="control-label">Publish Date <span class="text-error">*</span> </label>

		                            <div class="controls">

		                                <input type="text" value="<?php echo date('d-m-Y');?>" class="datepicker validate[required] input-xlarge "  name="publishDate" id="publishDate"/>

		                            </div>

		                        </div>

                                <div class="control-group" id="moreImage">

	                                <label class="control-label">upload image: <span class="text-error">*</span><br><?php echo "w:".$imageWidth."px "." h:".$imageHeight."px";?></label>

	                                <div class="controls speechImg">

	                                    <input type="file" name="image" id="image" class="validate[custom[images]] "/>

										<button type="button" id="addMore" onClick="moreImages()" name="addMore" style="display:none;float:right;color:#555 !important;background:transparent;border:none;font-size:16px;">

										<i style="padding:3px 4px;" class="icon-plus"></i>Add More</button>

	                                </div>

	                            </div>

								<div class="control-group speechVdo" style="display:none;">

	                                <label class="control-label">Video Link: <span class="text-error">*</span>									

									</label>

									<i class="ico-question-sign popover-test" title="YouTube URL" data-trigger="hover" data-content="Copy the URL of your Youtube Video and paste here"></i>

									<div class="controls">

										<input type="text" disabled value="" class="validate[] input-xxlarge " name="video" id="video"/>

	                                </div>

	                            </div>

								<!--

                                <div class="navbar"><div class="navbar-inner"><h6>SEO</h6></div></div>

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

	                            </div>-->

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



	function getType(postType)

	{

		if(postType!=3)

		{

			$("#moreImage").show();

			$(".speechVdo").hide();

			$("#video").attr("disabled",true);

		}

		else if(postType==3){

			$("#moreImage").hide();

			$(".speechVdo").show();

			$("#video").attr("disabled",false);

		}

	}

	

    function moreImages()

	{

	//$(add_button).click(function(e){ //on add input button click

        //e.preventDefault();

        //if(x < max_fields){ //max input box allowed

          //  x++; //text box increment

            $("#moreImage").append('<br clear="all"/><div class="controls"><input type="file" name="extraImages[]" class="validate[custom[images]] "><a href="" onClick="event.preventDefault();removeImage(this);" class="remove_field "><i style="padding:3px 4px;" class="icon-remove"></i></a></div>'); //add input box						

       // }

   // });

    }

	function removeImage(e)

	{

    //$(wrapper).on("click",".remove_field", function(e){ //user click on remove text

       e.parentNode.parentNode.removeChild(e.parentNode);

    //}) 

	}

	</script>

</body>

</html>

