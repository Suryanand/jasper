<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); /* Geting logged in user details*/


// get company profile details
$seoSet=0; 
$aboutImage="";
$topBanner="";
$metaDescription="";
		$metaKeywords="";
		$titleTag="";
		$service="";
		$shortDescription="";
		$serviceImage="";
		$color="";

if(isset($_GET["id"]))		
{
	$rslt=mysqli_query($con,"select * from tbl_home_service where id='".$_GET["id"]."'");
	$row=mysqli_fetch_assoc($rslt);
	$service=$row["service"];
	$shortDescription=$row["description"];
	$serviceImage=$row["serviceImage"];
}

$rslt=mysqli_query($con,"select * from tbl_company_profile") ;
$row=mysqli_fetch_array($rslt);
		$flag=1; // get about details
		$aboutText=$row['aboutText'];
		$aboutImageAlt=$row['aboutImageAlt'];
		$aboutImage=$row["aboutImage"];
		$videoURL=$row["video"];
		$metaDescription=$row['metaDescription'];
		$metaKeywords=$row['metaKeywords'];
		$titleTag=$row['titleTag'];
		$marqueeStatus=$row['marqueeStatus'];
		$marquee=$row['marquee'];
		$description2=$row['description2'];
		$services=$row['services'];
		$sections=json_decode($row['sections'],true);

