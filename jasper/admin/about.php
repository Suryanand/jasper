<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

// get about details
$seoSet=0; 
$rslt=mysqli_query($con,"select * from tbl_information") or die(mysqli_error($con));
if(mysqli_num_rows($rslt)>0)
{
	while($row=mysqli_fetch_array($rslt))
	{
		$flag=1; // get about details
		$aboutText=$row['aboutText'];
		$history=$row['ourHistory'];
		$vision=$row['ourVision'];
	}
}
else
{
	$flag=0; // about details not saved
}

//get seo details
$rslt=mysqli_query($con,"select * from tbl_seo where seoFor='about'");
if(mysqli_num_rows($rslt)>0)
{
	$seoSet=1;
	while($row=mysqli_fetch_array($rslt))
	{
		$metaDescription=$row['metaDescription'];
		$metaKeywords=$row['metaKeywords'];
		$titleTag=$row['titleTag'];
	}
}

// about form submit
if(isset($_POST["submit"]))
{
	$aboutText=$_POST["aboutText"];
	$titleTag=$_POST["titleTag"];
	$metaDescription=$_POST["metaDescription"];
	$metaKeywords=$_POST["metaKeywords"];						
	$history=$_POST["history"];
	$vision=$_POST["vision"];
	if($seoSet==0)
	{	//new seo to table
		mysqli_query($con,"insert into tbl_seo (titleTag,metaDescription,metaKeywords,seoFor)values('$titleTag','$metaDescription','$metaKeywords','about')") or die(mysqli_error($con));
	}
	else
	{
		// update seo details
		mysqli_query($con,"update tbl_seo set titleTag='$titleTag',metaDescription='$metaDescription',metaKeywords='$metaKeywords' where seoFor='about'") or die(mysqli_error($con));
	}						
	if($flag==0)
	{ // new about details
		mysqli_query($con,"insert into tbl_information (aboutText,ourHistory,ourVision)values('$aboutText','$history','$vision')") or die(mysqli_error($con));
		$_SESSION["response"]="About Details Saved";
	}
	else
	{ // update about details
		mysqli_query($con,"update tbl_information set aboutText='$aboutText',ourHistory='$history',ourVision='$vision'");	
		$_SESSION["response"]="About Details Updated";
	}
	echo "<script>location.href = 'about.php'</script>;";																		
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
	                        <div class="navbar"><div class="navbar-inner"><h6>About</h6></div></div>
	                    	<div class="well row-fluid">                                
								<div class="control-group">
	                                <label class="control-label">Welcome Text:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="aboutText" class="validate[required] span12"><?php if($flag==1) echo $aboutText; ?></textarea>
	                                </div>
	                            </div>
                                <div class="control-group">
	                                <label class="control-label">Our History:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="history" class="validate[required] span12"><?php if($flag==1) echo $history; ?></textarea>
	                                </div>
	                            </div>
								<div class="control-group">
	                                <label class="control-label">Our Vision:</label>
	                                <div class="controls">
	                                    <textarea rows="5" cols="5" name="vision" class="validate[required] span12"><?php if($flag==1) echo $vision; ?></textarea>
	                                </div>
	                            </div>
                                <div class="navbar"><div class="navbar-inner"><h6>SEO</h6></div></div>
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
	CKEDITOR.replace('history');
	CKEDITOR.replace('vision');
	</script>
</body>
</html>
