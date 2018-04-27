<?php 
include("session.php"); /*Check for session is set or not if not redirect to login  */
include("config.php"); /* Connection String*/
if($userType != 1) /* This page only for admin - if normal user redirect to index  */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
$editId	= $_GET["id"];


//select category to be editted
$rslt=mysqli_query($con,"select * from tbl_curriculum where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-affiliation.php');
}
$row=mysqli_fetch_assoc($rslt);
$curriculum		= $row["curriculum"];
$description		= $row["description"];
$imageName		= $row["image"];
$curriculum=$row["curriculum"];
$titleTag=$row['titleTag'];
$metaDescription=$row['metaDescription'];
$metaKeywords=$row['metaKeywords'];
$urlName=$row['urlName'];

// new user submit
if(isset($_POST["submit"]))
{
	$curriculum 	= mysqli_real_escape_string($con,$_POST["curriculum"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);


	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_curriculum where curriculum='$curriculum' and id!='".$editId."'");
	if(mysqli_num_rows($rslt)>0)
	{/* email already registered */
		$_SESSION["response"]="curriculum already created";
	}
	else
	{
	
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
		
		mysqli_query($con,"update tbl_curriculum set curriculum='".$curriculum."',description='".$description."',image='".$imageName."',titleTag='$titleTag',metaDescription='$metaDescription',metaKeywords='$metaKeywords',urlName='".$urlName."' where id='".$editId."'") or die(mysqli_error($con));
		$_SESSION["response"]="curriculum Updated";
		
		if($_POST["submit"]=="submit-close")
		{
			echo "<script>location.href = 'manage-curriculum.php'</script>";exit();
		}
		else
		{
			echo "<script>location.href = 'edit-curriculum.php?id=".$editId."'</script>";exit();
		}

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
				<h5 class="widget-name"><i class="icon-th"></i>Edit Curriculum
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
	                                    <input type="text" value="<?php echo $curriculum; ?>" class="validate[required] input-xlarge" name="curriculum" id="curriculum"/>					
										
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Description:</label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="description" class="validate[required] span12"><?php echo $description; ?></textarea>
	                                </div>
	                            </div>                                
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br> w:360px &nbsp;&nbsp; h:190px</label>
	                                <div class="controls">
                                    <?php if(!empty($imageName))
									{?>
                                    	<img src="../uploads/images/curriculum/<?php echo $imageName; ?>" width="75" height="100" />
                                    <?php } 
									else
									{
									?>
                                    	<img src="../images/default.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="image" id="image" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								
                                <div class="control-group">
                                        <label class="control-label">SEO Name:<i class="ico-question-sign popover-test left"  data-trigger="hover" title="SEO Name" data-content="Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique."></i></label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $urlName; ?>"  maxlength="65" class="validate[] input-xxlarge" name="urlName" id="urlName"/>
                                        </div>
                                    </div>
								<div class="control-group">
	                                <label class="control-label">Title Tag: <br>(Max 65 Characters)</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php if(!empty($titleTag)) echo $titleTag;?>" maxlength="65" class="validate[] input-xlarge" name="titleTag" id="titleTag"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Description: <br>(Max 170 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaDescription" maxlength="250" name="metaDescription" class="validate[] span12"><?php if(!empty($metaDescription)) echo $metaDescription;?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Meta Keywords: <br>(Max 250 Characters)</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" id="metaKeywords" maxlength="250" name="metaKeywords" class="validate[] span12"><?php if(!empty($metaKeywords)) echo $metaKeywords;?></textarea>
	                                </div>
	                            </div>
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" value="submit" name="submit">Save and Continue</button>
                                    <button type="submit" class="btn btn-info" value="submit-close" name="submit">Save</button>
	                            </div>
	                        </div>
                                                       
                        </div>
                        <div class="tab-pane" id="tab2">
							<div class="control-group">
										<label class="control-label">Gallery Images:<br /><?php echo "w:600px &nbsp;&nbsp; h:400px"; ?></label>
											<div class="controls">
                                            <input type="file" class="validate[custom[images]]" name="file2" id="file2"/>					
						                    <button type="submit" onClick="return checkLimit()" class="btn btn-info" name="galleryImage">Add</button>
                                            <span style="color:red;"><?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);}?></span>
                                        </div>
                                        <div id="response"></div>
                                    </div>
									<div class="table-overflow">
                                        <table class="table table-striped table-bordered table-checks media-table">
                                            <thead>
												<tr>
                                                    <th>Sr.No.</th>
                                                    <th>Image</th>
                                                    <th>Order</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Display All User Details -->
                                            <?php
											$i=0;
                                            $rslt=mysqli_query($con,"SELECT * FROM tbl_curriculum_images where accreditationId='".$editId."'");
                                            //$i=0;
                                            while($row=mysqli_fetch_assoc($rslt))
                                            {
												$i++;
                                            ?>
												<tr>
													<td><?php echo $i;?></td>
													<td><img src="../images/products/thumbnail/<?php echo $row["galleryThumb"];?>"  width="75" /></td>
													<td>
														<input type="text" value="<?php echo $row["imageOrder"];?>"  maxlength="65" class="validate[] input-small" name="imageOrder<?php echo $i;?>"/>
														<input type="hidden" value="<?php echo $row["imageId"];?>"  maxlength="65" class="validate[] input-small" name="id<?php echo $i;?>" id="titleTag"/>
														<button type="submit" value="<?php echo $i;?>" class="btn btn-info" name="order">Update</button>
													</td>
													<td>
														<ul class="navbar-icons">		                                    
															<li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $i;?>" style="border:none;background:transparent;" class="" name="delete"><i class="icon-remove"></i></button></li>
														</ul>
													</td>
												</tr>
                                      <?php } ?>                                                        
											</tbody>
                                        </table>
                                        <input type="hidden" value="<?php echo $i;?>"  maxlength="65" class="validate[] input-small" name="galleryTotal" id="galleryTotal"/>
                                    </div>
						
						</div>

						</div></div>    
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