// home page form submit
if(isset($_POST["submit"]))
{
	$aboutText=mysqli_real_escape_string($con,$_POST["aboutText"]);
	$services=mysqli_real_escape_string($con,$_POST["services"]);
	$aboutImageAlt=mysqli_real_escape_string($con,$_POST["aboutImageAlt"]);
	$videoURL=mysqli_real_escape_string($con,$_POST["videoURL"]);
	$marquee=mysqli_real_escape_string($con,$_POST["marquee"]);
	$description2=mysqli_real_escape_string($con,$_POST["description2"]);
	
	if(isset($_POST["about"]))
		$sections["about"]=1; // about section enable
	else
		$sections["about"]=0; // about section disable
	if(isset($_POST["service"]))
		$sections["service"]=1;// enquiry section enable
	else
		$sections["service"]=0;  // enquiry section disable
	if(isset($_POST["news"]))
		$sections["news"]=1;  // curriculum section enable
	else
		$sections["news"]=0;  // curriculum section disable
	if(isset($_POST["testimonials"]))
		$sections["testimonials"]=1;  // staff section enable
	else
		$sections["testimonials"]=0;  // staff section disable
	
	if(isset($_POST["marqueeStatus"]))
		$marqueeStatus=1;  // marquee enable
	else
		$marqueeStatus=0;  // // marquee section disable
	
	$sections_json=json_encode($sections,true);
	
	//image upload starts
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images");
	if($image["aboutImage"]){
		$upload = $image->upload(); 
		if($upload){
			$aboutImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	// image upload ends
	
		
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
						
		//echo "update tbl_company_profile set aboutText='$aboutText',aboutImageAlt='$aboutImageAlt',aboutImage='$aboutImage',topBanner='$topBanner',bannerAlt='$bannerAlt',metaDescription='$metaDescription',metaKeywords='$metaKeywords',titleTag='$titleTag',video='$videoURL',sections='$sections_json'";die();
		// update about details
		mysqli_query($con,"update tbl_company_profile set aboutText='$aboutText',services='$services',aboutImageAlt='$aboutImageAlt',aboutImage='$aboutImage',metaDescription='$metaDescription',metaKeywords='$metaKeywords',titleTag='$titleTag',video='$videoURL',sections='$sections_json',marquee='$marquee',marqueeStatus='$marqueeStatus',description2='$description2'") or die(mysqli_error($con));	
		$_SESSION["response"]="Home Page Updated";
	
	echo "<script>location.href = 'home.php';</script>";exit();
}

if(isset($_POST["servicepost"]))
{
	$service=mysqli_real_escape_string($con,$_POST["service"]);
	$shortDescription=mysqli_real_escape_string($con,$_POST["shortDescription"]);
	$color=mysqli_real_escape_string($con,$_POST["color"]);
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/services");
	if($image["serviceImage"]){
		$upload = $image->upload(); 
		if($upload){
			$serviceImage=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	if(isset($_GET["id"]))
	{
		mysqli_query($con,"update tbl_home_service set service='".$service."',description='".$shortDescription."',serviceImage='".$serviceImage."',color='".$color."' where id='".$_GET["id"]."'");
			$_SESSION["response"]="Home Page Updated";
			$_SESSION["tab"]="service";
	
	echo "<script>location.href = 'home.php';</script>";exit();
	}
	else
	{
		mysqli_query($con,"insert into tbl_home_service(service,description,serviceImage,color) values('".$service."','".$shortDescription."','".$serviceImage."','".$color."')") or die(mysqli_error($con));
			$_SESSION["tab"]="service";
		echo "<script>location.href = 'home.php';</script>";exit();
	}
	
}

if(isset($_POST["deleteImage"]))
{
	unlink("../images/".$aboutImage);
	mysqli_query($con,"update tbl_company_profile set aboutImage=''") ;
	echo "<script>location.href = 'home.php'</script>;";																		
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

				<h5 class="widget-name"><i class="icon-copy"></i>Home Page</h5>

				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
						
						<div class="tabbable">
                            <ul class="nav nav-tabs">
	                                <li class="<?php if(!isset($_SESSION["tab"]) && !isset($_GET["id"])) echo "active";?>"><a href="#tab1" data-toggle="tab">General</a></li>
	                                <li class="<?php if(isset($_SESSION["tab"]) || isset($_GET["id"])) echo "active";?>"><a href="#tab2" data-toggle="tab">Service Section</a></li>
	                            </ul>
                           <div class="tab-content">
                           <div class="tab-pane <?php if(!isset($_SESSION["tab"]) && !isset($_GET["id"])) echo "active";?>" id="tab1">
	                    	<div class="well row-fluid">                                
								<div class="control-group">
	                                <label class="control-label">About Text:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="aboutText" class="validate[required] span12"><?php if($flag==1) echo $aboutText; ?></textarea>
	                                </div>
	                            </div>
                               
								<div class="control-group">
	                                <label class="control-label">Upload Image:<br><?php echo image_size('home_image'); ?></label>
	                                <div class="controls">
	                                    <?php if($flag==1 && !empty($aboutImage)) {?><img src="../uploads/images/<?php echo $aboutImage; ?>" width="100" height="75" /> 
										<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
										<?php }?>
										<input type="file" name="aboutImage" id="aboutImage" class="validate[custom[images]]">									
	                                </div>
									<br clear="all"/>
									<label class="control-label">Alt Tag :</label>
									<div class="controls">
										<input type="text" value="<?php if($flag==1) {echo $aboutImageAlt;}?>" class="validate[] input-xlarge" name="aboutImageAlt" id="aboutImageAlt"/>
									</div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">Service Section:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="services" class="validate[required] span12"><?php if($flag==1) echo $services; ?></textarea>
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">Smart Resources Section:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="description2" class="validate[required] span12"><?php if($flag==1) echo $description2; ?></textarea>
	                                </div>
	                            </div>
								
								<div class="control-group hide">
	                                <label class="control-label">Welcome Video URL(YouTube):</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $videoURL;?>" name="videoURL" id="videoURL" class="input-xlarge">
	                                </div>
	                            </div>
								
								<div class="control-group hide">
	                                <label class="control-label">Marquee:</label>
	                                <div class="controls">
										<input type="checkbox" value="1" <?php if($marqueeStatus==1) echo "checked";?> name="marqueeStatus" id="marqueeStatus" class=""> Show
	                                    <br clear="all"/>
										<textarea rows="1" cols="5" name="marquee" class="validate[] span12"><?php if($flag==1) echo $marquee; ?></textarea>
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">About Section:</label>
	                                <div class="controls">
	                                    <input type="checkbox" value="1" <?php if($sections["about"]==1) echo "checked";?> name="about" id="about" class=""> Show
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Service Section:</label>
	                                <div class="controls">
	                                    <input type="checkbox" value="1" <?php if($sections["service"]==1) echo "checked";?> name="service" id="service" class=""> Show
	                                </div>
	                            </div>
								
								<div class="control-group">
	                                <label class="control-label">News Section:</label>
	                                <div class="controls">
	                                    <input type="checkbox" value="1" <?php if($sections["news"]==1) echo "checked";?> name="news" id="news" class=""> Show
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Testimonial & Client Section:</label>
	                                <div class="controls">
	                                    <input type="checkbox" value="1" <?php if($sections["testimonials"]==1) echo "checked";?> name="testimonials" id="testimonials" class=""> Show
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

	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>

	                        </div>

	                    </div>
							<div class="tab-pane <?php if(isset($_SESSION["tab"]) || isset($_GET["id"])) echo "active";?>" id="tab2">
								<div class="control-group">
	                                <label class="control-label">Service: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $service; ?>" class="validate[required] input-xlarge" name="service" id="service"/>					
										
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Description</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="shortDescription" class="validate[] input-xxlarge"><?php echo $shortDescription; ?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Top Banner:<br>1695x543px</label>
	                                <div class="controls">
                                    <?php if(!empty($serviceImage))
									{?>
                                    	<img src="../uploads/images/services/<?php echo $serviceImage; ?>" width="75" height="100" />
										<button type="submit" name="deleteBanner" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
                                    <?php } 
									else
									{
									?>
                                    	<img src="category/default-category.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="serviceImage" id="serviceImage" class="validate[custom[images]]">									
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Color: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="color" value="<?php echo $color; ?>" class="validate[] input-mini" name="color" id="color"/>					
										
	                                </div>
	                            </div>
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="servicepost">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>
								
								<br clear="all"/>
								<table class="table table-striped table-bordered table-checks media-table">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Service</th>
                                    <th>Text</th>
                                    <th class="">Color</th>
                                    <th class="align-center">Image</th>
                                    <th class="actions-column width10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <!-- Display All User Details -->
                            <?php
								$rslt=mysqli_query($con,"SELECT * from tbl_home_service");
								$i=0;
								$num=mysqli_num_rows($rslt);
								while($row=mysqli_fetch_assoc($rslt))
								{
									$i++;
							?>
                                <tr>
			                        <td><?php echo $i;?></td>
			                        <td><?php echo $row["service"]; ?></td>
			                        <td><?php echo $row["description"]; ?></td>
			                        <td><?php echo $row["color"]; ?></td>
			                        <td style="background:#efe9e9;"><img src="../uploads/images/services/<?php echo $row["serviceImage"]; ?>"/></td>
			                        
			                        <td>
		                                <ul class="navbar-icons">
		                                    <li><a href="home.php?id=<?php echo $row['id'];?>" class="tip" title="Edit"><i class="icon-pencil"></i></a></li>
		                                    <li><button type="submit" title="Remove" onClick="return clickMe()" value="<?php echo $row['id'];?>" class="remove-button-icon" name="deleteService">
<i class="icon-remove"></i></button></li>
		                                </ul>
			                        </td>
                                </tr>
                                <?php } ?>
                            <!-- /Display All User Details -->
                                
                            </tbody>
                        </table>
                    
							</div>
						</div>
	                    </div>
	                    </div>
	                    <!-- /form validation -->
<?php if(isset($_SESSION["tab"]))
{
	unset($_SESSION["tab"]);
}?>
	                </fieldset>
				</form>
				<!-- /form validation -->
                
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->
	<?php 
    // echo response 
    if(isset($_SESSION["response"]))
    {
        echo "<script>alert('".$_SESSION["response"]."');</script>";
        unset($_SESSION["response"]);
    }
    ?>
	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->
	<script type="text/javascript">	
	CKEDITOR.replace('aboutText');
	CKEDITOR.replace('services');
	CKEDITOR.replace('description2');
	</script>
</body>
</html>
