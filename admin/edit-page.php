<?php 
include("session.php"); /*Check for session is set or not if not redirect to login pageTitle */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include("functions.php"); /* Connection String*/

if($userType!=1) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$editId	= $_GET["id"];
$tableName="tbl_pages";


//select page to be editted
$rslt=mysqli_query($con,"select * from tbl_pages where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-page.php');
}
$row=mysqli_fetch_assoc($rslt);
$pgTitle		= $row["pageTitle"];
$description	= $row["description"];
$imageName			= $row["image"];
$altTag			= $row["altTag"];
$activeStatus	= $row["activeStatus"];
$alignImage		= $row["alignImage"];
$topBanner		= $row["topBanner"];
$bannerAlt		= $row["bannerAlt"];
$bannerText1	= $row["bannerText1"];
$bannerText2	= $row["bannerText2"];
$urlName		= $row["urlName"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];
$pgName=$pgTitle;
// new user submit
if(isset($_POST["submit"]))
{
	$pgTitle 	= mysqli_real_escape_string($con,$_POST["pgTitle"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$alignImage=mysqli_real_escape_string($con,$_POST["alignImage"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$pgTitle;
	$seoName = set_url_name($urlName);
	

	{
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images");
	if($image["image"]){
		$upload = $image->upload(); 
		if($upload){
			$imageName=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	
	// top banner upload starts
	require "edit-top-banner-upload.php";
	// top banner upload ends
		
		//start update extra descriptions
		mysqli_query($con,"update tbl_pages set pageTitle='".$pgTitle."',description='".$description."',altTag='".$altTag."',image='".$imageName."',alignImage='".$alignImage."',activeStatus='".$activeStatus."',updatedOn=NOW(),topBanner='".$topBanner."',bannerAlt='".$bannerAlt."',bannerText1='".$bannerText1."',bannerText2='".$bannerText2."',urlName='".$seoName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."' where id='".$editId."'") ;
		
		
		$rslt=mysqli_query($con,"select * from tbl_page_description where pageId='".$editId."'");
		while($row=mysqli_fetch_assoc($rslt))
		{
			$newId=$row["id"];
			$newImage=$row["image"];
			//update new Description
			if(isset($_POST["newAltTag".$newId]) && !empty($_POST["newDescription".$newId]))
			{
				$newDescription	= mysqli_real_escape_string($con,$_POST["newDescription".$newId]);
				$newAltTag	= mysqli_real_escape_string($con,$_POST["newAltTag".$newId]);
				$newAlignImage=mysqli_real_escape_string($con,$_POST["newAlignImage".$newId]);
				
				if(isset($_FILES['newImage'.$newId]) && !empty($_FILES['newImage'.$newId]['name'])) 
				{     
					$path_to_image_directory = '../images/pages/';
					if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['newImage'.$newId]['name'])) 
					{ 
						$path = $_FILES['newImage'.$newId]['name'];
						$ext = pathinfo($path, PATHINFO_EXTENSION);		
						$source = $_FILES['newImage'.$newId]['tmp_name'];
						if(empty($newImage))
							$newImage = $pgName; //Image name
						// Make sure the fileName is unique
						$count = 1;
						while (file_exists($path_to_image_directory.$newImage.$count.".".$ext))
						{
							$count++;	
						}
						$newImage = $newImage . $count.".".$ext;
						$target = $path_to_image_directory . $newImage;
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
				mysqli_query($con,"update tbl_page_description set description='".$newDescription."',image='".$newImage."',alignImage='".$newAlignImage."',altTag='".$newAltTag."' where id='".$row["id"]."'");
			}
		}
		
		//if new Description
		if(isset($_POST["newAltTag"]) && !empty($_POST["newDescription"]))
		{
			$newDescription	= mysqli_real_escape_string($con,$_POST["newDescription"]);
			$newAltTag	= mysqli_real_escape_string($con,$_POST["newAltTag"]);
			$newAlignImage=mysqli_real_escape_string($con,$_POST["newAlignImage"]);
			
			if(isset($_FILES['newImage']) && !empty($_FILES['newImage']['name'])) 
			{     
				$path_to_image_directory = '../images/pages/';
				if(preg_match('/[.](jpg)|(gif)|(png)$/', $_FILES['newImage']['name'])) 
				{ 
					$path = $_FILES['newImage']['name'];
					$ext = pathinfo($path, PATHINFO_EXTENSION);		
					$source = $_FILES['newImage']['tmp_name'];
					$newImage = $pgName; //Image name
					// Make sure the fileName is unique
					$count = 1;
					while (file_exists($path_to_image_directory.$newImage.$count.".".$ext))
					{
						$count++;	
					}
					$newImage = $newImage . $count.".".$ext;
					$target = $path_to_image_directory . $newImage;
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
				$newImage="";
			}
			
			mysqli_query($con,"insert into tbl_page_description(pageId,description,image,alignImage,altTag) values('".$editId."','".$newDescription."','".$newImage."','".$newAlignImage."','".$newAltTag."')");
		}
		
	
	
//	echo "<script>location.href = 'manage-pages.php'</script>";
	echo "<script>location.href = 'edit-page.php?id=".$editId."'</script>;";																			

		}
}

if(isset($_POST["deleteImage"]))
{
	unlink("../images/pages/".$image);
	mysqli_query($con,"update tbl_pages set image='' where id='".$editId."'") ;
	echo "<script>location.href = 'edit-page.php?id=".$editId."'</script>;";																			
}
if(isset($_POST["deleteNew"]))
{
	$rslt=mysqli_query($con,"select image from tbl_page_description where id='".$_POST["deleteNew"]."'");
	$row=mysqli_fetch_assoc($rslt);
	if(!empty($row["image"]))
		unlink("../images/pages/".$row["image"]);
	mysqli_query($con,"delete from tbl_page_description where id='".$_POST["deleteNew"]."'");
}

if(isset($_POST["deleteNewImage"]))
{
	unlink("../images/pages/".$_POST["deleteNewImage"]);
	mysqli_query($con,"update tbl_page_description set image='' where image='".$_POST["deleteNewImage"]."'") ;
	echo "<script>location.href = 'edit-page.php?id=".$editId."'</script>;";
}

if(isset($_POST["deleteBanner"]))
{
	unlink("../images/".$topBanner);
	mysqli_query($con,"update ".$tableName." set topBanner='' where id='".$editId."'") ;
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

			    <!-- Page header --><br><!-- /Page header -->
				<h5 class="widget-name"><i class="icon-copy"></i>Edit Page</h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
                            
	                    	<div class="well row-fluid">                            	                                
                                <div class="control-group">
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $pgTitle; ?>" class="validate[required] input-xlarge" name="pgTitle" id="pgTitle"/>					
										
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label"><?php if($editId==11) echo "Welcome Text";else echo "Description";?>:</label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="description" class="validate[required] span12"><?php echo $description; ?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Upload Image:<br><?php echo image_size('page_image'); ?></label>
	                                <div class="controls">
                                    <?php if(!empty($imageName))
									{?>
                                    	<img src="../uploads/images/<?php echo $imageName; ?>" width="75" height="100" />
										<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
                                    <?php } 
									else
									{
									?>
                                    	<img src="../images/default.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="image" id="image" class="validate[custom[images]]">
									</div>
									<div class="controls hide">
										<br><br>
	                                    <label>Alt Tag : <input type="text" value="<?php echo $altTag;?>" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
										<label>Align: 
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($alignImage == 0) {echo "checked";}?>  name="alignImage" id="left" value="0" data-prompt-position="topLeft:-1,-5"/>
												Left
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($alignImage == 1) {echo "checked";}?> name="alignImage" id="Right" value="1" data-prompt-position="topLeft:-1,-5"/>
												Right
											</label>
										</label>
	                                <?php 
										$script="";
										$rslt=mysqli_query($con,"select * from tbl_page_description where pageId='".$editId."'");
										$num=mysqli_num_rows($rslt);									
										if($num==0){?>
									<?php }?>
									</div>									
	                            </div>
								<?php 
								$i=0;
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
									$newId=$row["id"];
								?>
								<div style="">
								<!--<button type="submit" name="deleteNew" value="<?php echo $newId;?>" style="float:right;border: none;border-radius: 50px;padding: 5px 8px;"><i class="icon-remove"></i></button>-->
								<br clear="all"/>
								<div class="control-group">
	                                <label class="control-label"><?php if($i==1) echo "Academics Section";else echo "Al Najah Education Section";?>:</label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="newDescription<?php echo $newId;?>" class="validate[required] span12"><?php echo $row["description"];?></textarea>
	                                </div>
	                            </div>                                
                                <div class="control-group hide">
	                                <label class="control-label">Upload Image:<br></label>
	                                <div class="controls">
										<?php if(!empty($row["image"]))
										{?>
											<img src="../uploads/<?php echo $row["image"]; ?>" width="75" height="100" />
											<button type="submit" name="deleteNewImage" value="<?php echo $row["image"]; ?>" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php } 
										else
										{
										?>
											<img src="../images/default.jpg" width="75" height="100" />                                    
										<?php }?>
										<input type="file" name="newImage<?php echo $newId;?>" id="newImage<?php echo $newId;?>" class="validate[custom[images]]">
										<br><br><label>Alt Tag : <input type="text" value="<?php echo $row["altTag"];?>" class="validate[] input-xlarge" name="newAltTag<?php echo $newId;?>" id="newAltTag<?php echo $newId;?>"/></label>
										<div class="hide">
										<label>Align: 
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($row["alignImage"] == 0) {echo "checked";}?>  name="newAlignImage<?php echo $newId;?>" id="left<?php echo $newId;?>" value="0" data-prompt-position="topLeft:-1,-5"/>
												Left
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" <?php if($row["alignImage"] == 1) {echo "checked";}?> name="newAlignImage<?php echo $newId;?>" id="Right<?php echo $newId;?>" value="1" data-prompt-position="topLeft:-1,-5"/>
												Right
											</label>
										</label>
										
										</div>
										<?php if($i==$num){?>
										<button type="button" name="addNew" onClick="newDesc(1)">Add New Description</button>										
										<?php }?>
	                                </div>
	                            </div>
								</div>
								
								<?php 
								$script.="CKEDITOR.replace('newDescription".$newId."');";
								}?>
								
								<!--New Description starts-->
								<div class="new-desc" style="display:none;border:2px solid red;">
								<button type="button" name="addNew" onClick="newDesc(0)" style="float:right;border: none;border-radius: 50px;padding: 5px 8px;"><i class="icon-remove"></i></button>
								<br clear="all"/>
								<div class="control-group">
	                                <label class="control-label">Description:</label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="newDescription" class="validate[required] span12"></textarea>
	                                </div>
	                            </div>                                
                                <div class="control-group hide">
	                                <label class="control-label">Upload Image:<br><?php echo "w:".$imageWidth."px &nbsp;&nbsp; h:".$imageHeight."px"; ?></label>
	                                <div class="controls">
										<input type="file" name="newImage" id="newImage" class="validate[custom[images]]">
										<br><br><label>Alt Tag : <input type="text" value="" disabled class="validate[] input-xlarge" name="newAltTag" id="newAltTag"/></label>
										<label>Align: 
											<label class="radio inline">
												<input class="styled" type="radio" checked  name="newAlignImage" id="left" value="0" data-prompt-position="topLeft:-1,-5"/>
												Left
											</label>
											<label class="radio inline">
												<input class="styled" type="radio" name="newAlignImage" id="Right" value="1" data-prompt-position="topLeft:-1,-5"/>
												Right
											</label>
										</label>
	                                </div>
	                            </div>
								</div>
								<!--New Description Ends-->
								<div class="">
								<!-- top banner -->
                      			<?php include("edit-top-banner.php");?>
                                <!-- /top banner -->
								</div>
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
								<div class="control-group hide">
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
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
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
	CKEDITOR.replace('newDescription');
	function newDesc(i)
	{
		if(i==1)
		{
			$(".new-desc").show();
			$("#newAltTag").prop("disabled",false);
		}
		else
		{
			$(".new-desc").hide();
			$("#newAltTag").prop("disabled",true);
		}
	}
	<?php echo $script;?>
	</script>
</body>
</html>
