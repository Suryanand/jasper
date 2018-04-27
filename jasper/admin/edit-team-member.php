<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 
if($userType==2 && !isset($m_teamMembers)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$editId	= $_GET["id"];
$tableName="tbl_team_members";

//select category to be editted
$rslt=mysqli_query($con,"select * from tbl_team_members where id='$editId'");
if(mysqli_num_rows($rslt) == 0)
{
	header('location: manage-team-members.php');
}
$row=mysqli_fetch_assoc($rslt);
$fullName		= $row["fullName"];
$department		= $row["department"];
$categoryId		= $row["category"];
$qualification	= $row["qualification"];
$profile		= $row["profile"];
$teamImage			= $row["image"];
$altTag			= $row["altTag"];
$expertise		= $row["expertise"];
$activeStatus	= $row["activeStatus"];
$topBanner		= $row["topBanner"];
$bannerAlt		= $row["bannerAlt"];
$fb				= $row['fb']; 
$tw				= $row['tw'];
$gp				= $row['gp'];
$li				= $row['li'];
$pi				= $row['pi'];
$bannerText1	= $row["bannerText1"];
$bannerText2	= $row["bannerText2"];
$memberType		= $row["memberType"];
$urlName		= $row["urlName"];
$titleTag		= $row["titleTag"];
$metaDescription= $row["metaDescription"];
$metaKeywords	= $row["metaKeywords"];

// new user submit
if(isset($_POST["submit"]))
{
	$fullName 	= mysqli_real_escape_string($con,$_POST["fullName"]);
	$department	= mysqli_real_escape_string($con,$_POST["department"]);
	$categoryId="";
	if(isset($_POST["categoryId"]))
	{
	foreach($_POST["categoryId"] as $cat)
	{
		$categoryId.=$cat.",";
	}
	}
	$categoryId=rtrim($categoryId,',');
	$qualification 	= mysqli_real_escape_string($con,$_POST["qualification"]);
	$profile 	= mysqli_real_escape_string($con,$_POST["profile"]);
	$expertise 	= mysqli_real_escape_string($con,$_POST["expertise"]);
	$altTag	= mysqli_real_escape_string($con,$_POST["altTag"]);	
	$activeStatus=mysqli_real_escape_string($con,$_POST["activeStatus"]);
	$memberType=mysqli_real_escape_string($con,$_POST["memberType"]);
	$fb=$_POST["fb"];
	$tw=$_POST["tw"];
	$li=$_POST["li"];
	$gp=$_POST["gp"];
	$pi=$_POST["pi"];
	
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/team");
	if($image["image"]){
		$upload = $image->upload(); 
		if($upload){
			$teamImage=$image->getName().".".$image->getMime();			
		}else{
			echo $image["error"]; 
		}
	}
	
	$titleTag=mysqli_real_escape_string($con,$_POST["titleTag"]);
	$metaDescription=mysqli_real_escape_string($con,$_POST["metaDescription"]);
	$metaKeywords=mysqli_real_escape_string($con,$_POST["metaKeywords"]);
	$urlName=mysqli_real_escape_string($con,$_POST["urlName"]);
	if(empty($urlName))
		$urlName=$fullName;
	$urlName = set_url_name($urlName);
	
	// top banner upload starts
	//require "edit-top-banner-upload.php";
	// top banner upload ends
		mysqli_query($con,"update tbl_team_members set fullName='".$fullName."',altTag='".$altTag."',department='".$department."',category='".$categoryId."',qualification='".$qualification."',expertise='".$expertise."',profile='".$profile."',image='".$teamImage."',activeStatus='".$activeStatus."',updatedOn=NOW(),fb='$fb',tw='$tw',gp='$gp',li='$li',pi='$pi',memberType='".$memberType."',urlName='".$urlName."',titleTag='".$titleTag."',metaDescription='".$metaDescription."',metaKeywords='".$metaKeywords."' where id='".$editId."'") or die(mysql_error());
		$_SESSION["response"]="Team Member Updated";
		echo "<script>location.href = 'manage-team-members.php'</script>";

}
if(isset($_POST["deleteImage"]))
{
	unlink("../images/teams/".$image);
	mysqli_query($con,"update tbl_team_members set image='' where id='".$editId."'") or die(mysql_error());
	echo "<script>location.href = 'edit-team-member.php?id=".$editId."'</script>;";																			
}
if(isset($_POST["deleteBanner"]))
{
	unlink("../images/".$topBanner);
	mysqli_query($con,"update ".$tableName." set topBanner='' where id='".$editId."'") or die(mysql_error());
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


				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                        <div class="navbar"><div class="navbar-inner"><h6>Edit Team Member</h6></div></div>                            
	                    	<div class="row-fluid">                            	                                
							<div class="span12 well">
								<div class="control-group hide">
	                                <label class="control-label">Team / Instructor: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" onClick="checkType(this.value)" <?php if($memberType == 1) {echo "checked";}?>  name="memberType" id="team" value="1" data-prompt-position="topLeft:-1,-5"/>
											Team
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" onClick="checkType(this.value)" <?php if($memberType == 2) {echo "checked";}?> name="memberType" id="instructor" value="2" data-prompt-position="topLeft:-1,-5"/>
											Instructor
										</label>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Name: <span class="text-error">*</span></label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $fullName;?>" class="validate[required] input-xlarge" name="fullName" id="fullName"/>					
	                                </div>
	                            </div>
								<div class="control-group">
                                	<label class="control-label">Category:</label>
                                	<div class="controls">
										<?php
										$catArray=explode(',',$categoryId);
										$rslt=mysqli_query($con,"select * from tbl_team_category_master");
										while($row=mysqli_fetch_array($rslt))
										{											
										?>
											<label class="radio inline">
											<input class="styled validate[minCheckbox[1]]" <?php if(in_array($row["id"],$catArray)) echo "checked";?> type="checkbox" name="categoryId[]" id="" value="<?php echo $row["id"];?>" data-prompt-position="topLeft:-1,-5"/>
											<?php echo $row["category"];?>
										</label>
                                        <?php } ?>
	                                </div>
	                            </div>
                                <div class="control-group designation <?php if($memberType == 2) {echo "hide";}?>">
	                                <label class="control-label">Designation:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $department;?>" class="validate[] input-xlarge" name="department" id="department"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Qualification:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $qualification;?>" class="validate[] input-xlarge" name="qualification" id="qualification"/>					
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Expertise:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $expertise;?>" class="validate[] input-xlarge" name="expertise" id="expertise"/>					
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Profile:<span class="text-error">*</span></label>
	                                <div class="controls">
									<textarea rows="5" cols="5" name="profile" class="validate[required] span12"><?php echo $profile;?></textarea>
	                                </div>
	                            </div>                               
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br> <?php echo "w:250px X h:250px";?></label>
	                                <div class="controls">
                                    <?php if(!empty($teamImage))
									{?>
                                    	<img src="../uploads/images/team/<?php echo $teamImage; ?>" width="75" height="100" />
										<button type="submit" name="deleteImage" style="background:transparent;border:none;"><i class="icon-remove"></i></button>
                                    <?php } 
									else
									{
									?>
                                    	<img src="../images/teams/default.jpg" width="75" height="100" />                                    
                                    <?php }?>
                                    
										<input type="file" name="image" id="image" class="validate[custom[images]]">
										<br><br>
	                                    <label>Alt Tag : <input type="text" value="<?php echo $altTag;?>" class="validate[] input-xlarge" name="altTag" id="altTag"/></label>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Draft / Publish: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 0){echo "checked";}?>  name="activeStatus" id="draft" value="0" data-prompt-position="topLeft:-1,-5"/>
											Draft
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($activeStatus == 1){ echo "checked";}?> name="activeStatus" id="publish" value="1" data-prompt-position="topLeft:-1,-5"/>
											Publish
										</label>
	                                </div>
	                            </div>
								
								<div class="navbar"><div class="navbar-inner"><h6>SEO</h6></div></div>
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
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>
								
							</div>	
							<div class="span6 well hide">
								<!-- top banner -->
                      			<?php include("edit-top-banner.php");?>
                                <!-- /top banner -->
								<div class="control-group">
	                                <label class="control-label">Facebook:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php  echo $fb; ?>" class="validate[custom[url]] span8" name="fb" id="fb"/>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Twitter:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php  echo $tw; ?>" class="validate[custom[url]]] span8" name="tw" id="tw"/>
	                                </div>
	                            </div>	                            
                                <div class="control-group">
	                                <label class="control-label">LinkedIn:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php  echo $li; ?>" class="validate[custom[url]]] span8" name="li" id="li"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Google Plus:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php  echo $gp; ?>" class="validate[custom[url]]] span8" name="gp" id="gp"/>					
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Pinterest:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php  echo $pi; ?>" class="validate[custom[url]]] span8" name="pi" id="pi"/>					
	                                </div>
	                            </div>
								
								<div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
	                                <button type="reset" class="btn">Reset</button>
	                            </div>
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
	//CKEDITOR.replace('profile');
	
	CKEDITOR.replace('profile', {
		"extraPlugins" : 'imagebrowser',
		"imageBrowser_listUrl" : "<?php echo $absolutePath;?>admin/images_list.json"
	});
	
	function checkType(type)
	{
		if(type==1)
			$(".designation").show();
		else
			$(".designation").hide();
	}
	</script>
</body>
</html>
