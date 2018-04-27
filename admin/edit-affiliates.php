<?php 
include("session.php"); /*Check for session is set or not if not redirect to login affiliates */
include("config.php"); /* Connection String*/
if($userType != 1) /* This affiliates only for admin - if normal user redirect to index affiliates */
{
	header('location: index.php');
}
include('get-user.php'); /* Geting logged in user details*/
include('functions.php');
$editId	= $_GET["id"];


//select category to be editted
$rslt=mysqli_query($con,"select * from tbl_affiliates where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-brand.php');
}
$row=mysqli_fetch_assoc($rslt);
$affiliates		= $row["affiliates"];
$description		= $row["description"];
$imageName		= $row["image"];
$affiliates=$row["affiliates"];
$titleTag=$row['titleTag'];
$metaDescription=$row['metaDescription'];
$metaKeywords=$row['metaKeywords'];
$urlName=$row['urlName'];

// new user submit
if(isset($_POST["submit"]))
{
	$affiliates 	= mysqli_real_escape_string($con,$_POST["affiliates"]);
	$description	= mysqli_real_escape_string($con,$_POST["description"]);


	// Check whether the email already registered 
	$rslt=mysqli_query($con,"select * from tbl_affiliates where affiliates='$affiliates' and id!='".$editId."'");
	if(mysqli_num_rows($rslt)>0)
	{/* email already registered */
		$_SESSION["response"]="affiliates already created";
	}
	else
	{
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/affiliates");
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
		$urlName=$affiliates;
	}
	$urlName = set_url_name($urlName);
		
		mysqli_query($con,"update tbl_affiliates set affiliates='".$affiliates."',description='".$description."',image='".$imageName."',titleTag='$titleTag',metaDescription='$metaDescription',metaKeywords='$metaKeywords',urlName='".$urlName."' where id='".$editId."'") or die(mysqli_error($con));
		$_SESSION["response"]="affiliates Updated";
		
		if($_POST["submit"]=="submit-close")
		{
			echo "<script>location.href = 'manage-affiliates.php'</script>";exit();
		}
		else
		{
			echo "<script>location.href = 'edit-affiliates.php?id=".$editId."'</script>";exit();
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Edit Affiliates</h6></div></div>
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
	                                <label class="control-label">Title: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $affiliates; ?>" class="validate[required] input-xlarge" name="affiliates" id="affiliates"/>					
										
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
                                    	<img src="../uploads/images/affiliates/<?php echo $imageName; ?>" width="75" height="100" />
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
                                            $rslt=mysqli_query($con,"SELECT * FROM tbl_affiliates_images where affiliatesId='".$editId."'");
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
