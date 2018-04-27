<?php 

include("session.php"); /*Check for session is set or not if not redirect to login page */

include("config.php"); /* Connection String*/

include('get-user.php'); /* Getting logged in user details*/

$editId=$_GET["id"];



$rslt=mysqli_query($con,"select * from image_size where pageName='article'");

$row=mysqli_fetch_assoc($rslt);

$imageWidth=$row["width"];

$imageHeight=$row["height"];



$rslt=mysqli_query($con,"select * from tbl_library where id='$editId'");

while($row=mysqli_fetch_array($rslt))

{

	$title			= $row['title'];

	$details		= $row['description'];

	$publicationDate= $row['publicationDate'];

	$image	= $row['image'];

	$postType		= $row["postType"];

	$video	= $row["video"];

}



//submit news-events form for update

if(isset($_POST["submit"]))

{

	$postType=mysqli_real_escape_string($con,$_POST["postType"]);

	$title=mysqli_real_escape_string($con,$_POST["title"]);

	$details=mysqli_real_escape_string($con,$_POST["details"]);

	if(!empty($_POST["publicationDate"]))

	{

		$publicationDate=date("Y-m-d", strtotime($_POST["publicationDate"]));

	}

	else

	{

		$publicationDate=date('Y-m-d');

	}



	$video="";

	$filename="";

	if(isset($_POST["video"]))

	{

		$video=$_POST["video"];

	}

	else{

		/* Image Upload Start */

		$path_to_image_directory = '../images/library/';

		$filename = $image;

		if(isset($_FILES['libraryImage']) && !empty($_FILES['libraryImage']['name'])) 

		{     

			if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['libraryImage']['name'])) 

			{    

				$path = $_FILES['libraryImage']['name'];

				$ext = pathinfo($path, PATHINFO_EXTENSION);	

				$ext2 = pathinfo($filename, PATHINFO_EXTENSION); 

				if(empty($filename) || $ext != $ext2)

				{

					$filename = "library-";							

					// Make sure the fileName is unique 

					$count = 1;

					while (file_exists($path_to_image_directory.$filename.$count.".".$ext))

					{

						$count++;	

					}

					$filename = $filename . $count.".".$ext; 

				}

				$source = $_FILES['libraryImage']['tmp_name'];  

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

	}



	//update news-event

	mysqli_query($con,"update tbl_library set title='$title',description='$details',publicationDate='$publicationDate',image='$filename',video='$video',postType='$postType' where id='$editId'") or die(mysqli_error($con));

	

	

	$_SESSION["response"]="Library updated";

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

<script>



function validation()

{

	var imageSet= $("#imageSet").val();

	var fileName = $("#libraryImage").val();

	if(fileName)

	{

	$("textarea#link").val("");

//	document.getElementById("link").value =="";

	}

	else

	{

		if(document.getElementById("link").value =="" && imageSet=="")

		{

			alert("Video or Image is required");

			return false;

		}

	}

}

</script>

<style>

.ui-datepicker-append{display:none;}

</style>

</head>



<body>



	<!-- Fixed top -->

	

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

									<i class="ico-question-sign popover-test" title="Post Type" data-trigger="hover" data-content="Text:- Text and one image, Video:-Text and one Youtube video"></i>

	                                <div class="controls">

	                                    <select name="postType" onChange="getType(this.value)" class="validate[] input-xlarge  " data-prompt-position="">

                                            <option value="1" <?php if($postType==1) echo "selected";?>>Text</option>

											<option value="3" <?php if($postType==3) echo "selected";?>>Video</option>

	                                    </select>

	                                </div>

	                            </div>

								<div class="control-group">

	                                <label class="control-label">Title: <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <input type="text" value="<?php echo $title;?>" class="validate[required]  input-xxlarge" name="title" id="title"/>

	                                </div>

	                            </div>

                                <div class="control-group">

	                                <label class="control-label">Details: <span class="text-error">*</span></label>

	                                <div class="controls">

	                                    <textarea rows="5" cols="5" name="details" class="validate[required]  span12"><?php echo $details;?></textarea>

	                                </div>

	                            </div>	                            

                                <div class="control-group">

		                            <label class="control-label">Publish Date: <span class="text-error">*</span> </label>

		                            <div class="controls">

		                                <input type="text"class="datepicker validate[required]  input-xlarge" value="<?php echo $publicationDate;?>" name="publicationDate" id="publicationDate"/>

		                            </div>

		                        </div>

								

                                <div class="control-group" id="moreImage" style="<?php if($postType==3 || $postType==4){?>display:none;<?php }?>">

	                                <label class="control-label">Upload Image: <br><?php echo "w:".$imageWidth."px "." h:".$imageHeight."px";?></label>

	                                <div class="controls">

                                    	<?php if(!empty($image) && $postType!=3 && $postType!=4) {?>

	                                    <img src="../images/library/<?php echo $image; ?>" width="150" />

										<?php } else{?>

	                                    <img src="../images/no-image.jpg" width="100" />										

										<?php }?>

										<input type="file" name="libraryImage" id="libraryImage" class="validate[custom[images]] ">

	                                	<input type="hidden" name="imageSet" id="imageSet" value="<?php echo $image; ?>"/>

										

                                    </div>                                  

	                            </div>



								<div class="control-group speechVdo" style="<?php if($postType!=3 && $postType!=4){?>display:none;<?php }?>">

	                                <label class="control-label">video Link: <span class="text-error">*</span></label>

									<i class="ico-question-sign popover-test" title="YouTube URL" data-toggle="hover" data-content="Copy the URL of your Youtube Video and paste here"></i>

									<div class="controls">

										<input type="text" <?php if($postType!=3){echo "disabled";}?> value="<?php echo $video; ?>" class="validate[] input-xxlarge " name="video" id="video"/>

	                                </div>

	                            </div>

                                <!-- seo fields -->

                      			<!--<div class="navbar"><div class="navbar-inner"><h6>SEO</h6></div></div>

                                <div class="control-group">

	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>

	                                <div class="controls">

	                                    <input type="text" value="<?php if(!empty($titleTag)) echo $titleTag;?>" maxlength="65" class="validate[]  input-xlarge" name="titleTag" id="titleTag"/>

	                                </div>

	                            </div>

                                <div class="control-group">

	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>

	                                <div class="controls">

	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[]  span12"><?php if(!empty($metaDescription)) echo $metaDescription;?></textarea>

	                                </div>

	                            </div>

                                <div class="control-group">

	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>

	                                <div class="controls">

	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[]  span12"><?php if(!empty($metaKeywords)) echo $metaKeywords;?></textarea>

	                                </div>

	                            </div>-->

	                            <div class="form-actions align-right">

	                                <button type="submit" class="btn btn-info" onClick="return validation()" name="submit">Submit</button>

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

		var id=e.getAttribute("data-id");

		 $.ajax({

		 type: "POST",

		 url: "ajx-images.php",

		 data: {id:id},

		 success: function(data) {

			}

		 });

    //$(wrapper).on("click",".remove_field", function(e){ //user click on remove text

       e.parentNode.parentNode.removeChild(e.parentNode);

    //}) 

	}



	</script>

</body>

</html>