<?php 
include("session.php"); /*Check for session is set or not if not redirect to login page */
include("config.php"); /* Connection String*/
include('get-user.php'); /* Geting logged in user details*/

// get about details
$seoSet=0; 
$rslt=mysqli_query($con,"select * from tbl_settings") or die(mysqli_error($con));
if(mysqli_num_rows($rslt)>0)
{
	while($row=mysqli_fetch_array($rslt))
	{
		$flag=1; // get about details
		$brochure=$row['brochure']; 
	}
}
else
{
	$flag=0; // about details not saved
}


// about form submit
if(isset($_POST["submit"]))
{
	$path_to_image_directory = '../images/';
	$filename = "brochure";
	if(isset($_FILES['brochure']) && !empty($_FILES['brochure']['name'])) 
	{     
		if(preg_match('/[.](pdf)|(doc)|(docx)$/', $_FILES['brochure']['name'])) 
		{ 
			$path = $_FILES['brochure']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);		
			$filename = $filename.".".$ext;	
			$source = $_FILES['brochure']['tmp_name'];  
			$target = $path_to_image_directory . $filename;
			$brochure = $filename;
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
						
	if($flag==0)
	{ // new about details
		mysqli_query($con,"insert into tbl_settings (brochure)values('$filename')") or die(mysqli_error($con));
		$_SESSION["response"]="Brochure Saved";
	}
	else
	{ // update about details
		mysqli_query($con,"update tbl_settings set brochure='$brochure'");	
		$_SESSION["response"]="Brochure Updated";
	}
	echo "<script>location.href = 'brochure.php'</script>;";																		
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
	                        <div class="navbar"><div class="navbar-inner"><h6>Brochure</h6></div></div>
	                    	<div class="well row-fluid">                                
								
                                <div class="control-group">
	                                <label class="control-label">Upload Brochure:</label>
	                                <div class="controls">
	                                    <?php if($flag==1 && !empty($brochure)) {echo $brochure; }?>&nbsp;&nbsp;
										<input type="file" name="brochure" id="brochure" class="validate[]">									
	                                </div>
	                            </div>
                                
	                            <div class="form-actions align-right">
	                                <button type="submit" class="btn btn-info" name="submit">Submit</button>
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
	</script>
</body>
</html>
