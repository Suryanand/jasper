<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/
include('functions.php'); 

if($userType==2 && !isset($m_banners)) /* This page only for admin - if normal user redirect to index page */
{
	header('location: index.php');
}

$editId			= $_GET["id"];
$rslt			= mysqli_query($con,"select * from tbl_banners where bannerId='".$editId."'");
$row			= mysqli_fetch_assoc($rslt);
$bannerText1	= $row["bannerText1"];
$bannerText2	= $row["bannerText2"];
$bannerImage	= $row["bannerImage"];
$active			= $row["activeStatus"];
$bannerLink		= $row["bannerLink"];
$showCaption	= $row["showCaption"];
$bannerImageAlt	= $row["bannerImageAlt"];
$bannerLinkCaption	= $row["bannerLinkCaption"];
//

// form submit
if(isset($_POST["submit"]))
{
	$active			= $_POST["active"];
	$showCaption	= $_POST["showCaption"];
	$bannerText1		= mysqli_real_escape_string($con,$_POST["bannerText1"]);
	$bannerText2	= mysqli_real_escape_string($con,$_POST["bannerText2"]);
	$bannerLink		= mysqli_real_escape_string($con,$_POST["bannerLink"]);
	$bannerImageAlt		= mysqli_real_escape_string($con,$_POST["bannerImageAlt"]);
	$bannerLinkCaption		= mysqli_real_escape_string($con,$_POST["bannerLinkCaption"]);
	
	/* Image Upload Start */
	$image = new UploadImage\Image($_FILES);
	$image->setLocation("../uploads/images/banners");
	if($image["bannerImage"]){
		$upload = $image->upload(); 
		if($upload){
			$bannerImage=$image->getName().".".$image->getMime();
		}else{
			echo $image["error"]; 
		}
	}
	/* Image upload Ends */	

	/* update table*/
	mysqli_query($con,"update tbl_banners set bannerImage='".$bannerImage."',bannerImageAlt='".$bannerImageAlt."',bannerText1='".$bannerText1."',bannerLink='".$bannerLink."',bannerText2='".$bannerText2."',activeStatus='".$active."',showCaption='".$showCaption."',updatedOn=NOW(),bannerLinkCaption='".$bannerLinkCaption."' where bannerId='".$editId."'") ;
	echo "<script>location.href = 'edit-banner.php?id=$editId';</script>";																		

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
				<h5 class="widget-name"><i class="icon-picture"></i>Slider Image </h5>
				<form id="validate" class="form-horizontal" action="" enctype="multipart/form-data" method="post">
	                <fieldset>

	                    <!-- Form validation -->
	                    <div class="widget">
	                    	<div class="well row-fluid">								
                                <div class="control-group">
	                                <label class="control-label">Upload Image:<br><?php echo image_size('home_slider'); ?></label>
	                                <div class="controls">
                                        <img src="../uploads/images/banners/<?php echo $bannerImage;?>"  width="150" />
	                                    <input type="file" name="bannerImage" multiple id="bannerImage" class="validate[custom[images]]">
                                        <span style="color:red;"><?php if(isset($_SESSION["err"])) {echo $_SESSION["err"]; unset($_SESSION["err"]);}?></span>
	                                </div>
									<br clear="all"/>
									<div class="controls">
										<label>Alt Tag : <input type="text" value="<?php echo $bannerImageAlt;?>" class="validate[] input-xlarge" name="bannerImageAlt" id="bannerImageAlt"/></label>
									</div>
	                            </div>
                                <div class="control-group ">
	                                <label class="control-label">Slider Caption 1:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $bannerText1;?>" class="validate[] input-xxlarge" name="bannerText1" id="bannerText1"/>
	                                </div>
	                            </div>
								<div class="control-group ">
	                                <label class="control-label">Slider Caption 2:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $bannerText2;?>" class="validate[] input-xxlarge" name="bannerText2" id="bannerText2"/>
	                                </div>
	                            </div>
<div class="control-group ">
<label class="control-label">Categories:</label>
<div class="controls">
<?php 
$rslt=mysqli_query($con,"select * from tbl_category where activeStatus=1");
while($row=mysqli_fetch_assoc($rslt)){ ?>   
<?php if ($row['showBanner']!=1){?>    
<a href="show.php?id=<?php echo $row['id'];?>&eid=<?php echo $editId;?>"><img src="images/unchecked.png" width="10px"> <?php echo $row['categoryName'];?></a>&nbsp;&nbsp;
<?php } else { ?>
<a href="hide.php?id=<?php echo $row['id'];?>&eid=<?php echo $editId;?>"><img src="images/checked.png" width="10px"> <?php echo $row['categoryName'];?></a>&nbsp;&nbsp;
<?php } }?>
</div>
</div>
								<div class="control-group hide">
	                                <label class="control-label">Banner Button Caption:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $bannerLinkCaption;?>" class="validate[] input-xxlarge" name="bannerLinkCaption" id="bannerLinkCaption"/>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Banner Link:</label>
	                                <div class="controls">
	                                    <input type="text" value="<?php echo $absolutePath;?>" readonly class="validate[] input-xlarge"/>
	                                    <input type="text" value="<?php echo $bannerLink;?>" class="validate[] input-xlarge" name="bannerLink" id="bannerLink"/>
	                                </div>
	                            </div>
                                <div class="control-group hide">
	                                <label class="control-label">Show Caption: <span class="text-error">*</span></label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($showCaption == 1) {echo "checked";}?>  name="showCaption" id="active" value="1" data-prompt-position="topLeft:-1,-5"/>
											Show
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($showCaption == 0) {echo "checked";}?> name="showCaption" id="inactive" value="0" data-prompt-position="topLeft:-1,-5"/>
											Hide
										</label>
	                                </div>
	                            </div>
								<div class="control-group hide">
	                                <label class="control-label">Active:</label>
	                                <div class="controls">

										<label class="radio inline">
											<input class="styled" type="radio" <?php if($active == 1) {echo "checked";}?> checked name="active" id="active" value="1" data-prompt-position="topLeft:-1,-5"/>
											Active
										</label>
										<label class="radio inline">
											<input class="styled" type="radio" <?php if($active == 0) {echo "checked";}?> name="active" id="inactive" value="0" data-prompt-position="topLeft:-1,-5"/>
											Inactive
										</label>
	                                </div>
	                            </div>
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
                
                <!-- form submission -->
   
                <!-- /form submission -->             
		    </div>
		    <!-- /content wrapper -->

		</div>
		<!-- /content -->

	</div>
	<!-- /content container -->


	<!-- Footer -->
	<?php include_once('footer.php'); ?>
	<!-- /footer -->

</body>
</html>
